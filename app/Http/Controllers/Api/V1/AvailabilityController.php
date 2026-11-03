<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Availability;
use App\Models\Booking;
use App\Models\Item;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AvailabilityController extends BaseApiController
{
    /**
     * Check calendar & availability for an item.
     */
    public function check(Request $request, int $itemId): JsonResponse
    {
        $item = Item::find($itemId);

        if (! $item) {
            return $this->sendError('Item tidak ditemukan', [], 404);
        }

        // Active bookings that occupy this item
        $bookings = Booking::where('item_id', $itemId)
            ->whereIn('status', ['pending', 'confirmed'])
            ->where('end_date', '>=', Carbon::today()->toDateString())
            ->get(['id', 'start_date', 'end_date', 'status']);

        // Blocked schedules in availability table
        $blocked = Availability::where('item_id', $itemId)
            ->where('end_date', '>=', Carbon::today()->toDateString())
            ->get(['id', 'start_date', 'end_date', 'status']);

        return $this->sendResponse([
            'item_id' => $itemId,
            'is_available_now' => $item->status === 'available',
            'bookings' => $bookings,
            'blocked_dates' => $blocked,
        ], 'Data kalender ketersediaan berhasil diambil');
    }
}
