<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Booking;
use App\Models\Review;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewController extends BaseApiController
{
    /**
     * List reviews for an item or all reviews.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Review::with(['user:id,name,profile_photo', 'item:id,name']);

        if ($request->filled('item_id')) {
            $query->where('item_id', $request->item_id);
        }

        $reviews = $query->latest()->paginate(10);

        return $this->sendResponse($reviews, 'Daftar ulasan berhasil dimuat');
    }

    /**
     * Store new review.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'booking_id' => 'required|exists:bookings,id',
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error', $validator->errors(), 422);
        }

        $booking = Booking::find($request->booking_id);

        if ($booking->renter_id !== $request->user()->id) {
            return $this->sendError('Anda hanya dapat memberi ulasan pada pesanan Anda sendiri', [], 403);
        }

        if ($booking->status !== 'completed') {
            return $this->sendError('Ulasan hanya dapat diberikan setelah masa sewa selesai (status completed)', [], 400);
        }

        // Check if review already exists
        if (Review::where('booking_id', $booking->id)->exists()) {
            return $this->sendError('Anda sudah memberikan ulasan untuk pesanan ini', [], 400);
        }

        $review = Review::create([
            'booking_id' => $booking->id,
            'item_id' => $booking->item_id,
            'user_id' => $request->user()->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        $review->load(['user:id,name,profile_photo', 'item:id,name']);

        return $this->sendResponse($review, 'Terima kasih! Ulasan berhasil dikirim.', 201);
    }
}
