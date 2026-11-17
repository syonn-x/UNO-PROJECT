<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Category;
use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');
    }

    /**
     * Test that guest users cannot access the profile dashboard.
     */
    public function test_guest_is_redirected_to_login_when_accessing_profile(): void
    {
        $response = $this->get('/profile');
        $response->assertRedirect('/login');
    }

    /**
     * Test that a renter can view their profile, rental history, and upgrade banner.
     */
    public function test_renter_can_view_profile_and_rental_history(): void
    {
        $renter = User::where('role', 'renter')->first();
        $this->assertNotNull($renter);

        $response = $this->actingAs($renter)->get('/profile?tab=profile');
        $response->assertStatus(200);
        $response->assertSee('Biodata Diri');
        $response->assertSee($renter->name);
        $response->assertSee('Penyewa');
        $response->assertSee('Buka Mitra Rental');

        // Check rental history tab
        $responseRentals = $this->actingAs($renter)->get('/profile?tab=rentals');
        $responseRentals->assertStatus(200);
        $responseRentals->assertSee('Riwayat Sewa Saya');
    }

    /**
     * Test that a renter can update their personal profile info.
     */
    public function test_renter_can_update_profile_info(): void
    {
        $renter = User::where('role', 'renter')->first();

        $response = $this->actingAs($renter)->put(route('profile.update'), [
            'name' => 'Budi Penyewa Baru',
            'email' => 'budi_updated@example.com',
            'phone' => '081298765432',
            'avatar_url' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=300',
        ]);

        $response->assertRedirect('/profile?tab=profile');
        $response->assertSessionHas('success');

        $renter->refresh();
        $this->assertSame('Budi Penyewa Baru', $renter->name);
        $this->assertSame('budi_updated@example.com', $renter->email);
        $this->assertSame('081298765432', $renter->phone);
    }

    /**
     * Test that a renter cannot arbitrarily upgrade without completing the required steps.
     */
    public function test_renter_cannot_arbitrarily_upgrade_to_owner_without_steps(): void
    {
        $renter = User::where('role', 'renter')->first();
        $this->assertFalse($renter->isOwner());

        // Attempting direct 1-click upgrade redirects to the 3-step onboarding wizard
        $response = $this->actingAs($renter)->post(route('profile.upgrade-owner'));
        $response->assertRedirect(route('profile.become-owner'));

        $renter->refresh();
        $this->assertFalse($renter->isOwner());
        $this->assertSame('renter', $renter->role);
    }

    /**
     * Test that a renter can access the Tokopedia-style become-owner onboarding wizard.
     */
    public function test_renter_can_access_become_owner_onboarding_wizard(): void
    {
        $renter = User::where('role', 'renter')->first();

        $response = $this->actingAs($renter)->get(route('profile.become-owner'));
        $response->assertStatus(200);
        $response->assertSee('Langkah Pendaftaran Mitra Rental');
        $response->assertSee('Langkah 1: Informasi Toko');
        $response->assertSee('Langkah 2: Verifikasi Identitas');
        $response->assertSee('Langkah 3: Syarat Layanan');
    }

    /**
     * Test that submitting incomplete onboarding data fails validation.
     */
    public function test_renter_fails_verification_if_data_incomplete(): void
    {
        $renter = User::where('role', 'renter')->first();

        $response = $this->actingAs($renter)->post(route('profile.become-owner.submit'), [
            'store_name' => 'AB', // too short (< 3)
            'nik' => '123', // invalid NIK (< 16 digits)
            // missing other fields and agreements
        ]);

        $response->assertSessionHasErrors([
            'store_name',
            'store_description',
            'store_city',
            'store_address',
            'phone',
            'nik',
            'agree_ownership',
            'agree_condition',
            'agree_terms',
        ]);

        $renter->refresh();
        $this->assertFalse($renter->isOwner());
    }

    /**
     * Test that a renter successfully becomes an Owner after completing all steps.
     */
    public function test_renter_successfully_becomes_owner_after_completing_all_steps(): void
    {
        $renter = User::where('role', 'renter')->first();

        $response = $this->actingAs($renter)->post(route('profile.become-owner.submit'), [
            'store_name' => 'Berkah Rental Outdoor & Kamera',
            'store_description' => 'Menyewakan kamera Sony mirrorless dan tenda dome berkualitas.',
            'store_city' => 'Jakarta Selatan',
            'store_address' => 'Jl. Tebet Barat Dalam No. 15, Tebet',
            'phone' => '081299887766',
            'nik' => '3174012345670001',
            'agree_ownership' => '1',
            'agree_condition' => '1',
            'agree_terms' => '1',
        ]);

        $response->assertRedirect('/profile?tab=my-items');
        $response->assertSessionHas('success');

        $renter->refresh();
        $this->assertTrue($renter->isOwner());
        $this->assertTrue($renter->is_verified_owner);
        $this->assertSame('Berkah Rental Outdoor & Kamera', $renter->store_name);
        $this->assertSame('3174012345670001', $renter->nik);
    }

    /**
     * Test that an owner can view their rental inventory and incoming booking orders.
     */
    public function test_owner_can_view_my_items_and_incoming_bookings(): void
    {
        $owner = User::where('role', 'owner')->first();
        $this->assertNotNull($owner);

        // Owner inventory tab
        $responseItems = $this->actingAs($owner)->get('/profile?tab=my-items');
        $responseItems->assertStatus(200);
        $responseItems->assertSee('Katalog Unit Rental Milik Saya');
        $responseItems->assertSee('Tambah Unit Rental Baru');

        // Owner incoming bookings tab
        $responseBookings = $this->actingAs($owner)->get('/profile?tab=incoming-bookings');
        $responseBookings->assertStatus(200);
        $responseBookings->assertSee('Pesanan Sewa Masuk');

        // Owner can also access renter features (renting items from others)
        $responseRentals = $this->actingAs($owner)->get('/profile?tab=rentals');
        $responseRentals->assertStatus(200);
        $responseRentals->assertSee('Riwayat Sewa Saya');
    }

    /**
     * Test that an owner can add a new rental item unit.
     */
    public function test_owner_can_add_rental_unit(): void
    {
        $owner = User::where('role', 'owner')->first();
        $category = Category::first();

        $response = $this->actingAs($owner)->post(route('profile.items.store'), [
            'category_id' => $category->id,
            'name' => 'Kamera Sony A7 IV Pro Owner',
            'description' => 'Unit kamera mirrorless full-frame profesional siap sewa lengkap lensa 24-70mm.',
            'price_per_day' => 250000,
            'condition' => 'like_new',
            'location' => 'Jakarta Barat',
            'image_url' => 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=800',
        ]);

        $response->assertRedirect('/profile?tab=my-items');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('items', [
            'owner_id' => $owner->id,
            'name' => 'Kamera Sony A7 IV Pro Owner',
            'price_per_day' => 250000,
        ]);
    }

    /**
     * Test that an owner can update item availability status and delete their item.
     */
    public function test_owner_can_toggle_status_and_delete_item(): void
    {
        $owner = User::where('role', 'owner')->first();
        $item = Item::where('owner_id', $owner->id)->first();

        if (! $item) {
            $item = Item::create([
                'owner_id' => $owner->id,
                'category_id' => Category::first()->id,
                'name' => 'Item Test Owner',
                'description' => 'Deskripsi testing owner item.',
                'price_per_day' => 100000,
                'condition' => 'good',
                'status' => 'available',
                'location' => 'Jakarta',
            ]);
        }

        // Toggle status to unavailable
        $responseStatus = $this->actingAs($owner)->post(route('profile.items.status', $item->id), [
            'status' => 'unavailable',
        ]);
        $responseStatus->assertRedirect();
        $item->refresh();
        $this->assertSame('unavailable', $item->status);

        // Delete item
        $responseDelete = $this->actingAs($owner)->delete(route('profile.items.destroy', $item->id));
        $responseDelete->assertRedirect('/profile?tab=my-items');
        $this->assertDatabaseMissing('items', ['id' => $item->id]);
    }

    /**
     * Test that an owner can confirm an incoming booking.
     */
    public function test_owner_can_manage_incoming_booking_status(): void
    {
        $owner = User::where('role', 'owner')->first();
        $renter = User::where('role', 'renter')->first();

        $item = Item::firstOrCreate(
            ['owner_id' => $owner->id, 'name' => 'Drone DJI Mini 3 Pro Test'],
            [
                'category_id' => Category::first()->id,
                'description' => 'Drone ringan 4k HDR sewa harian.',
                'price_per_day' => 150000,
                'condition' => 'like_new',
                'status' => 'available',
                'location' => 'Jakarta Selatan',
            ]
        );

        $booking = Booking::create([
            'renter_id' => $renter->id,
            'item_id' => $item->id,
            'start_date' => now()->addDays(2),
            'end_date' => now()->addDays(4),
            'total_days' => 2,
            'total_price' => 300000,
            'status' => 'pending',
            'notes' => 'Testing booking owner approval',
        ]);

        $response = $this->actingAs($owner)->post(route('profile.incoming-bookings.status', $booking->id), [
            'status' => 'confirmed',
        ]);

        $response->assertRedirect();
        $booking->refresh();
        $this->assertSame('confirmed', $booking->status);
    }
}
