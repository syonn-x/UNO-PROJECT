<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Item;
use App\Models\ItemImage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ItemController extends BaseApiController
{
    /**
     * List items with rich filtering and search.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Item::with(['category', 'owner:id,name,email,phone,profile_photo', 'images'])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating');

        // Search query
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Condition filter
        if ($request->filled('condition')) {
            $query->where('condition', $request->condition);
        }

        // Status filter (default to 'available' if public)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
            $query->where('status', 'available');
        }

        // Location filter
        if ($request->filled('location')) {
            $query->where('location', 'like', "%{$request->location}%");
        }

        // Sorting
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price_per_day', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price_per_day', 'desc');
                break;
            case 'popular':
                $query->orderBy('reviews_count', 'desc');
                break;
            default:
                $query->latest();
                break;
        }

        $items = $query->paginate($request->get('per_page', 12));

        return $this->sendResponse($items, 'Daftar item rental berhasil dimuat');
    }

    /**
     * Show item detail.
     */
    public function show(int $id): JsonResponse
    {
        $item = Item::with([
            'category',
            'owner:id,name,email,phone,profile_photo,created_at',
            'images',
            'availability' => function ($q) {
                $q->where('end_date', '>=', now()->toDateString())->orderBy('start_date');
            },
            'reviews.user:id,name,profile_photo',
        ])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->find($id);

        if (! $item) {
            return $this->sendError('Item tidak ditemukan', [], 404);
        }

        return $this->sendResponse($item, 'Detail item rental berhasil dimuat');
    }

    /**
     * Store new rental item.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:150',
            'description' => 'required|string',
            'price_per_day' => 'required|numeric|min:0',
            'condition' => 'required|in:new,like_new,good,fair',
            'location' => 'required|string|max:255',
            'images' => 'nullable|array',
            'images.*' => 'string',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error', $validator->errors(), 422);
        }

        $item = Item::create([
            'owner_id' => $request->user()->id,
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'price_per_day' => $request->price_per_day,
            'condition' => $request->condition,
            'location' => $request->location,
            'status' => 'available',
        ]);

        if ($request->has('images') && is_array($request->images)) {
            foreach ($request->images as $url) {
                ItemImage::create([
                    'item_id' => $item->id,
                    'image_url' => $url,
                ]);
            }
        } else {
            // Default placeholder image
            ItemImage::create([
                'item_id' => $item->id,
                'image_url' => 'https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?w=800&auto=format&fit=crop&q=80',
            ]);
        }

        $item->load(['category', 'owner', 'images']);

        return $this->sendResponse($item, 'Barang rental berhasil didaftarkan!', 201);
    }

    /**
     * Update item.
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $item = Item::find($id);

        if (! $item) {
            return $this->sendError('Item tidak ditemukan', [], 404);
        }

        // Check ownership or admin
        if ($item->owner_id !== $request->user()->id && ! $request->user()->isAdmin()) {
            return $this->sendError('Anda tidak memiliki izin mengedit barang ini', [], 403);
        }

        $validator = Validator::make($request->all(), [
            'category_id' => 'sometimes|exists:categories,id',
            'name' => 'sometimes|string|max:150',
            'description' => 'sometimes|string',
            'price_per_day' => 'sometimes|numeric|min:0',
            'condition' => 'sometimes|in:new,like_new,good,fair',
            'location' => 'sometimes|string|max:255',
            'status' => 'sometimes|in:available,unavailable,hidden',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error', $validator->errors(), 422);
        }

        $item->update($request->only([
            'category_id',
            'name',
            'description',
            'price_per_day',
            'condition',
            'location',
            'status',
        ]));

        $item->load(['category', 'owner', 'images']);

        return $this->sendResponse($item, 'Barang rental berhasil diperbarui');
    }

    /**
     * Delete item.
     */
    public function destroy(Request $request, int $id): JsonResponse
    {
        $item = Item::find($id);

        if (! $item) {
            return $this->sendError('Item tidak ditemukan', [], 404);
        }

        if ($item->owner_id !== $request->user()->id && ! $request->user()->isAdmin()) {
            return $this->sendError('Anda tidak memiliki izin menghapus barang ini', [], 403);
        }

        $item->delete();

        return $this->sendResponse(null, 'Barang rental berhasil dihapus');
    }
}
