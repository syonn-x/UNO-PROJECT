<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $notifications = Notification::with('user')->latest()->paginate(15);
        $users = User::all();

        return view('admin.notifications.index', compact('notifications', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'nullable',
            'title' => 'required|string|max:150',
            'message' => 'required|string',
            'type' => 'required|string|max:50',
        ]);

        if ($request->user_id === 'all' || empty($request->user_id)) {
            // Broadcast to all active users
            $allUsers = User::where('status', 'active')->get();
            foreach ($allUsers as $u) {
                Notification::create([
                    'user_id' => $u->id,
                    'title' => $validated['title'],
                    'message' => $validated['message'],
                    'type' => $validated['type'],
                ]);
            }
            $msg = 'Notifikasi berhasil dibroadcast ke semua pengguna ('.$allUsers->count().' user)!';
        } else {
            Notification::create([
                'user_id' => $request->user_id,
                'title' => $validated['title'],
                'message' => $validated['message'],
                'type' => $validated['type'],
            ]);
            $msg = 'Notifikasi berhasil dikirim!';
        }

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => $msg]);
        }

        return back()->with('success', $msg);
    }

    public function destroy(Request $request, int $id)
    {
        $notif = Notification::findOrFail($id);
        $notif->delete();

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Notifikasi berhasil dihapus!']);
        }

        return back()->with('success', 'Notifikasi berhasil dihapus!');
    }
}
