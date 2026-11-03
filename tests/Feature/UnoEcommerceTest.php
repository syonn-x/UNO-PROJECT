<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UnoEcommerceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');
    }

    /**
     * Test Landing Page renders successfully.
     */
    public function test_landing_page_renders_successfully(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('USE NOT OWN');
        $response->assertSee('10.61.4.129');
    }

    /**
     * Test Tokopedia-style Dedicated Catalog Page.
     */
    public function test_catalog_page_renders_tokopedia_style(): void
    {
        $response = $this->get('/catalog');
        $response->assertStatus(200);
        $response->assertSee('Katalog Sewa');
        $response->assertSee('Filter');
        $response->assertSee('Paling Sesuai');
        $response->assertSee('Kategori');

        // Test with search query
        $item = Item::first();
        $keyword = explode(' ', $item->name)[0];
        $responseSearch = $this->get('/catalog?q='.$keyword);
        $responseSearch->assertStatus(200);
        $responseSearch->assertSee($keyword);
    }

    /**
     * Test Tokopedia-style Item Rental Detail page.
     */
    public function test_item_rental_page_renders_tokopedia_style(): void
    {
        $item = Item::first();
        $this->assertNotNull($item);

        $response = $this->get('/items/'.$item->id);
        $response->assertStatus(200);
        $response->assertSee($item->name);
        $response->assertSee('Atur Periode');
        $response->assertSee('Ajukan Sewa Sekarang');
        $response->assertSee('Ketentuan Sewa');
    }

    /**
     * Test Login page.
     */
    public function test_login_page_renders(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('U.N.O');
        $response->assertSee('USE NOT OWN');
    }

    /**
     * Test Admin Dashboard and Modules.
     */
    public function test_admin_dashboard_renders(): void
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->get('/admin/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Dashboard Overview');
        $response->assertSee('10.61.4.129');
    }

    public function test_admin_master_data_modules(): void
    {
        $admin = User::where('role', 'admin')->first();

        // Categories
        $this->actingAs($admin)->get('/admin/categories')->assertStatus(200)->assertSee('Daftar Kategori');

        // Items
        $this->actingAs($admin)->get('/admin/items')->assertStatus(200)->assertSee('Katalog Unit Rental');
    }

    public function test_admin_transactions_and_reports(): void
    {
        $admin = User::where('role', 'admin')->first();

        // Bookings
        $this->actingAs($admin)->get('/admin/bookings')->assertStatus(200)->assertSee('Kelola Booking');

        // Availability
        $this->actingAs($admin)->get('/admin/availability')->assertStatus(200)->assertSee('Jadwal Slot');

        // Reviews
        $this->actingAs($admin)->get('/admin/reviews')->assertStatus(200)->assertSee('Moderasi Ulasan');

        // Users
        $this->actingAs($admin)->get('/admin/users')->assertStatus(200)->assertSee('Manajemen Pengguna');

        // Reports: Sales
        $this->actingAs($admin)->get('/admin/reports/sales')->assertStatus(200)->assertSee('Laporan Transaksi & Pendapatan');

        // Reports: Inventory
        $this->actingAs($admin)->get('/admin/reports/inventory')->assertStatus(200)->assertSee('Laporan Okupansi');

        // Reports: Print
        $this->actingAs($admin)->get('/admin/reports/print')->assertStatus(200)->assertSee('LAPORAN TRANSAKSI SEWA');

        // API Docs
        $this->actingAs($admin)->get('/admin/api-docs')->assertStatus(200)->assertSee('REST API');
    }

    /**
     * Test REST API Endpoints.
     */
    public function test_api_health_endpoint(): void
    {
        $response = $this->getJson('/api/health');
        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'online',
            'server_ip' => '10.61.4.129',
        ]);
    }

    public function test_api_categories_and_items(): void
    {
        // Categories
        $response = $this->getJson('/api/v1/categories');
        $response->assertStatus(200);
        $response->assertJsonStructure(['success', 'message', 'data']);

        // Items
        $itemResponse = $this->getJson('/api/v1/items');
        $itemResponse->assertStatus(200);
        $itemResponse->assertJsonStructure(['success', 'data' => ['data']]);

        // Executive report summary
        $reportResponse = $this->getJson('/api/v1/reports/summary');
        $reportResponse->assertStatus(200);
        $reportResponse->assertJsonStructure([
            'success',
            'data' => [
                'metrics' => [
                    'total_revenue',
                    'total_bookings',
                    'total_items',
                ],
            ],
        ]);
    }

    /**
     * Test Quick Rental Booking Submission as Guest.
     */
    public function test_quick_rental_booking_submission_as_guest(): void
    {
        $item = Item::first();

        $response = $this->postJson('/book', [
            'item_id' => $item->id,
            'start_date' => now()->toDateString(),
            'end_date' => now()->addDays(2)->toDateString(),
            'renter_name' => 'QA Tester Guest',
            'renter_phone' => '089911223344',
            'notes' => 'Testing automated booking from landing page as guest',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'item_name' => $item->name,
            'renter_name' => 'QA Tester Guest',
        ]);
        $this->assertDatabaseHas('bookings', [
            'item_id' => $item->id,
            'status' => 'pending',
        ]);
    }

    /**
     * Test Rental Booking Submission as Authenticated User (Regression Test for Bug).
     */
    public function test_rental_booking_submission_as_authenticated_user(): void
    {
        $item = Item::first();
        $user = User::where('role', 'renter')->first();

        // User is logged in, does not provide renter_name or renter_phone
        $response = $this->actingAs($user)->postJson('/book', [
            'item_id' => $item->id,
            'start_date' => now()->toDateString(),
            'end_date' => now()->addDays(3)->toDateString(),
            'notes' => 'Testing booking as logged in user without form renter_name',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'item_name' => $item->name,
            'renter_name' => $user->name,
        ]);

        $this->assertDatabaseHas('bookings', [
            'item_id' => $item->id,
            'renter_id' => $user->id,
            'total_days' => 4,
        ]);
    }

    /**
     * Test Rental Booking Date Validation.
     */
    public function test_rental_booking_date_validation_rejects_inverted_dates(): void
    {
        $item = Item::first();
        $user = User::where('role', 'renter')->first();

        $response = $this->actingAs($user)->postJson('/book', [
            'item_id' => $item->id,
            'start_date' => now()->addDays(5)->toDateString(),
            'end_date' => now()->addDays(2)->toDateString(), // before start_date
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['end_date']);
    }
}
