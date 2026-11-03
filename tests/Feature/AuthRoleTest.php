<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthRoleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');
    }

    /**
     * Unauthenticated guest cannot access admin dashboard.
     */
    public function test_admin_routes_are_protected_from_guests(): void
    {
        $response = $this->get('/admin/dashboard');

        $response->assertRedirect('/login');
        $response->assertSessionHas('error');
    }

    /**
     * Renter cannot access admin dashboard and gets redirected to landing with error.
     */
    public function test_renter_cannot_access_admin_panel(): void
    {
        $renter = User::where('role', 'renter')->first();
        $this->assertNotNull($renter);

        $response = $this->actingAs($renter)->get('/admin/dashboard');

        $response->assertRedirect('/');
        $response->assertSessionHas('error', 'Akses ditolak! Halaman Admin Panel hanya dapat diakses oleh Administrator.');
    }

    /**
     * Owner cannot access admin dashboard and gets redirected to landing with error.
     */
    public function test_owner_cannot_access_admin_panel(): void
    {
        $owner = User::where('role', 'owner')->first();
        $this->assertNotNull($owner);

        $response = $this->actingAs($owner)->get('/admin/dashboard');

        $response->assertRedirect('/');
        $response->assertSessionHas('error', 'Akses ditolak! Halaman Admin Panel hanya dapat diakses oleh Administrator.');
    }

    /**
     * Admin can access admin dashboard.
     */
    public function test_admin_can_access_admin_dashboard(): void
    {
        $admin = User::where('role', 'admin')->first();
        $this->assertNotNull($admin);

        $response = $this->actingAs($admin)->get('/admin/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Admin UNO Pusat');
    }

    /**
     * Renter registration creates user with role renter and logs them in.
     */
    public function test_renter_can_register_successfully(): void
    {
        $response = $this->post('/register', [
            'name' => 'Dimas Penyewa',
            'email' => 'dimas@renter.test',
            'phone' => '081234567899',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
            'role' => 'renter',
        ]);

        $response->assertRedirect('/');
        $response->assertSessionHas('success');

        $user = User::where('email', 'dimas@renter.test')->first();
        $this->assertNotNull($user);
        $this->assertSame('renter', $user->role);
        $this->assertTrue($user->isRenter());
        $this->assertFalse($user->isAdmin());
        $this->assertAuthenticatedAs($user);
    }

    /**
     * Owner registration creates user with role owner and logs them in.
     */
    public function test_owner_can_register_successfully(): void
    {
        $response = $this->post('/register', [
            'name' => 'Rental Outdoor Jaya',
            'email' => 'owner@outdoor.test',
            'phone' => '081987654321',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
            'role' => 'owner',
        ]);

        $response->assertRedirect('/');
        $response->assertSessionHas('success');

        $user = User::where('email', 'owner@outdoor.test')->first();
        $this->assertNotNull($user);
        $this->assertSame('owner', $user->role);
        $this->assertTrue($user->isOwner());
        $this->assertFalse($user->isAdmin());
        $this->assertAuthenticatedAs($user);
    }

    /**
     * Login redirects admin to dashboard and renter/owner to landing.
     */
    public function test_login_redirects_based_on_role(): void
    {
        // 1. Admin login -> /admin/dashboard
        $responseAdmin = $this->post('/login', [
            'email' => 'admin@uno.com',
            'password' => 'admin123',
        ]);
        $responseAdmin->assertRedirect('/admin/dashboard');

        $this->post('/logout');

        // 2. Renter login -> /
        $responseRenter = $this->post('/login', [
            'email' => 'budi@example.com',
            'password' => 'password123',
        ]);
        $responseRenter->assertRedirect('/');

        $this->post('/logout');

        // 3. Owner login -> /
        $responseOwner = $this->post('/login', [
            'email' => 'ahmad@example.com',
            'password' => 'password123',
        ]);
        $responseOwner->assertRedirect('/');
    }

    /**
     * Navbar visibility: guests and renters cannot see admin panel button.
     */
    public function test_navbar_visibility_for_guest_renter_and_admin(): void
    {
        // 1. Guest
        $guestRes = $this->get('/');
        $guestRes->assertStatus(200);
        $guestRes->assertSee('Masuk');
        $guestRes->assertSee('Daftar');
        $guestRes->assertDontSee('Dashboard Admin');

        // 2. Renter
        $renter = User::where('role', 'renter')->first();
        $renterRes = $this->actingAs($renter)->get('/');
        $renterRes->assertStatus(200);
        $renterRes->assertSee($renter->name);
        $renterRes->assertSee('Penyewa (Renter)');
        $renterRes->assertDontSee('Dashboard Admin');

        // 3. Admin
        $admin = User::where('role', 'admin')->first();
        $adminRes = $this->actingAs($admin)->get('/');
        $adminRes->assertStatus(200);
        $adminRes->assertSee('Dashboard Admin');
    }
}
