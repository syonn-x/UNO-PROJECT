<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Availability;
use App\Models\Item;
use Illuminate\Http\Request;

class AvailabilityController extends Controller
{
    public function index(Request $request)
    {
        $availabilities = Availability::with('item.category')
            ->orderBy('start_date', 'desc')
            ->paginate(12);

        $items = Item::where('status', 'available')->get();

        return view('admin.availability.index', compact('availabilities', 'items'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_id' => 'required|exists:items,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:available,booked,blocked',
        ]);

        Availability::create($validated);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Jadwal ketersediaan berhasil disimpan!']);
        }

        return back()->with('success', 'Jadwal ketersediaan berhasil disimpan!');
    }

    public function destroy(Request $request, int $id)
    {
        $avail = Availability::findOrFail($id);
        $avail->delete();

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Jadwal berhasil dihapus!']);
        }

        return back()->with('success', 'Jadwal berhasil dihapus!');
    }
}
