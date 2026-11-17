<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::withCount(['items', 'bookings']);

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->get('owner_status') === 'pending' || $request->get('tab') === 'kyc') {
            $query->whereNotNull('id_card_photo')->where('is_verified_owner', false);
        } elseif ($request->get('owner_status') === 'approved') {
            $query->where(function ($q) {
                $q->where('role', 'owner')->orWhere('is_verified_owner', true);
            });
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                    ->orWhere('email', 'like', "%{$s}%")
                    ->orWhere('phone', 'like', "%{$s}%")
                    ->orWhere('store_name', 'like', "%{$s}%");
            });
        }

        $users = $query->latest()->paginate(10)->withQueryString();

        $pendingKycCount = User::whereNotNull('id_card_photo')->where('is_verified_owner', false)->count();
        $totalOwnersCount = User::where(function ($q) {
            $q->where('role', 'owner')->orWhere('is_verified_owner', true);
        })->count();
        $suspendedCount = User::where('status', 'suspended')->count();

        return view('admin.users.index', compact('users', 'pendingKycCount', 'totalOwnersCount', 'suspendedCount'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150|unique:users,email',
            'password' => 'required|string|min:6',
            'phone' => 'nullable|string|max:25',
            'role' => 'required|in:admin,user',
            'status' => 'required|in:active,inactive,suspended',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['profile_photo'] = 'https://ui-avatars.com/api/?name='.urlencode($validated['name']).'&background=0D8ABC&color=fff';

        $user = User::create($validated);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Pengguna berhasil ditambahkan!']);
        }

        return back()->with('success', 'Pengguna '.$user->name.' berhasil ditambahkan!');
    }

    public function updateStatus(Request $request, int $id)
    {
        $request->validate(['status' => 'required|in:active,inactive,suspended']);
        $user = User::findOrFail($id);
        $user->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Status user '.$user->name.' berhasil diubah menjadi '.$request->status,
        ]);
    }

    public function updateRole(Request $request, int $id)
    {
        $request->validate(['role' => 'required|in:admin,user']);
        $user = User::findOrFail($id);
        $user->update(['role' => $request->role]);

        return response()->json([
            'success' => true,
            'message' => 'Role user '.$user->name.' berhasil diubah menjadi '.$request->role,
        ]);
    }

    public function verifyOwner(Request $request, int $id)
    {
        $request->validate([
            'action' => 'required|in:approve,reject',
            'reason' => 'nullable|string|max:500',
        ]);

        $user = User::findOrFail($id);

        if ($request->action === 'approve') {
            $user->update([
                'role' => 'owner',
                'is_verified_owner' => true,
                'store_name' => $user->store_name ?: ($user->name.' Rental'),
            ]);
            $msg = 'Mitra Owner '.$user->name.' ('.($user->store_name ?: ($user->name.' Rental')).') berhasil disetujui & diverifikasi!';
        } else {
            $user->update([
                'is_verified_owner' => false,
                'id_card_photo' => null,
            ]);
            $msg = 'Pengajuan Mitra Owner '.$user->name.' ditolak. Berkas KTP telah direset.';
        }

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => $msg]);
        }

        return back()->with('success', $msg);
    }

    public function destroy(Request $request, int $id)
    {
        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Pengguna berhasil dihapus!']);
        }

        return back()->with('success', 'Pengguna berhasil dihapus!');
    }
}
