<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Booking;
use App\Models\Category;
use App\Models\Item;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends BaseApiController
{
    /**
     * Get executive summary metrics.
     */
    public function summary(): JsonResponse
    {
        $totalRevenue = Booking::whereIn('status', ['confirmed', 'completed'])->sum('total_price');
        $totalBookings = Booking::count();
        $completedBookings = Booking::where('status', 'completed')->count();
        $pendingBookings = Booking::where('status', 'pending')->count();
        $totalItems = Item::count();
        $totalUsers = User::count();

        // Monthly revenue for the last 6 months
        $driver = DB::getDriverName();
        $dateSql = $driver === 'sqlite' ? 'strftime("%Y-%m", created_at)' : 'DATE_FORMAT(created_at, "%Y-%m")';

        $monthlyRevenue = Booking::select(
            DB::raw("{$dateSql} as month"),
            DB::raw('SUM(total_price) as revenue'),
            DB::raw('COUNT(*) as total_orders')
        )
            ->whereIn('status', ['confirmed', 'completed'])
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->limit(6)
            ->get();

        // Top rented items
        $topItems = Item::with(['category', 'images'])
            ->withCount(['bookings' => function ($q) {
                $q->whereIn('status', ['confirmed', 'completed']);
            }])
            ->orderBy('bookings_count', 'desc')
            ->limit(5)
            ->get();

        // Categories with item counts
        $categoryBreakdown = Category::withCount('items')->get();

        return $this->sendResponse([
            'metrics' => [
                'total_revenue' => (float) $totalRevenue,
                'total_bookings' => $totalBookings,
                'completed_bookings' => $completedBookings,
                'pending_bookings' => $pendingBookings,
                'total_items' => $totalItems,
                'total_users' => $totalUsers,
            ],
            'monthly_revenue' => $monthlyRevenue,
            'top_items' => $topItems,
            'categories' => $categoryBreakdown,
        ], 'Ringkasan laporan berhasil dimuat');
    }

    /**
     * Get transaction report table with filters.
     */
    public function transactions(Request $request): JsonResponse
    {
        $query = Booking::with(['item.category', 'renter']);

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('category_id')) {
            $query->whereHas('item', function ($q) use ($request) {
                $q->where('category_id', $request->category_id);
            });
        }

        $totalRevenue = (clone $query)->whereIn('status', ['confirmed', 'completed'])->sum('total_price');
        $totalTransactions = (clone $query)->count();

        $transactions = $query->latest()->paginate($request->get('per_page', 20));

        return $this->sendResponse([
            'summary' => [
                'total_revenue' => (float) $totalRevenue,
                'total_transactions' => $totalTransactions,
            ],
            'transactions' => $transactions,
        ], 'Data laporan transaksi berhasil dimuat');
    }
}
