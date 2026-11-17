<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Category;
use App\Models\Item;
use App\Models\Notification;
use App\Models\Review;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LandingController extends Controller
{
    /**
     * Display the main modern e-commerce rental landing page.
     */
    public function index(Request $request)
    {
        $categories = Category::withCount(['items' => function ($q) {
            $q->where('status', 'available');
        }])->get();

        $totalItemsCount = Item::where('status', 'available')->count();

        // Customer reviews for testimonials
        $testimonials = Review::with(['user', 'item.category'])->latest()->limit(6)->get();

        // Official Verified Rental Partners (Mitra Terverifikasi KTP)
        $verifiedPartners = User::where('is_verified_owner', true)
            ->where('role', '!=', 'admin')
            ->withCount(['items' => function ($q) {
                $q->where('status', 'available');
            }])
            ->latest()
            ->limit(8)
            ->get();

        // Featured & trending items for landing page showcase
        $featuredItems = Item::with(['category', 'images', 'owner'])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->where('status', 'available')
            ->latest()
            ->limit(8)
            ->get();

        return view('landing', compact('categories', 'totalItemsCount', 'testimonials', 'verifiedPartners', 'featuredItems'));
    }

    /**
     * Dedicated Tokopedia-style Rental Catalog page with multi-filter & sorting.
     */
    public function catalog(Request $request)
    {
        $categories = Category::withCount(['items' => function ($q) {
            $q->where('status', 'available');
        }])->get();

        $query = Item::with(['category', 'images', 'owner'])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->where('status', 'available');

        // Search keyword
        if ($request->filled('q')) {
            $q = trim($request->q);
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%")
                    ->orWhere('location', 'like', "%{$q}%");
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Condition filter
        if ($request->filled('condition')) {
            $query->where('condition', $request->condition);
        }

        // Location filter
        if ($request->filled('location')) {
            $query->where('location', 'like', "%{$request->location}%");
        }

        // Min Price filter
        if ($request->filled('min_price') && is_numeric($request->min_price)) {
            $query->where('price_per_day', '>=', (float) $request->min_price);
        }

        // Max Price filter
        if ($request->filled('max_price') && is_numeric($request->max_price)) {
            $query->where('price_per_day', '<=', (float) $request->max_price);
        }

        // Rating filter
        if ($request->filled('min_rating') && is_numeric($request->min_rating)) {
            $query->having('reviews_avg_rating', '>=', (float) $request->min_rating);
        }

        // Sort
        $sort = $request->get('sort', 'popular');
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price_per_day', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price_per_day', 'desc');
                break;
            case 'latest':
                $query->latest();
                break;
            case 'rating':
                $query->orderBy('reviews_avg_rating', 'desc');
                break;
            default: // popular / reviews
                $query->orderBy('reviews_count', 'desc');
                break;
        }

        $items = $query->paginate(12)->withQueryString();

        // Unique locations for sidebar filter
        $locations = Item::where('status', 'available')
            ->whereNotNull('location')
            ->select('location')
            ->distinct()
            ->pluck('location');

        $priceStats = [
            'min' => (int) (Item::where('status', 'available')->min('price_per_day') ?? 0),
            'max' => (int) (Item::where('status', 'available')->max('price_per_day') ?? 1000000),
        ];

        $activeCategory = $request->filled('category') ? Category::find($request->category) : null;

        return view('catalog', compact('items', 'categories', 'locations', 'priceStats', 'activeCategory'));
    }

    /**
     * Show detail for an item.
     */
    public function show(int $id)
    {
        $item = Item::with([
            'category',
            'owner',
            'images',
            'reviews.user',
            'availability' => function ($q) {
                $q->where('end_date', '>=', now()->toDateString());
            },
        ])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->findOrFail($id);

        $relatedItems = Item::with(['category', 'images'])
            ->where('category_id', $item->category_id)
            ->where('id', '!=', $item->id)
            ->where('status', 'available')
            ->limit(3)
            ->get();

        return view('item_detail', compact('item', 'relatedItems'));
    }

    /**
     * Quick rental booking from landing page / item detail (AJAX / Form).
     */
    public function book(Request $request)
    {
        $isAuth = Auth::check();
        $authUser = $isAuth ? Auth::user() : null;
        $needsPhone = ! $isAuth || empty($authUser?->phone);

        $rules = [
            'item_id' => 'required|exists:items,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'renter_name' => $isAuth ? 'nullable|string|max:100' : 'required|string|max:100',
            'renter_phone' => $needsPhone ? 'required|string|max:25' : 'nullable|string|max:25',
            'notes' => 'nullable|string|max:1000',
        ];

        $messages = [
            'item_id.required' => 'Unit barang rental wajib dipilih.',
            'item_id.exists' => 'Unit barang rental tidak valid atau tidak ditemukan.',
            'start_date.required' => 'Tanggal mulai sewa wajib diisi.',
            'start_date.after_or_equal' => 'Tanggal mulai sewa tidak boleh sebelum hari ini.',
            'end_date.required' => 'Tanggal selesai sewa wajib diisi.',
            'end_date.after_or_equal' => 'Tanggal selesai sewa harus sama atau setelah tanggal mulai.',
            'renter_name.required' => 'Nama lengkap penyewa wajib diisi.',
            'renter_phone.required' => 'Nomor WhatsApp / HP aktif wajib diisi.',
        ];

        $validated = $request->validate($rules, $messages);

        $item = Item::with('owner')->findOrFail($request->item_id);

        // Determine renter
        if ($isAuth) {
            $renter = $authUser;
            if ($request->filled('renter_phone') && empty($renter->phone)) {
                $renter->update(['phone' => $request->renter_phone]);
            }
        } else {
            // Find or create renter user automatically
            $cleanEmailName = preg_replace('/[^a-z0-9]/', '', strtolower($request->renter_name));
            if (empty($cleanEmailName)) {
                $cleanEmailName = 'renter';
            }
            $renter = User::firstOrCreate(
                ['phone' => $request->renter_phone],
                [
                    'name' => $request->renter_name,
                    'email' => $cleanEmailName.'_'.time().'_'.rand(100, 999).'@uno.local',
                    'password' => bcrypt('password123'),
                    'role' => 'renter',
                    'status' => 'active',
                ]
            );
        }

        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);
        $totalDays = max(1, $startDate->diffInDays($endDate) + 1);
        $totalPrice = $totalDays * $item->price_per_day;

        $booking = Booking::create([
            'item_id' => $item->id,
            'renter_id' => $renter->id,
            'start_date' => $startDate->toDateString(),
            'end_date' => $endDate->toDateString(),
            'total_days' => $totalDays,
            'total_price' => $totalPrice,
            'status' => 'pending',
            'notes' => $request->notes,
        ]);

        // Notification for admin
        $adminUser = User::where('role', 'admin')->first();
        if ($adminUser) {
            Notification::create([
                'user_id' => $adminUser->id,
                'title' => 'Booking Sewa Baru',
                'message' => "Pesanan sewa baru #BK-{$booking->id} untuk unit {$item->name} ({$totalDays} hari) senilai Rp ".number_format($totalPrice, 0, ',', '.'),
                'type' => 'booking_new',
            ]);
        }

        // Notification for item owner
        if ($item->owner_id && (! $adminUser || $item->owner_id !== $adminUser->id)) {
            Notification::create([
                'user_id' => $item->owner_id,
                'title' => 'Unit Anda Dipesan!',
                'message' => "Penyewa {$renter->name} telah mengajukan booking untuk {$item->name} ({$totalDays} hari).",
                'type' => 'booking_new',
            ]);
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Booking sewa berhasil diajukan! Tim kami dan pemilik unit akan segera menghubungi Anda.',
                'booking_id' => $booking->id,
                'total_days' => $totalDays,
                'total_price' => $totalPrice,
                'item_name' => $item->name,
                'renter_name' => $renter->name,
            ]);
        }

        return redirect()->route('landing')->with('success', 'Booking berhasil diajukan! No Pesanan: #'.$booking->id.'. Tim kami akan menghubungi kontak Anda.');
    }
}
