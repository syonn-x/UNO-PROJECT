<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Sales & Revenue Report.
     */
    public function sales(Request $request)
    {
        $startDate = $request->get('start_date', now()->subMonths(1)->startOfMonth()->toDateString());
        $endDate = $request->get('end_date', now()->toDateString());
        $status = $request->get('status');
        $categoryId = $request->get('category_id');

        $query = Booking::with(['item.category', 'renter'])
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate);

        if ($status) {
            $query->where('status', $status);
        }

        if ($categoryId) {
            $query->whereHas('item', function ($q) use ($categoryId) {
                $q->where('category_id', $categoryId);
            });
        }

        $allBookings = (clone $query)->get();
        $totalRevenue = (clone $query)->whereIn('status', ['confirmed', 'completed'])->sum('total_price');
        $totalTransactions = $allBookings->count();
        $completedTransactions = $allBookings->where('status', 'completed')->count();
        $totalRentalDays = (clone $query)->whereIn('status', ['confirmed', 'completed'])->sum('total_days');
        $averageOrderValue = $totalTransactions > 0 ? $totalRevenue / max(1, $allBookings->whereIn('status', ['confirmed', 'completed'])->count()) : 0;

        $bookings = $query->latest()->paginate(15);
        $categories = Category::all();

        return view('admin.reports.sales', compact(
            'bookings',
            'categories',
            'totalRevenue',
            'totalTransactions',
            'completedTransactions',
            'totalRentalDays',
            'averageOrderValue',
            'startDate',
            'endDate',
            'status',
            'categoryId'
        ));
    }

    /**
     * Item Occupancy & Inventory Report.
     */
    public function inventory(Request $request)
    {
        $items = Item::with(['category', 'owner'])
            ->withCount(['bookings as total_rentals' => function ($q) {
                $q->whereIn('status', ['confirmed', 'completed']);
            }])
            ->withSum(['bookings as total_earned' => function ($q) {
                $q->whereIn('status', ['confirmed', 'completed']);
            }], 'total_price')
            ->orderBy('total_earned', 'desc')
            ->paginate(15);

        // Category distribution
        $categories = Category::withCount('items')
            ->with(['items.bookings' => function ($q) {
                $q->whereIn('status', ['confirmed', 'completed']);
            }])
            ->get();

        return view('admin.reports.inventory', compact('items', 'categories'));
    }

    /**
     * Printable Report (Official Format with letterhead).
     */
    public function print(Request $request)
    {
        $startDate = $request->get('start_date', now()->subMonths(1)->startOfMonth()->toDateString());
        $endDate = $request->get('end_date', now()->toDateString());
        $status = $request->get('status');

        $query = Booking::with(['item.category', 'renter'])
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate);

        if ($status) {
            $query->where('status', $status);
        }

        $bookings = $query->latest()->get();
        $totalRevenue = $bookings->whereIn('status', ['confirmed', 'completed'])->sum('total_price');
        $totalTransactions = $bookings->count();

        return view('admin.reports.print', compact(
            'bookings',
            'totalRevenue',
            'totalTransactions',
            'startDate',
            'endDate',
            'status'
        ));
    }
}
