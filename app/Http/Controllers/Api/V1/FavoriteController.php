<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Favorite;
use App\Models\Item;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FavoriteController extends BaseApiController
{
    /**
     * List user favorites.
     */
    public function index(Request $request): JsonResponse
    {
        $favorites = Favorite::with(['item.images', 'item.category', 'item.owner'])
            ->where('user_id', $request->user()->id)
            ->latest()
            ->paginate(12);

        return $this->sendResponse($favorites, 'Daftar favorit berhasil dimuat');
    }

    /**
     * Toggle favorite item.
     */
    public function toggle(Request $request): JsonResponse
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
        ]);

        $userId = $request->user()->id;
        $itemId = $request->item_id;

        $favorite = Favorite::where('user_id', $userId)->where('item_id', $itemId)->first();

        if ($favorite) {
            $favorite->delete();

            return $this->sendResponse(['is_favorited' => false], 'Item dihapus dari favorit');
        }

        Favorite::create([
            'user_id' => $userId,
            'item_id' => $itemId,
        ]);

        return $this->sendResponse(['is_favorited' => true], 'Item ditambahkan ke favorit');
    }
}
