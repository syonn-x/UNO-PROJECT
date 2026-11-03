<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Notification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationController extends BaseApiController
{
    /**
     * List user notifications.
     */
    public function index(Request $request): JsonResponse
    {
        $notifications = Notification::where('user_id', $request->user()->id)
            ->latest()
            ->paginate(15);

        $unreadCount = Notification::where('user_id', $request->user()->id)
            ->where('is_read', false)
            ->count();

        return $this->sendResponse([
            'notifications' => $notifications,
            'unread_count' => $unreadCount,
        ], 'Daftar notifikasi berhasil dimuat');
    }

    /**
     * Mark notification as read.
     */
    public function markAsRead(Request $request, int $id): JsonResponse
    {
        $notification = Notification::where('user_id', $request->user()->id)->find($id);

        if (! $notification) {
            return $this->sendError('Notifikasi tidak ditemukan', [], 404);
        }

        $notification->update(['is_read' => true]);

        return $this->sendResponse($notification, 'Notifikasi telah ditandai dibaca');
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead(Request $request): JsonResponse
    {
        Notification::where('user_id', $request->user()->id)->update(['is_read' => true]);

        return $this->sendResponse(null, 'Semua notifikasi telah ditandai dibaca');
    }
}
