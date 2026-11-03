<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class ApiDocsController extends Controller
{
    /**
     * Display REST API Explorer and Documentation.
     */
    public function index()
    {
        $serverIp = '10.61.4.129';
        $baseUrl = "http://{$serverIp}:8000/api";

        $endpoints = [
            [
                'group' => 'Autentikasi & Akun',
                'items' => [
                    ['method' => 'POST', 'url' => '/v1/auth/register', 'desc' => 'Daftar akun baru', 'auth' => false, 'body' => '{"name": "Budi", "email": "budi@test.com", "password": "password123", "phone": "08123456789"}'],
                    ['method' => 'POST', 'url' => '/v1/auth/login', 'desc' => 'Login dan ambil Bearer token', 'auth' => false, 'body' => '{"email": "admin@uno.com", "password": "admin123"}'],
                    ['method' => 'GET',  'url' => '/v1/auth/me', 'desc' => 'Ambil profil user yang sedang login', 'auth' => true, 'body' => null],
                    ['method' => 'POST', 'url' => '/v1/auth/logout', 'desc' => 'Logout dan cabut token', 'auth' => true, 'body' => null],
                ],
            ],
            [
                'group' => 'Kategori & Barang Rental',
                'items' => [
                    ['method' => 'GET',  'url' => '/v1/categories', 'desc' => 'Daftar semua kategori rental', 'auth' => false, 'body' => null],
                    ['method' => 'GET',  'url' => '/v1/categories/{id}', 'desc' => 'Detail kategori berserta daftar barangnya', 'auth' => false, 'body' => null],
                    ['method' => 'GET',  'url' => '/v1/items?search=&category_id=&condition=&sort=latest', 'desc' => 'Katalog barang dengan filter pencarian', 'auth' => false, 'body' => null],
                    ['method' => 'GET',  'url' => '/v1/items/{id}', 'desc' => 'Detail barang rental, galeri foto, ulasan', 'auth' => false, 'body' => null],
                    ['method' => 'GET',  'url' => '/v1/items/{id}/availability', 'desc' => 'Cek jadwal dan ketersediaan sewa barang', 'auth' => false, 'body' => null],
                    ['method' => 'POST', 'url' => '/v1/items', 'desc' => 'Daftarkan barang rental baru', 'auth' => true, 'body' => '{"category_id": 1, "name": "Kamera Sony", "description": "Lensa kit...", "price_per_day": 200000, "condition": "like_new", "location": "Jakarta"}'],
                ],
            ],
            [
                'group' => 'Transaksi Booking & Sewa',
                'items' => [
                    ['method' => 'GET',  'url' => '/v1/bookings', 'desc' => 'Daftar transaksi sewa milik pengguna', 'auth' => true, 'body' => null],
                    ['method' => 'POST', 'url' => '/v1/bookings', 'desc' => 'Ajukan booking sewa barang rental', 'auth' => true, 'body' => '{"item_id": 1, "start_date": "2026-10-20", "end_date": "2026-10-23", "notes": "Disewa untuk dokumentasi acara"}'],
                    ['method' => 'GET',  'url' => '/v1/bookings/{id}', 'desc' => 'Detail transaksi booking', 'auth' => true, 'body' => null],
                    ['method' => 'PATCH', 'url' => '/v1/bookings/{id}/cancel', 'desc' => 'Batalkan pesanan (jika status masih pending)', 'auth' => true, 'body' => null],
                ],
            ],
            [
                'group' => 'Favorit, Ulasan & Notifikasi',
                'items' => [
                    ['method' => 'GET',  'url' => '/v1/favorites', 'desc' => 'Daftar barang wishlist favorit', 'auth' => true, 'body' => null],
                    ['method' => 'POST', 'url' => '/v1/favorites/toggle', 'desc' => 'Tambah / hapus barang dari wishlist', 'auth' => true, 'body' => '{"item_id": 1}'],
                    ['method' => 'POST', 'url' => '/v1/reviews', 'desc' => 'Kirim review & rating bintang (1-5)', 'auth' => true, 'body' => '{"booking_id": 1, "rating": 5, "comment": "Barang sangat bagus!"}'],
                    ['method' => 'GET',  'url' => '/v1/notifications', 'desc' => 'Daftar notifikasi pengguna', 'auth' => true, 'body' => null],
                    ['method' => 'PATCH', 'url' => '/v1/notifications/{id}/read', 'desc' => 'Tandai notifikasi telah dibaca', 'auth' => true, 'body' => null],
                ],
            ],
            [
                'group' => 'Laporan Eksekutif & Statistik',
                'items' => [
                    ['method' => 'GET',  'url' => '/v1/reports/summary', 'desc' => 'Statistik ringkasan KPI, total omset, & item terpopuler', 'auth' => false, 'body' => null],
                    ['method' => 'GET',  'url' => '/v1/reports/transactions', 'desc' => 'Data detail transaksi untuk laporan keuangan', 'auth' => true, 'body' => null],
                ],
            ],
        ];

        return view('admin.api_docs', compact('endpoints', 'baseUrl', 'serverIp'));
    }
}
