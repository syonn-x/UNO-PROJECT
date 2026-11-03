<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\SafetyReport;
use App\Models\SafetyReportMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SafetyReportController extends Controller
{
    /**
     * Display a listing of fraud complaints & safety messages (Pusat Aduan Penipuan).
     */
    public function index(Request $request)
    {
        $query = SafetyReport::with(['reporter', 'reportedUser', 'booking.item', 'messages.user']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('severity')) {
            $query->where('severity', $request->severity);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('report_code', 'like', "%{$search}%")
                    ->orWhere('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhereHas('reporter', function ($sub) use ($search) {
                        $sub->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    })
                    ->orWhereHas('reportedUser', function ($sub) use ($search) {
                        $sub->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        $reports = $query->latest()->paginate(10)->withQueryString();

        // Metrics for summary tabs
        $totalCount = SafetyReport::count();
        $pendingCount = SafetyReport::where('status', 'pending')->count();
        $investigatingCount = SafetyReport::where('status', 'investigating')->count();
        $resolvedCount = SafetyReport::where('status', 'resolved')->count();
        $actionTakenCount = SafetyReport::where('status', 'action_taken')->count();

        return view('admin.safety.index', compact(
            'reports',
            'totalCount',
            'pendingCount',
            'investigatingCount',
            'resolvedCount',
            'actionTakenCount'
        ));
    }

    /**
     * Display the specified fraud report thread & incident investigation.
     */
    public function show($id)
    {
        $report = SafetyReport::with([
            'reporter',
            'reportedUser',
            'booking.item.owner',
            'messages.user',
        ])->findOrFail($id);

        return view('admin.safety.show', compact('report'));
    }

    /**
     * Balas pesan aduan penipuan ke korban dan update investigasi.
     */
    public function replyMessage(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string|max:3000',
            'attachment' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'status' => 'nullable|in:pending,investigating,resolved,action_taken',
            'suspend_reported_user' => 'nullable|boolean',
        ]);

        $report = SafetyReport::with(['reporter', 'reportedUser'])->findOrFail($id);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filename = 'admin_reply_'.time().'_'.Str::random(8).'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/evidence'), $filename);
            $attachmentPath = 'uploads/evidence/'.$filename;
        }

        // Simpan pesan balasan resmi admin
        SafetyReportMessage::create([
            'safety_report_id' => $report->id,
            'user_id' => auth()->id(),
            'message' => $request->message,
            'attachment' => $attachmentPath,
            'is_admin' => true,
        ]);

        // Update status kasus jika ditentukan
        if ($request->filled('status')) {
            $report->status = $request->status;
        } else {
            // Default: jika admin membalas, jadikan sedang ditinjau
            if ($report->status === 'pending') {
                $report->status = 'investigating';
            }
        }

        // Bekukan akun jika dicentang
        if ($request->boolean('suspend_reported_user') && $report->reportedUser) {
            $report->reportedUser->update(['status' => 'suspended']);
            $report->status = 'action_taken';
            $report->resolved_at = now();

            // Tambahkan catatan pesan sistem
            SafetyReportMessage::create([
                'safety_report_id' => $report->id,
                'user_id' => auth()->id(),
                'message' => "🚨 [TINDAKAN TEGAS ADMIN]: Akun terlapor penipuan ({$report->reportedUser->name}) telah resmi DIBEKUKAN (SUSPENDED). Pelaku tidak dapat lagi melakukan transaksi sewa.",
                'is_admin' => true,
            ]);
        }

        if (in_array($report->status, ['resolved', 'action_taken'])) {
            $report->resolved_at = now();
        }

        $report->save();

        // Notifikasi ke korban
        if ($report->reporter_id) {
            Notification::create([
                'user_id' => $report->reporter_id,
                'title' => "Pesan Balasan dari Admin Pusat (#{$report->report_code})",
                'message' => 'Tim Admin Pusat telah membalas aduan penipuan Anda: "'.Str::limit($request->message, 80).'"',
                'type' => 'safety_update',
            ]);
        }

        return redirect()->route('admin.messages.show', $report->id)
            ->with('success', 'Balasan pesan resmi berhasil dikirimkan ke korban penipuan.');
    }

    /**
     * 1-Klik Bekukan akun pelaku penipuan (Suspend Fraud User).
     */
    public function suspendFraudUser(Request $request, $id)
    {
        $report = SafetyReport::with('reportedUser')->findOrFail($id);

        if (! $report->reportedUser) {
            return back()->with('error', 'Data pengguna yang dilaporkan tidak ditemukan.');
        }

        $report->reportedUser->update(['status' => 'suspended']);
        $report->status = 'action_taken';
        $report->resolved_at = now();
        $report->save();

        // Tambahkan pengumuman di thread pesan
        SafetyReportMessage::create([
            'safety_report_id' => $report->id,
            'user_id' => auth()->id(),
            'message' => "🚨 [TINDAKAN TEGAS ADMIN]: Akun pelaku ({$report->reportedUser->name}) telah resmi DIBEKUKAN PERMANEN (SUSPENDED) oleh Admin Pusat demi perlindungan keamanan ekosistem.",
            'is_admin' => true,
        ]);

        if ($report->reporter_id) {
            Notification::create([
                'user_id' => $report->reporter_id,
                'title' => "Akun Pelaku Penipuan Resmi Dibekukan (#{$report->report_code})",
                'message' => "Admin Pusat telah mengambil tindakan sanksi: Akun {$report->reportedUser->name} telah dibekukan dari sistem U.N.O.",
                'type' => 'safety_update',
            ]);
        }

        return redirect()->route('admin.messages.show', $report->id)
            ->with('success', "Akun pelaku ({$report->reportedUser->name}) berhasil dibekukan (SUSPENDED).");
    }

    /**
     * Update the investigation status and administrative security action.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,investigating,resolved,action_taken',
            'admin_notes' => 'nullable|string|max:1000',
            'suspend_reported_user' => 'nullable|boolean',
        ]);

        $report = SafetyReport::with('reportedUser')->findOrFail($id);

        $report->status = $request->status;
        if ($request->filled('admin_notes')) {
            $report->admin_notes = $request->admin_notes;
        }

        if (in_array($request->status, ['resolved', 'action_taken'])) {
            $report->resolved_at = now();
        }

        // Suspend user if requested or if action_taken with toggle
        if ($request->boolean('suspend_reported_user') && $report->reportedUser) {
            $report->reportedUser->update(['status' => 'suspended']);
            $report->status = 'action_taken';
            $report->resolved_at = now();
        }

        $report->save();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Status laporan keamanan berhasil diperbarui.',
                'status' => $report->status,
                'badge' => $report->status_badge,
            ]);
        }

        return redirect()->route('admin.safety-reports.show', $report->id)
            ->with('success', 'Status investigasi laporan keamanan berhasil diperbarui.');
    }

    /**
     * Print safety report summary / official incident minutes (Berita Acara).
     */
    public function print(Request $request)
    {
        $query = SafetyReport::with(['reporter', 'reportedUser', 'booking.item']);

        if ($request->filled('id')) {
            $query->where('id', $request->id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $reports = $query->latest()->get();

        return view('admin.safety.print', compact('reports'));
    }
}
