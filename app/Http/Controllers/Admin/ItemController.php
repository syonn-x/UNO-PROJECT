<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Item;
use App\Models\ItemImage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $query = Item::with(['category', 'owner', 'images'])->withCount('bookings');

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                    ->orWhere('location', 'like', "%{$s}%");
            });
        }

        $items = $query->latest()->paginate(10);
        $categories = Category::all();
        $owners = User::where('status', 'active')->get();

        return view('admin.items.index', compact('items', 'categories', 'owners'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'owner_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:150',
            'description' => 'required|string',
            'price_per_day' => 'required|numeric|min:0',
            'condition' => 'required|in:new,like_new,good,fair',
            'location' => 'required|string|max:255',
            'status' => 'required|in:available,unavailable,hidden',
            'image_url' => 'nullable|url',
        ]);

        $item = Item::create($validated);

        if ($request->filled('image_url')) {
            ItemImage::create([
                'item_id' => $item->id,
                'image_url' => $request->image_url,
            ]);
        } else {
            ItemImage::create([
                'item_id' => $item->id,
                'image_url' => 'https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?w=800&auto=format&fit=crop&q=80',
            ]);
        }

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Barang rental berhasil ditambahkan!']);
        }

        return back()->with('success', 'Barang rental '.$item->name.' berhasil ditambahkan!');
    }

    public function update(Request $request, int $id)
    {
        $item = Item::findOrFail($id);

        $validated = $request->validate([
            'owner_id' => 'sometimes|exists:users,id',
            'category_id' => 'sometimes|exists:categories,id',
            'name' => 'sometimes|string|max:150',
            'description' => 'sometimes|string',
            'price_per_day' => 'sometimes|numeric|min:0',
            'condition' => 'sometimes|in:new,like_new,good,fair',
            'location' => 'sometimes|string|max:255',
            'status' => 'sometimes|in:available,unavailable,hidden',
        ]);

        $item->update($validated);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Barang berhasil diperbarui!', 'data' => $item]);
        }

        return back()->with('success', 'Barang rental berhasil diperbarui!');
    }

    public function updateStatus(Request $request, int $id)
    {
        $request->validate(['status' => 'required|in:available,unavailable,hidden']);
        $item = Item::findOrFail($id);
        $item->update(['status' => $request->status]);

        return response()->json(['success' => true, 'message' => 'Status barang berhasil diubah ke '.$request->status]);
    }

    public function destroy(Request $request, int $id)
    {
        $item = Item::findOrFail($id);
        $name = $item->name;

        try {
            DB::transaction(function () use ($item) {
                $item->delete();
            });

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Barang rental "'.$name.'" berhasil dihapus!',
                ]);
            }

            return back()->with('success', 'Barang rental "'.$name.'" berhasil dihapus!');
        } catch (\Throwable $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus barang: '.$e->getMessage(),
                ], 500);
            }

            return back()->with('error', 'Gagal menghapus barang: '.$e->getMessage());
        }
    }
}
