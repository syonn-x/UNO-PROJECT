<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::withCount('items')->latest()->paginate(10);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'data' => $categories]);
        }

        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:categories,name',
            'description' => 'nullable|string',
        ]);

        $category = Category::create($validated);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Kategori berhasil ditambahkan!', 'data' => $category]);
        }

        return back()->with('success', 'Kategori '.$category->name.' berhasil ditambahkan!');
    }

    public function update(Request $request, int $id)
    {
        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:categories,name,'.$category->id,
            'description' => 'nullable|string',
        ]);

        $category->update($validated);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Kategori berhasil diperbarui!', 'data' => $category]);
        }

        return back()->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy(Request $request, int $id)
    {
        $category = Category::findOrFail($id);

        if ($category->items()->count() > 0) {
            $msg = 'Kategori tidak dapat dihapus karena masih memiliki barang rental.';
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $msg], 400);
            }

            return back()->with('error', $msg);
        }

        $category->delete();

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Kategori berhasil dihapus!']);
        }

        return back()->with('success', 'Kategori berhasil dihapus!');
    }
}
