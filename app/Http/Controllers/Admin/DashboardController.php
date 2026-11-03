<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Category;
use App\Models\Item;
use App\Models\Review;
use App\Models\SafetyReport;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Display the AdminLTE Dashboard for Security & Users.
     */
    public function index()
    {
        // 1. Data Pengguna Metrics
        $totalUsers = User::count();
        $totalRenters = User::where('role', '!=', 'owner')->where(function ($q) {
            $q->whereNull('is_verified_owner')->orWhere('is_verified_owner', false);
        })->count();
        $totalOwners = User::where('role', 'owner')->orWhere('is_verified_owner', true)->count();
        $pendingKycCount = User::whereNotNull('id_card_photo')->where('is_verified_owner', false)->count();
        $suspendedUsersCount = User::where('status', 'suspended')->count();
        $activeUsersCount = User::where('status', 'active')->count();

        // 2. Laporan & Keamanan Pengguna Metrics
        $totalSafetyReports = SafetyReport::count();
        $pendingSafetyReports = SafetyReport::where('status', 'pending')->count();
        $investigatingReports = SafetyReport::where('status', 'investigating')->count();
        $resolvedSafetyReports = SafetyReport::whereIn('status', ['resolved', 'action_taken'])->count();
        $criticalIncidentsCount = SafetyReport::whereIn('severity', ['high', 'critical'])
            ->whereIn('status', ['pending', 'investigating'])->count();

        // 3. Recent Safety Incidents
        $recentSafetyReports = SafetyReport::with(['reporter', 'reportedUser', 'booking.item'])
            ->latest()
            ->limit(5)
            ->get();

        // 4. Recent Users Registered / Requiring KYC Review
        $recentUsers = User::latest()
            ->limit(5)
            ->get();

        // Preserved variables for compatibility
        $totalItems = Item::count();
        $totalCategories = Category::count();
        $totalBookings = Booking::count();
        $pendingBookings = Booking::where('status', 'pending')->count();
        $totalRevenue = Booking::whereIn('status', ['confirmed', 'completed'])->sum('total_price');
        $recentBookings = Booking::with(['item.images', 'renter'])->latest()->limit(5)->get();
        $topItems = Item::with(['category', 'images'])->limit(5)->get();
        $recentReviews = Review::with(['user', 'item'])->latest()->limit(4)->get();
        $chartLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'];
        $chartData = [0, 0, 0, 0, 0, 0];

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalRenters',
            'totalOwners',
            'pendingKycCount',
            'suspendedUsersCount',
            'activeUsersCount',
            'totalSafetyReports',
            'pendingSafetyReports',
            'investigatingReports',
            'resolvedSafetyReports',
            'criticalIncidentsCount',
            'recentSafetyReports',
            'recentUsers',
            'totalItems',
            'totalCategories',
            'totalBookings',
            'pendingBookings',
            'totalRevenue',
            'recentBookings',
            'topItems',
            'recentReviews',
            'chartLabels',
            'chartData'
        ));
    }
}
