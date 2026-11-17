<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Booking;
use App\Models\Item;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookingController extends BaseApiController
{
    /**
     * List user bookings.
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        $query = Booking::with(['item.images', 'item.category', 'renter:id,name,email,phone', 'review']);

        if (! $user->isAdmin()) {
            $query->where('renter_id', $user->id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $bookings = $query->latest()->paginate($request->get('per_page', 10));

        return $this->sendResponse($bookings, 'Daftar transaksi sewa berhasil diambil');
    }

    /**
     * Store new booking (Rent item).
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'item_id' => 'required|exists:items,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error', $validator->errors(), 422);
        }

        $item = Item::find($request->item_id);

        if ($item->status !== 'available') {
            return $this->sendError('Barang saat ini sedang tidak tersedia untuk disewa', [], 400);
        }

        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);
        $totalDays = max(1, $startDate->diffInDays($endDate) + 1);
        $totalPrice = $totalDays * $item->price_per_day;

        $booking = Booking::create([
            'item_id' => $item->id,
            'renter_id' => $request->user()->id,
            'start_date' => $startDate->toDateString(),
            'end_date' => $endDate->toDateString(),
            'total_days' => $totalDays,
            'total_price' => $totalPrice,
            'status' => 'pending',
            'notes' => $request->notes,
        ]);

        // Notify item owner
        Notification::create([
            'user_id' => $item->owner_id,
            'title' => 'Permintaan Sewa Baru',
            'message' => "Pengguna {$request->user()->name} mengajukan sewa untuk unit {$item->name} selama {$totalDays} hari.",
            'type' => 'booking_new',
        ]);

        $booking->load(['item.images', 'item.category', 'renter']);

        return $this->sendResponse($booking, 'Pengajuan sewa berhasil dibuat!', 201);
    }

    /**
     * Show booking detail.
     */
    public function show(Request $request, int $id): JsonResponse
    {
        $booking = Booking::with(['item.images', 'item.owner', 'renter', 'review'])->find($id);

        if (! $booking) {
            return $this->sendError('Data booking tidak ditemukan', [], 404);
        }

        $user = $request->user();
        if (! $user->isAdmin() && $booking->renter_id !== $user->id && $booking->item->owner_id !== $user->id) {
            return $this->sendError('Anda tidak memiliki akses ke data booking ini', [], 403);
        }

        return $this->sendResponse($booking, 'Detail booking berhasil dimuat');
    }

    /**
     * Cancel booking.
     */
    public function cancel(Request $request, int $id): JsonResponse
    {
        $booking = Booking::find($id);

        if (! $booking) {
            return $this->sendError('Data booking tidak ditemukan', [], 404);
        }

        $user = $request->user();
        if (! $user->isAdmin() && $booking->renter_id !== $user->id) {
            return $this->sendError('Anda tidak memiliki izin membatalkan booking ini', [], 403);
        }

        if ($booking->status !== 'pending') {
            return $this->sendError('Hanya pesanan berstatus pending yang dapat dibatalkan', [], 400);
        }

        $booking->update(['status' => 'cancelled']);

        return $this->sendResponse($booking, 'Pesanan sewa berhasil dibatalkan');
    }
}
