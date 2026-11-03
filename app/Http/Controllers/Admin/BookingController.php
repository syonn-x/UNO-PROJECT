<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Notification;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['item.images', 'renter', 'review']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('start_date')) {
            $query->whereDate('start_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('end_date', '<=', $request->end_date);
        }

        $bookings = $query->latest()->paginate(10);

        return view('admin.bookings.index', compact('bookings'));
    }

    public function updateStatus(Request $request, int $id)
    {
        $request->validate(['status' => 'required|in:pending,confirmed,completed,cancelled']);
        $booking = Booking::with(['item', 'renter'])->findOrFail($id);
        $oldStatus = $booking->status;
        $booking->update(['status' => $request->status]);

        // Send notification to renter
        Notification::create([
            'user_id' => $booking->renter_id,
            'title' => 'Update Status Sewa #'.$booking->id,
            'message' => "Status sewa untuk {$booking->item->name} telah diperbarui menjadi ".strtoupper($request->status).'.',
            'type' => 'booking_'.$request->status,
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Status booking #'.$booking->id.' berhasil diubah menjadi '.$request->status,
                'status' => $booking->status,
            ]);
        }

        return back()->with('success', 'Status booking #'.$booking->id.' berhasil diubah!');
    }

    public function destroy(Request $request, int $id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Data booking berhasil dihapus!']);
        }

        return back()->with('success', 'Data booking berhasil dihapus!');
    }
}
