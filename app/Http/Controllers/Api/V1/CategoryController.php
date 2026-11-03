<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryController extends BaseApiController
{
    /**
     * List all categories.
     */
    public function index(): JsonResponse
    {
        $categories = Category::withCount('items')->get();

        return $this->sendResponse($categories, 'Daftar kategori berhasil diambil');
    }

    /**
     * Show single category.
     */
    public function show(int $id): JsonResponse
    {
        $category = Category::with(['items.images', 'items.owner'])->find($id);

        if (! $category) {
            return $this->sendError('Kategori tidak ditemukan', [], 404);
        }

        return $this->sendResponse($category, 'Detail kategori berhasil diambil');
    }
}
