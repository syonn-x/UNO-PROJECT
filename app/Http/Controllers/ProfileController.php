<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Category;
use App\Models\Favorite;
use App\Models\Item;
use App\Models\ItemImage;
use App\Models\Notification;
use App\Models\Review;
use App\Models\SafetyReport;
use App\Models\SafetyReportMessage;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display Tokopedia-style unified account dashboard for Renter & Owner.
     */
    public function index(Request $request): View
    {
        /** @var User $user */
        $user = Auth::user();
        $tab = $request->query('tab', 'profile');
        $validTabs = ['profile', 'rentals', 'favorites', 'my-items', 'incoming-bookings', 'add-item', 'fraud-messages'];

        if (! in_array($tab, $validTabs, true)) {
            $tab = 'profile';
        }

        // If a non-owner tries to open owner-only tabs, redirect or fall back to profile
        if (! $user->isOwner() && in_array($tab, ['my-items', 'incoming-bookings', 'add-item'], true)) {
            $tab = 'profile';
        }

        $categories = Category::all();

        // 1. Rentals made by this user (as Renter)
        $rentalsQuery = $user->bookings()->with(['item.owner', 'item.images', 'review'])->latest();
        if ($request->filled('status') && in_array($request->status, ['pending', 'confirmed', 'completed', 'cancelled'], true)) {
            $rentalsQuery->where('status', $request->status);
        }
        $rentals = $rentalsQuery->get();

        // Count pending rentals for badge
        $pendingRentalsCount = $user->bookings()->where('status', 'pending')->count();

        // 2. Wishlist / Favorites saved by user
        $favorites = $user->favorites()->with(['item.category', 'item.images'])->latest()->get();

        // 3. Fraud Complaints / Messages to Admin (Khusus Korban Penipuan)
        $myFraudReports = SafetyReport::where('reporter_id', $user->id)
            ->with(['reportedUser', 'booking.item', 'messages.user'])
            ->latest()
            ->get();
        $pendingFraudCount = $myFraudReports->whereIn('status', ['pending', 'investigating'])->count();

        // 4. Owner-specific datasets (if user is an owner)
        $myItems = collect();
        $incomingBookings = collect();
        $totalEarned = 0;
        $activeRentedCount = 0;
        $pendingIncomingCount = 0;

        if ($user->isOwner()) {
            $myItems = $user->items()->with(['category', 'images'])->withCount('bookings')->latest()->get();

            $ownerItemIds = $myItems->pluck('id');

            $incomingQuery = Booking::whereIn('item_id', $ownerItemIds)
                ->with(['item.images', 'renter'])
                ->latest();

            if ($request->filled('incoming_status') && in_array($request->incoming_status, ['pending', 'confirmed', 'completed', 'cancelled'], true)) {
                $incomingQuery->where('status', $request->incoming_status);
            }
            $incomingBookings = $incomingQuery->get();

            $totalEarned = Booking::whereIn('item_id', $ownerItemIds)
                ->whereIn('status', ['confirmed', 'completed'])
                ->sum('total_price');

            $activeRentedCount = $myItems->where('status', 'unavailable')->count();
            $pendingIncomingCount = Booking::whereIn('item_id', $ownerItemIds)->where('status', 'pending')->count();
        }

        return view('profile.index', compact(
            'user',
            'tab',
            'categories',
            'rentals',
            'pendingRentalsCount',
            'favorites',
            'myFraudReports',
            'pendingFraudCount',
            'myItems',
            'incomingBookings',
            'totalEarned',
            'activeRentedCount',
            'pendingIncomingCount'
        ));
    }

    /**
     * Update user profile information & password.
     */
    public function updateProfile(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:150', 'unique:users,email,'.$user->id],
            'phone' => ['nullable', 'string', 'max:25'],
            'profile_photo_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'profile_photo_url' => ['nullable', 'url', 'max:500'],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.unique' => 'Email ini sudah digunakan oleh akun lain.',
            'profile_photo_file.image' => 'File foto profil harus berformat gambar.',
            'profile_photo_file.max' => 'Ukuran foto profil maksimal 2MB.',
            'password.min' => 'Kata sandi baru minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
        ];

        // Handle profile photo upload
        if ($request->hasFile('profile_photo_file')) {
            $path = $request->file('profile_photo_file')->store('avatars', 'public');
            $updateData['profile_photo'] = $path;
        } elseif ($request->filled('profile_photo_url')) {
            $updateData['profile_photo'] = $request->profile_photo_url;
        }

        // Handle password change
        if (! empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $user->update($updateData);

        return redirect()->route('profile.index', ['tab' => 'profile'])
            ->with('success', 'Biodata profil Anda berhasil diperbarui!');
    }

    /**
     * Show multi-step onboarding wizard to become a Mitra Rental (Owner).
     */
    public function becomeOwnerForm(): View|RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->isOwner()) {
            return redirect()->route('profile.index', ['tab' => 'my-items'])
                ->with('info', 'Anda sudah terdaftar sebagai Mitra Rental (Owner).');
        }

        return view('profile.become_owner', compact('user'));
    }

    /**
     * Process step-by-step registration & verification to become an Owner.
     */
    public function processBecomeOwner(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->isOwner()) {
            return redirect()->route('profile.index', ['tab' => 'my-items']);
        }

        $validated = $request->validate([
            // Step 1: Store & Operational Location
            'store_name' => ['required', 'string', 'min:3', 'max:150'],
            'store_description' => ['required', 'string', 'min:10', 'max:500'],
            'store_city' => ['required', 'string', 'max:100'],
            'store_address' => ['required', 'string', 'min:10', 'max:255'],
            'phone' => ['required', 'string', 'min:10', 'max:20'],

            // Step 2: KYC Identity KTP (Only KTP verification)
            'nik' => ['required', 'string', 'size:16', 'regex:/^[0-9]+$/'],
            'id_card_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:3072'],
            'id_card_url' => ['nullable', 'url', 'max:500'],

            // Step 3: Terms & Quality Commitments
            'agree_ownership' => ['accepted'],
            'agree_condition' => ['accepted'],
            'agree_terms' => ['accepted'],
        ], [
            'store_name.required' => 'Nama Toko / Rental wajib diisi.',
            'store_name.min' => 'Nama Toko minimal 3 karakter.',
            'store_description.required' => 'Deskripsi Toko / Rental wajib diisi (minimal 10 karakter).',
            'store_description.min' => 'Deskripsi Toko minimal 10 karakter.',
            'store_city.required' => 'Kota operasional rental wajib diisi.',
            'store_address.required' => 'Alamat lengkap serah terima barang wajib diisi.',
            'phone.required' => 'Nomor WhatsApp aktif wajib diisi.',
            'nik.required' => 'Nomor Induk Kependudukan (NIK) wajib diisi.',
            'nik.size' => 'NIK KTP harus tepat 16 digit angka.',
            'nik.regex' => 'NIK KTP hanya boleh berisi angka.',
            'agree_ownership.accepted' => 'Anda wajib menyetujui komitmen kepemilikan barang sah.',
            'agree_condition.accepted' => 'Anda wajib menyetujui jaminan kelayakan dan perawatan barang sewa.',
            'agree_terms.accepted' => 'Anda wajib menyetujui syarat & ketentuan layanan UNO.',
        ]);

        $idCardPath = $user->id_card_photo;
        if ($request->hasFile('id_card_file')) {
            $path = $request->file('id_card_file')->store('kyc', 'public');
            $idCardPath = $path;
        } elseif ($request->filled('id_card_url')) {
            $idCardPath = $request->id_card_url;
        }

        $user->update([
            'role' => 'owner',
            'store_name' => $validated['store_name'],
            'store_description' => $validated['store_description'],
            'store_city' => $validated['store_city'],
            'store_address' => $validated['store_address'],
            'phone' => $validated['phone'],
            'nik' => $validated['nik'],
            'id_card_photo' => $idCardPath,
            'is_verified_owner' => true,
        ]);

        return redirect()->route('profile.index', ['tab' => 'my-items'])
            ->with('success', "Selamat! Verifikasi KTP Berhasil. Toko Rental '{$user->store_name}' Anda kini resmi aktif!");
    }

    /**
     * Fallback for direct upgrade attempt - redirects to step-by-step onboarding wizard.
     */
    public function upgradeToOwner(): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->isOwner()) {
            return redirect()->route('profile.index', ['tab' => 'my-items']);
        }

        return redirect()->route('profile.become-owner')
            ->with('info', 'Untuk menjadi Mitra Rental, silakan lengkapi 3 langkah verifikasi toko dan legalitas di bawah ini.');
    }

    /**
     * Cancel a pending rental by Renter.
     */
    public function cancelRental(int $id): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $booking = $user->bookings()->where('id', $id)->firstOrFail();

        if ($booking->status !== 'pending') {
            return back()->with('error', 'Hanya pesanan berstatus Menunggu Konfirmasi yang dapat dibatalkan.');
        }

        $booking->update(['status' => 'cancelled']);

        return redirect()->route('profile.index', ['tab' => 'rentals'])
            ->with('success', 'Pesanan sewa #BK-'.$booking->id.' berhasil dibatalkan.');
    }

    /**
     * Give review & star rating for a completed rental booking.
     */
    public function storeReview(Request $request, int $bookingId): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ], [
            'rating.required' => 'Rating bintang wajib dipilih (1-5).',
            'rating.min' => 'Rating minimal 1 bintang.',
            'rating.max' => 'Rating maksimal 5 bintang.',
        ]);

        $booking = $user->bookings()
            ->where('id', $bookingId)
            ->where('status', 'completed')
            ->firstOrFail();

        Review::updateOrCreate(
            ['booking_id' => $booking->id],
            [
                'item_id' => $booking->item_id,
                'user_id' => $user->id,
                'rating' => $validated['rating'],
                'comment' => $validated['comment'] ?? null,
            ]
        );

        return redirect()->route('profile.index', ['tab' => 'rentals'])
            ->with('success', 'Ulasan dan bintang Anda untuk unit rental berhasil disimpan!');
    }

    /**
     * Owner: Add new rental unit to inventory.
     */
    public function storeItem(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        if (! $user->isOwner()) {
            abort(403, 'Hanya Mitra Rental (Owner) yang dapat menambahkan barang sewaan.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'category_id' => ['required', 'exists:categories,id'],
            'price_per_day' => ['required', 'numeric', 'min:1000'],
            'condition' => ['required', 'in:new,like_new,good,fair'],
            'location' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'min:10'],
            'image_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:3072'],
            'image_url' => ['nullable', 'url', 'max:500'],
        ], [
            'name.required' => 'Nama unit rental wajib diisi.',
            'category_id.required' => 'Kategori unit wajib dipilih.',
            'price_per_day.required' => 'Tarif sewa per hari wajib diisi.',
            'price_per_day.min' => 'Tarif sewa minimal Rp 1.000 / hari.',
            'location.required' => 'Lokasi ketersediaan unit wajib diisi.',
            'description.required' => 'Deskripsi kelengkapan barang wajib diisi.',
        ]);

        $item = Item::create([
            'owner_id' => $user->id,
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price_per_day' => $validated['price_per_day'],
            'condition' => $validated['condition'],
            'location' => $validated['location'],
            'status' => 'available',
        ]);

        // Save image
        $imageUrl = 'https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?w=800&auto=format&fit=crop&q=80';
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('items', 'public');
            $imageUrl = asset('storage/'.$path);
        } elseif ($request->filled('image_url')) {
            $imageUrl = $request->image_url;
        }

        ItemImage::create([
            'item_id' => $item->id,
            'image_url' => $imageUrl,
        ]);

        return redirect()->route('profile.index', ['tab' => 'my-items'])
            ->with('success', "Unit rental '{$item->name}' berhasil ditambahkan ke katalog sewa Anda!");
    }

    /**
     * Owner: Toggle rental unit status (available / unavailable / hidden).
     */
    public function updateItemStatus(Request $request, int $id): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $item = $user->items()->findOrFail($id);

        $validated = $request->validate([
            'status' => ['required', 'in:available,unavailable,hidden'],
        ]);

        $item->update(['status' => $validated['status']]);

        $statusLabel = match ($validated['status']) {
            'available' => 'Tersedia untuk disewa',
            'unavailable' => 'Sedang Tidak Tersedia',
            'hidden' => 'Diarsipkan',
        };

        return back()->with('success', "Status unit '{$item->name}' diubah menjadi: {$statusLabel}");
    }

    /**
     * Owner: Delete rental unit from inventory.
     */
    public function deleteItem(int $id): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $item = $user->items()->findOrFail($id);
        $name = $item->name;
        $item->delete();

        return redirect()->route('profile.index', ['tab' => 'my-items'])
            ->with('success', "Unit rental '{$name}' berhasil dihapus dari inventaris Anda.");
    }

    /**
     * Owner: Update status of incoming rental order from another renter.
     */
    public function updateIncomingBookingStatus(Request $request, int $id): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $ownerItemIds = $user->items()->pluck('id');
        $booking = Booking::whereIn('item_id', $ownerItemIds)->with(['item', 'renter'])->findOrFail($id);

        $validated = $request->validate([
            'status' => ['required', 'in:confirmed,completed,cancelled'],
        ]);

        $newStatus = $validated['status'];
        $booking->update(['status' => $newStatus]);

        // Send system notification to the renter
        $statusLabels = [
            'confirmed' => 'DISETUJUI & SIAP DIAMBIL',
            'completed' => 'SELESAI',
            'cancelled' => 'DIBATALKAN',
        ];

        Notification::create([
            'user_id' => $booking->renter_id,
            'title' => "Pesanan Sewa #BK-{$booking->id} Diperbarui",
            'message' => "Pemilik unit ({$user->name}) telah memperbarui pesanan sewa {$booking->item->name} menjadi: ".($statusLabels[$newStatus] ?? $newStatus),
            'type' => 'booking_'.$newStatus,
        ]);

        return redirect()->route('profile.index', ['tab' => 'incoming-bookings'])
            ->with('success', "Pesanan #BK-{$booking->id} berhasil diperbarui menjadi: ".($statusLabels[$newStatus] ?? $newStatus));
    }

    /**
     * Toggle favorite item for user wishlist.
     */
    public function toggleFavorite(Request $request, int $itemId)
    {
        /** @var User $user */
        $user = Auth::user();
        $item = Item::findOrFail($itemId);

        $favorite = Favorite::where('user_id', $user->id)
            ->where('item_id', $item->id)
            ->first();

        if ($favorite) {
            $favorite->delete();
            $favorited = false;
            $msg = 'Unit dihapus dari Wishlist Favorit.';
        } else {
            Favorite::create([
                'user_id' => $user->id,
                'item_id' => $item->id,
            ]);
            $favorited = true;
            $msg = 'Unit berhasil disimpan ke Wishlist Favorit!';
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'favorited' => $favorited,
                'message' => $msg,
            ]);
        }

        return back()->with('success', $msg);
    }

    /**
     * Ajukan Laporan Penipuan Baru ke Admin Pusat (Khusus Korban Kena Tipu).
     */
    public function storeFraudReport(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'booking_id' => ['required', 'exists:bookings,id'],
            'fraud_type' => ['required', 'string', 'max:150'],
            'message' => ['required', 'string', 'min:10', 'max:2500'],
            'evidence' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:3072'],
        ], [
            'booking_id.required' => 'Transaksi sewa yang disengketakan wajib dipilih.',
            'fraud_type.required' => 'Jenis penipuan wajib dipilih.',
            'message.required' => 'Kronologi dan penjelasan penipuan wajib diisi.',
            'message.min' => 'Jelaskan kronologi kejadian minimal 10 karakter.',
            'evidence.image' => 'File bukti harus berupa gambar (tangkapan layar / foto transfer).',
            'evidence.max' => 'Ukuran file bukti maksimal 3MB.',
        ]);

        $booking = Booking::with('item.owner')->findOrFail($validated['booking_id']);

        // Pastikan pengguna adalah pihak dalam transaksi
        if ($booking->renter_id !== $user->id && $booking->item->owner_id !== $user->id) {
            abort(403, 'Anda tidak berhak melaporkan transaksi sewa ini.');
        }

        // Tentukan siapa pihak yang dilaporkan
        $reportedUserId = ($booking->renter_id === $user->id)
            ? $booking->item->owner_id
            : $booking->renter_id;

        $attachmentPath = null;
        if ($request->hasFile('evidence')) {
            $file = $request->file('evidence');
            $filename = 'evidence_'.time().'_'.Str::random(8).'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/evidence'), $filename);
            $attachmentPath = 'uploads/evidence/'.$filename;
        }

        // Buat Laporan Keamanan
        $reportCode = 'TIPU-'.strtoupper(Str::random(6));
        $report = SafetyReport::create([
            'report_code' => $reportCode,
            'reporter_id' => $user->id,
            'reported_user_id' => $reportedUserId,
            'booking_id' => $booking->id,
            'category' => 'fraud_payment',
            'title' => '[Aduan Penipuan]: '.$validated['fraud_type'],
            'description' => $validated['message'],
            'evidence_photo' => $attachmentPath,
            'severity' => 'high',
            'status' => 'pending',
        ]);

        // Buat pesan pertama di thread percakapan
        SafetyReportMessage::create([
            'safety_report_id' => $report->id,
            'user_id' => $user->id,
            'message' => $validated['message'],
            'attachment' => $attachmentPath,
            'is_admin' => false,
        ]);

        return redirect()->route('profile.index', ['tab' => 'fraud-messages'])
            ->with('success', "Aduan penipuan Anda (#{$reportCode}) berhasil terkirim ke Admin Pusat! Tim keamanan kami akan segera memverifikasi dan merespon pesan Anda.");
    }

    /**
     * Balas pesan dalam thread aduan penipuan dari sisi korban.
     */
    public function replyFraudMessage(Request $request, int $id): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'message' => ['required', 'string', 'min:3', 'max:2500'],
            'attachment' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:3072'],
        ], [
            'message.required' => 'Pesan balasan wajib diisi.',
            'attachment.image' => 'Lampiran harus berupa gambar bukti.',
        ]);

        $report = SafetyReport::where('reporter_id', $user->id)->findOrFail($id);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filename = 'reply_'.time().'_'.Str::random(8).'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/evidence'), $filename);
            $attachmentPath = 'uploads/evidence/'.$filename;
        }

        // Simpan pesan dari korban
        SafetyReportMessage::create([
            'safety_report_id' => $report->id,
            'user_id' => $user->id,
            'message' => $validated['message'],
            'attachment' => $attachmentPath,
            'is_admin' => false,
        ]);

        // Jika kasus tadinya tuntas atau perlu respon lagi, ubah status ke investigating
        if ($report->status === 'resolved') {
            $report->update(['status' => 'investigating']);
        }

        return redirect()->route('profile.index', ['tab' => 'fraud-messages'])
            ->with('success', 'Pesan balasan Anda berhasil terkirim ke Admin Pusat.');
    }
}
