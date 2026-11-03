<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $reviews = Review::with(['user', 'item.category', 'booking'])
            ->latest()
            ->paginate(10);

        return view('admin.reviews.index', compact('reviews'));
    }

    public function destroy(Request $request, int $id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Ulasan berhasil dihapus!']);
        }

        return back()->with('success', 'Ulasan berhasil dihapus!');
    }
}
