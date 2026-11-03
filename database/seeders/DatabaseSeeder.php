<?php

namespace Database\Seeders;

use App\Models\Availability;
use App\Models\Booking;
use App\Models\Category;
use App\Models\Favorite;
use App\Models\Item;
use App\Models\ItemImage;
use App\Models\Notification;
use App\Models\Review;
use App\Models\SafetyReport;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Users
        $admin = User::firstOrCreate(
            ['email' => 'admin@uno.com'],
            [
                'name' => 'Admin UNO Pusat',
                'password' => Hash::make('admin123'),
                'phone' => '081234567890',
                'profile_photo' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=200&auto=format&fit=crop&q=80',
                'role' => 'admin',
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );

        $ahmad = User::firstOrCreate(
            ['email' => 'ahmad@example.com'],
            [
                'name' => 'Ahmad Pratama (Rental Owner)',
                'password' => Hash::make('password123'),
                'phone' => '081298765432',
                'profile_photo' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=200&auto=format&fit=crop&q=80',
                'role' => 'owner',
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );

        $siti = User::firstOrCreate(
            ['email' => 'siti@example.com'],
            [
                'name' => 'Siti Nurhaliza (Outdoor Equip)',
                'password' => Hash::make('password123'),
                'phone' => '081377889900',
                'profile_photo' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=200&auto=format&fit=crop&q=80',
                'role' => 'owner',
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );

        $budi = User::firstOrCreate(
            ['email' => 'budi@example.com'],
            [
                'name' => 'Budi Santoso (Renter)',
                'password' => Hash::make('password123'),
                'phone' => '081511223344',
                'profile_photo' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=200&auto=format&fit=crop&q=80',
                'role' => 'renter',
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );

        $adit = User::firstOrCreate(
            ['email' => 'adit@gmail.com'],
            [
                'name' => 'Aditia (Member)',
                'password' => Hash::make('password123'),
                'phone' => '081988776655',
                'profile_photo' => 'https://images.unsplash.com/photo-1522075469751-3a6694fb2f61?w=200&auto=format&fit=crop&q=80',
                'role' => 'renter',
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );

        // 2. Categories
        $categoriesData = [
            ['name' => 'Electronics', 'description' => 'Perangkat kamera, proyektor, audio, konsol game, dan gadget'],
            ['name' => 'Camping & Outdoor', 'description' => 'Peralatan tenda, hiking, sepeda gunung, dan petualangan luar ruangan'],
            ['name' => 'Home & Living', 'description' => 'Perlengkapan acara pesta, home appliance, mesin kopi espresso'],
            ['name' => 'Tools & Equipment', 'description' => 'Peralatan pertukangan, bor mesin, tangga, dan mesin las'],
            ['name' => 'Fashion & Accessories', 'description' => 'Jas formal pria, gaun pengantin, kostum cosplay, dan aksesoris pesta'],
        ];

        $categories = [];
        foreach ($categoriesData as $cData) {
            $cat = Category::firstOrCreate(['name' => $cData['name']], ['description' => $cData['description']]);
            $categories[$cat->name] = $cat;
        }

        // 3. Rental Items
        $itemsData = [
            [
                'owner' => $ahmad,
                'category' => $categories['Electronics'],
                'name' => 'Sony Alpha A7 III Mirrorless + Lensa 28-70mm',
                'description' => 'Kamera mirrorless full-frame profesional dengan sensor 24.2 MP, rekaman video 4K HDR, baterai tahan lama 2 unit, memory SD Sandisk Extreme Pro 128GB, dan tas kamera. Sangat cocok untuk dokumentasi event, wedding, dan video sinematik.',
                'price_per_day' => 250000,
                'condition' => 'like_new',
                'location' => 'Jakarta Selatan (Kebayoran Baru)',
                'status' => 'available',
                'images' => [
                    'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=800&auto=format&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1502920917128-1aa500764cbd?w=800&auto=format&fit=crop&q=80',
                ],
            ],
            [
                'owner' => $siti,
                'category' => $categories['Camping & Outdoor'],
                'name' => 'Tenda Dome Eiger Guardian 4P Waterproof',
                'description' => 'Tenda camping kapasitas 4 orang dengan double layer waterproof tahan hujan deras dan angin kencang. Lengkap dengan pasak aluminium, tiang fiber kuat, matras foil, dan flysheet ekstra.',
                'price_per_day' => 75000,
                'condition' => 'good',
                'location' => 'Bandung (Dago Atas)',
                'status' => 'available',
                'images' => [
                    'https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?w=800&auto=format&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1510312305653-8ed496efae75?w=800&auto=format&fit=crop&q=80',
                ],
            ],
            [
                'owner' => $ahmad,
                'category' => $categories['Electronics'],
                'name' => 'DJI Mini 3 Pro Drone Fly More Combo',
                'description' => 'Drone mini ringan <249g dengan sensor 1/1.3 inci, rekaman 4K HDR 60fps, true vertical shooting, sensor rintangan 3 arah. Dilengkapi DJI RC Screen remote dan 3 baterai pintar (durasi terbang hingga 100 menit).',
                'price_per_day' => 300000,
                'condition' => 'like_new',
                'location' => 'Surabaya (Gubeng)',
                'status' => 'available',
                'images' => [
                    'https://images.unsplash.com/photo-1527977966376-1c8408f9f108?w=800&auto=format&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1508614589041-895b88991e3e?w=800&auto=format&fit=crop&q=80',
                ],
            ],
            [
                'owner' => $ahmad,
                'category' => $categories['Camping & Outdoor'],
                'name' => 'Honda PCX 160 ABS 2024 Matic Touring',
                'description' => 'Motor matic premium kapasitas mesin 160cc eSP+, bagasi luas 30 liter muat helm full face, fitur smart key keyless, rem ABS, dan USB charger. Kondisi selalu servis rutin di bengkel resmi AHASS.',
                'price_per_day' => 125000,
                'condition' => 'new',
                'location' => 'Denpasar, Bali (Kuta / Sanur)',
                'status' => 'available',
                'images' => [
                    'https://images.unsplash.com/photo-1558981403-c5f9899a28bc?w=800&auto=format&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1568772585407-9361f9bf3a87?w=800&auto=format&fit=crop&q=80',
                ],
            ],
            [
                'owner' => $siti,
                'category' => $categories['Home & Living'],
                'name' => 'Mesin Kopi Espresso DeLonghi Dedica EC685',
                'description' => 'Mesin kopi espresso rumahan / cafe mini 15 bar pump pressure. Bisa membuat espresso single/double dan steam susu untuk cappuccino atau latte art. Disertakan tamper stainless, portafilter, dan milk jug.',
                'price_per_day' => 85000,
                'condition' => 'good',
                'location' => 'Yogyakarta (Sleman)',
                'status' => 'available',
                'images' => [
                    'https://images.unsplash.com/photo-1517668808822-9ebb02f2a0e6?w=800&auto=format&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1514432324607-a09d9b4aefdd?w=800&auto=format&fit=crop&q=80',
                ],
            ],
            [
                'owner' => $ahmad,
                'category' => $categories['Tools & Equipment'],
                'name' => 'Bor Listrik Cordless Bosch GSB 185-LI Brushless',
                'description' => 'Mesin bor baterai 18V tanpa kabel dengan motor brushless bertenaga untuk kayu, besi, dan beton (impact drill). Dilengkapi 2 baterai lithium, quick charger, dan mata bor set lengkap.',
                'price_per_day' => 45000,
                'condition' => 'good',
                'location' => 'Semarang (Banyumanik)',
                'status' => 'available',
                'images' => [
                    'https://images.unsplash.com/photo-1504148455328-c376907d081c?w=800&auto=format&fit=crop&q=80',
                ],
            ],
            [
                'owner' => $siti,
                'category' => $categories['Fashion & Accessories'],
                'name' => 'Jas Formal Pria Tuxedo Slim Fit Wool Blend',
                'description' => 'Jas tuxedo hitam elegan bahan wool premium impor, cocok untuk wisuda, pesta pernikahan, gala dinner, photoshoot formal. Setelan lengkap: Jas, Celana (Size M/L), Dasi kupu-kupu, dan Pocket Square.',
                'price_per_day' => 150000,
                'condition' => 'like_new',
                'location' => 'Jakarta Barat (Tanjung Duren)',
                'status' => 'available',
                'images' => [
                    'https://images.unsplash.com/photo-1594938298603-c8148c4dae35?w=800&auto=format&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1507679799987-c73779587ccf?w=800&auto=format&fit=crop&q=80',
                ],
            ],
            [
                'owner' => $ahmad,
                'category' => $categories['Electronics'],
                'name' => 'Proyektor Epson EB-E01 3300 Lumens HDMI',
                'description' => 'Proyektor 3LCD berkualitas tinggi dengan kecerahan 3300 ANSI Lumens, tampilan tajam dan terang bahkan di ruangan dengan cahaya normal. Dilengkapi kabel HDMI 5 meter, pointer laser, dan tripod portable.',
                'price_per_day' => 120000,
                'condition' => 'good',
                'location' => 'Tangerang (BSD City)',
                'status' => 'available',
                'images' => [
                    'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?w=800&auto=format&fit=crop&q=80',
                ],
            ],
            [
                'owner' => $siti,
                'category' => $categories['Camping & Outdoor'],
                'name' => 'Sepeda Gunung Polygon Siskiu D7 Full Suspension 29"',
                'description' => 'Sepeda MTB dual suspension Polygon Siskiu D7 dengan frame hydroformed aluminium, groupset Shimano Deore 1x11 speed, rem hidrolik, dan suspensi udara RockShox. Siap melibas jalur trail pegunungan.',
                'price_per_day' => 140000,
                'condition' => 'like_new',
                'location' => 'Bogor (Sentul City)',
                'status' => 'available',
                'images' => [
                    'https://images.unsplash.com/photo-1485965120184-e220f721d03e?w=800&auto=format&fit=crop&q=80',
                ],
            ],
            [
                'owner' => $ahmad,
                'category' => $categories['Electronics'],
                'name' => 'PlayStation 5 Disc Edition + 2 DualSense + 4 Game',
                'description' => 'Konsol game Sony PS5 versi disc lengkap dengan 2 stick DualSense wireless, kabel HDMI 2.1 Ultra High Speed. Termasuk game FIFA/FC 24, Spider-Man 2, God of War Ragnarok, dan Gran Turismo 7.',
                'price_per_day' => 175000,
                'condition' => 'like_new',
                'location' => 'Jakarta Selatan (Tebet)',
                'status' => 'available',
                'images' => [
                    'https://images.unsplash.com/photo-1606813907291-d86efa9b94db?w=800&auto=format&fit=crop&q=80',
                ],
            ],
        ];

        $createdItems = [];
        foreach ($itemsData as $iData) {
            $item = Item::create([
                'owner_id' => $iData['owner']->id,
                'category_id' => $iData['category']->id,
                'name' => $iData['name'],
                'description' => $iData['description'],
                'price_per_day' => $iData['price_per_day'],
                'condition' => $iData['condition'],
                'location' => $iData['location'],
                'status' => $iData['status'],
            ]);

            foreach ($iData['images'] as $imgUrl) {
                ItemImage::create([
                    'item_id' => $item->id,
                    'image_url' => $imgUrl,
                ]);
            }

            // Seed availability
            Availability::create([
                'item_id' => $item->id,
                'start_date' => Carbon::today()->addDays(1),
                'end_date' => Carbon::today()->addDays(30),
                'status' => 'available',
            ]);

            $createdItems[] = $item;
        }

        // 4. Rental Bookings
        $booking1 = Booking::create([
            'item_id' => $createdItems[0]->id, // Sony Alpha A7 III
            'renter_id' => $budi->id,
            'start_date' => Carbon::today()->subDays(10),
            'end_date' => Carbon::today()->subDays(7),
            'total_days' => 3,
            'total_price' => 750000,
            'status' => 'completed',
            'notes' => 'Disewa untuk dokumentasi wisuda universitas di JCC Senayan.',
        ]);

        $booking2 = Booking::create([
            'item_id' => $createdItems[1]->id, // Tenda Dome
            'renter_id' => $adit->id,
            'start_date' => Carbon::today()->subDays(4),
            'end_date' => Carbon::today()->subDays(2),
            'total_days' => 2,
            'total_price' => 150000,
            'status' => 'completed',
            'notes' => 'Camping akhir pekan bersama keluarga di Ranca Upas.',
        ]);

        $booking3 = Booking::create([
            'item_id' => $createdItems[2]->id, // DJI Drone
            'renter_id' => $budi->id,
            'start_date' => Carbon::today()->addDays(2),
            'end_date' => Carbon::today()->addDays(5),
            'total_days' => 3,
            'total_price' => 900000,
            'status' => 'confirmed',
            'notes' => 'Project syuting company profile di Surabaya Barat.',
        ]);

        $booking4 = Booking::create([
            'item_id' => $createdItems[3]->id, // PCX
            'renter_id' => $adit->id,
            'start_date' => Carbon::today()->addDays(1),
            'end_date' => Carbon::today()->addDays(6),
            'total_days' => 5,
            'total_price' => 625000,
            'status' => 'pending',
            'notes' => 'Liburan keliling pulau Bali selama 5 hari.',
        ]);

        $booking5 = Booking::create([
            'item_id' => $createdItems[6]->id, // Jas Tuxedo
            'renter_id' => $budi->id,
            'start_date' => Carbon::today()->subDays(15),
            'end_date' => Carbon::today()->subDays(13),
            'total_days' => 2,
            'total_price' => 300000,
            'status' => 'completed',
            'notes' => 'Acara gala dinner penghargaan kantor.',
        ]);

        // 5. Reviews
        Review::create([
            'booking_id' => $booking1->id,
            'item_id' => $createdItems[0]->id,
            'user_id' => $budi->id,
            'rating' => 5,
            'comment' => 'Kamera sangat bersih, sensor kinclong tanpa debu, baterai awet seharian penuh. Owner Mas Ahmad sangat ramah dan responsif!',
        ]);

        Review::create([
            'booking_id' => $booking2->id,
            'item_id' => $createdItems[1]->id,
            'user_id' => $adit->id,
            'rating' => 5,
            'comment' => 'Tenda sangat kokoh di cuaca hujan badai di Ranca Upas, bagian dalam tetap hangat dan kering. Sangat recommended sewa di sini.',
        ]);

        Review::create([
            'booking_id' => $booking5->id,
            'item_id' => $createdItems[6]->id,
            'user_id' => $budi->id,
            'rating' => 4,
            'comment' => 'Jas sangat rapi dan wangi sehabis laundry. Pas sekali di badan, tampil percaya diri saat gala dinner.',
        ]);

        // 6. Favorites
        Favorite::firstOrCreate(['user_id' => $budi->id, 'item_id' => $createdItems[0]->id]);
        Favorite::firstOrCreate(['user_id' => $budi->id, 'item_id' => $createdItems[2]->id]);
        Favorite::firstOrCreate(['user_id' => $adit->id, 'item_id' => $createdItems[1]->id]);
        Favorite::firstOrCreate(['user_id' => $adit->id, 'item_id' => $createdItems[9]->id]);

        // 7. Notifications
        Notification::create([
            'user_id' => $admin->id,
            'title' => 'Booking Baru Menunggu Konfirmasi',
            'message' => 'Renter Aditia mengajukan sewa untuk unit Honda PCX 160 ABS (5 hari).',
            'type' => 'booking_new',
            'is_read' => false,
        ]);

        Notification::create([
            'user_id' => $budi->id,
            'title' => 'Booking Drone DJI Dikonfirmasi',
            'message' => 'Owner telah mengonfirmasi sewa drone Anda untuk tanggal '.Carbon::today()->addDays(2)->format('d M Y').'.',
            'type' => 'booking_confirmed',
            'is_read' => true,
        ]);

        Notification::create([
            'user_id' => $admin->id,
            'title' => 'Pembayaran Sewa Diterima',
            'message' => 'Pembayaran booking #BK-003 senilai Rp 900.000 telah diverifikasi.',
            'type' => 'payment_success',
            'is_read' => false,
        ]);

        // 8. User Safety & Security Reports (Pusat Keamanan Pengguna)
        SafetyReport::create([
            'report_code' => 'SEC-2026-001',
            'reporter_id' => $ahmad->id,
            'reported_user_id' => $adit->id,
            'category' => 'damage_dispute',
            'title' => 'Goresan Pada Optik Lensa Kamera Sony FE 24-70mm',
            'description' => 'Setelah unit diserahterimakan kembali oleh penyewa, ditemukan goresan halus di elemen depan optik lensa kamera yang tidak tercatat dalam formulir inspeksi awal.',
            'severity' => 'medium',
            'status' => 'investigating',
            'admin_notes' => 'Admin telah meminta foto dokumentasi serah terima awal dan video unboxing dari owner.',
        ]);

        SafetyReport::create([
            'report_code' => 'SEC-2026-002',
            'reporter_id' => $siti->id,
            'reported_user_id' => $budi->id,
            'category' => 'loss_theft',
            'title' => 'Keterlambatan Pengembalian Drone DJI Lebih Dari 48 Jam',
            'description' => 'Penyewa belum mengembalikan unit drone DJI Mini 3 Pro dan nomor WhatsApp tidak dapat dihubungi sejak tanggal jatuh tempo sewa kemarin.',
            'severity' => 'high',
            'status' => 'pending',
            'admin_notes' => 'Tim investigasi telah mengirimkan surat peringatan pertama dan verifikasi kontak darurat.',
        ]);

        SafetyReport::create([
            'report_code' => 'SEC-2026-003',
            'reporter_id' => $admin->id,
            'reported_user_id' => $budi->id,
            'category' => 'identity_breach',
            'title' => 'Indikasi NIK KTP Tidak Sinkron Saat Verifikasi Toko',
            'description' => 'Sistem mendeteksi NIK yang diinputkan tidak cocok dengan nama pada foto KTP yang diunggah pengguna saat proses onboarding toko rental.',
            'severity' => 'critical',
            'status' => 'action_taken',
            'admin_notes' => 'Akun sementara ditangguhkan (suspend) untuk pencegahan penipuan sewa sampai KTP asli diverifikasi.',
            'resolved_at' => now(),
        ]);

        SafetyReport::create([
            'report_code' => 'SEC-2026-004',
            'reporter_id' => $adit->id,
            'reported_user_id' => $ahmad->id,
            'category' => 'item_mismatch',
            'title' => 'Kelengkapan Baterai Drone Hanya 1 Pcs Dari 3 Pcs',
            'description' => 'Penyewa melaporkan paket sewa combo drone yang diterima hanya berisi 1 unit baterai, berbeda dengan deskripsi paket katalog yang mencantumkan 3 unit baterai.',
            'severity' => 'low',
            'status' => 'resolved',
            'admin_notes' => 'Owner telah mengirimkan 2 baterai susulan dan menyetujui potongan diskon kompensasi 20% bagi penyewa.',
            'resolved_at' => now()->subDay(),
        ]);
    }
}
