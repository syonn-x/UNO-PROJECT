<?php

use App\Http\Controllers\Admin\ApiDocsController;
use App\Http\Controllers\Admin\AvailabilityController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\SafetyReportController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - U.N.O E-Commerce Rental Platform
|--------------------------------------------------------------------------
*/

// Customer E-Commerce Landing Page & Catalog
Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/catalog', [LandingController::class, 'catalog'])->name('catalog');
Route::get('/items', [LandingController::class, 'catalog'])->name('items.index');
Route::get('/items/{id}', [LandingController::class, 'show'])->name('items.show');
Route::post('/book', [LandingController::class, 'book'])->name('book.store');

// Web Authentication, Registration & Demo Switcher
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::get('/quick-login/{role?}', [AuthController::class, 'quickLogin'])->name('quick.login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/logout', [AuthController::class, 'logout']);

// User & Owner Profile & Dashboard (Tokopedia Style) - Protected by Auth
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::get('/profile/become-owner', [ProfileController::class, 'becomeOwnerForm'])->name('profile.become-owner');
    Route::post('/profile/become-owner', [ProfileController::class, 'processBecomeOwner'])->name('profile.become-owner.submit');
    Route::post('/profile/upgrade-owner', [ProfileController::class, 'upgradeToOwner'])->name('profile.upgrade-owner');
    Route::post('/profile/rentals/{id}/cancel', [ProfileController::class, 'cancelRental'])->name('profile.rentals.cancel');
    Route::post('/profile/rentals/{id}/review', [ProfileController::class, 'storeReview'])->name('profile.rentals.review');

    // Owner specific routes
    Route::post('/profile/items', [ProfileController::class, 'storeItem'])->name('profile.items.store');
    Route::post('/profile/items/{id}/status', [ProfileController::class, 'updateItemStatus'])->name('profile.items.status');
    Route::delete('/profile/items/{id}', [ProfileController::class, 'deleteItem'])->name('profile.items.destroy');
    Route::post('/profile/incoming-bookings/{id}/status', [ProfileController::class, 'updateIncomingBookingStatus'])->name('profile.incoming-bookings.status');

    // Pelaporan Penipuan (Khusus Korban Penipuan Sewa)
    Route::post('/profile/fraud-reports', [ProfileController::class, 'storeFraudReport'])->name('profile.fraud-reports.store');
    Route::post('/profile/fraud-reports/{id}/reply', [ProfileController::class, 'replyFraudMessage'])->name('profile.fraud-reports.reply');

    // Wishlist / Favorite toggle
    Route::post('/favorites/{itemId}/toggle', [ProfileController::class, 'toggleFavorite'])->name('favorites.toggle');
});

// Admin Panel (AdminLTE 3 + Turbo + AJAX + Grouped Sidebar) - Strictly Protected for Admin Only
Route::prefix('admin')->name('admin.')->middleware(['admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 1. Master Data
    Route::resource('categories', CategoryController::class);
    Route::resource('items', ItemController::class);
    Route::post('items/{id}/status', [ItemController::class, 'updateStatus'])->name('items.status');

    // 2. Transaksi & Sewa
    Route::resource('bookings', BookingController::class);
    Route::post('bookings/{id}/status', [BookingController::class, 'updateStatus'])->name('bookings.status');
    Route::resource('availability', AvailabilityController::class);
    Route::resource('reviews', ReviewController::class);

    // 3. Pengguna & Laporan Keamanan
    Route::resource('users', UserController::class);
    Route::post('users/{id}/status', [UserController::class, 'updateStatus'])->name('users.status');
    Route::post('users/{id}/role', [UserController::class, 'updateRole'])->name('users.role');
    Route::post('users/{id}/verify-owner', [UserController::class, 'verifyOwner'])->name('users.verify-owner');
    Route::resource('notifications', NotificationController::class);

    // Pesan Aduan Penipuan & Laporan Keamanan Pusat (Messages)
    Route::get('messages', [SafetyReportController::class, 'index'])->name('messages.index');
    Route::get('messages/{id}', [SafetyReportController::class, 'show'])->name('messages.show');
    Route::post('messages/{id}/reply', [SafetyReportController::class, 'replyMessage'])->name('messages.reply');
    Route::post('messages/{id}/suspend-user', [SafetyReportController::class, 'suspendFraudUser'])->name('messages.suspend-user');

    Route::get('safety-reports/print', [SafetyReportController::class, 'print'])->name('safety-reports.print');
    Route::resource('safety-reports', SafetyReportController::class);
    Route::post('safety-reports/{id}/status', [SafetyReportController::class, 'updateStatus'])->name('safety-reports.status');
    Route::post('safety-reports/{id}/reply', [SafetyReportController::class, 'replyMessage'])->name('safety-reports.reply');
    Route::post('safety-reports/{id}/suspend-user', [SafetyReportController::class, 'suspendFraudUser'])->name('safety-reports.suspend-user');

    // 4. Laporan (Reports)
    Route::get('reports/sales', [ReportController::class, 'sales'])->name('reports.sales');
    Route::get('reports/inventory', [ReportController::class, 'inventory'])->name('reports.inventory');
    Route::get('reports/print', [ReportController::class, 'print'])->name('reports.print');

    // 5. REST API Docs & Explorer
    Route::get('api-docs', [ApiDocsController::class, 'index'])->name('api_docs');
});
