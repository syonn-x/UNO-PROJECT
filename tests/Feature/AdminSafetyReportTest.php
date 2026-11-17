<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Item;
use App\Models\SafetyReport;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminSafetyReportTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_non_admin_cannot_access_safety_reports(): void
    {
        $renter = User::where('role', '!=', 'admin')->first();

        $response = $this->actingAs($renter)->get('/admin/safety-reports');
        $response->assertRedirect(route('landing'));
    }

    public function test_admin_can_view_safety_reports_index(): void
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->get('/admin/safety-reports');
        $response->assertStatus(200);
        $response->assertSee('Laporan Keamanan');
        $response->assertSee('Butuh Investigasi');
    }

    public function test_admin_can_view_single_safety_report_detail(): void
    {
        $admin = User::where('role', 'admin')->first();
        $report = SafetyReport::first();

        $this->assertNotNull($report);

        $response = $this->actingAs($admin)->get("/admin/safety-reports/{$report->id}");
        $response->assertStatus(200);
        $response->assertSee($report->report_code);
        $response->assertSee('Investigasi Kasus');
    }

    public function test_admin_can_update_safety_report_status_and_suspend_user(): void
    {
        $admin = User::where('role', 'admin')->first();
        $report = SafetyReport::with('reportedUser')->first();

        $this->assertNotNull($report);
        $this->assertNotNull($report->reportedUser);

        $response = $this->actingAs($admin)->post("/admin/safety-reports/{$report->id}/status", [
            'status' => 'action_taken',
            'admin_notes' => 'Tindakan disiplin: Akun terlapor dibekukan sementara.',
            'suspend_reported_user' => 1,
        ]);

        $response->assertRedirect("/admin/safety-reports/{$report->id}");

        $report->refresh();
        $this->assertEquals('action_taken', $report->status);
        $this->assertEquals('Tindakan disiplin: Akun terlapor dibekukan sementara.', $report->admin_notes);
        $this->assertNotNull($report->resolved_at);

        $report->reportedUser->refresh();
        $this->assertEquals('suspended', $report->reportedUser->status);
    }

    public function test_admin_can_view_printable_safety_report(): void
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->get('/admin/safety-reports/print');
        $response->assertStatus(200);
        $response->assertSee('BERITA ACARA KEAMANAN');
    }

    public function test_admin_can_verify_and_approve_owner_kyc(): void
    {
        $admin = User::where('role', 'admin')->first();

        $applicant = User::create([
            'name' => 'Calon Mitra',
            'email' => 'mitra.calon@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
            'store_name' => 'Toko Kamera Pro',
            'store_address' => 'Jl. Merdeka No 1',
            'id_card_photo' => 'kyc/sample-ktp.jpg',
            'is_verified_owner' => false,
        ]);

        $this->assertEquals('pending', $applicant->owner_status);

        $response = $this->actingAs($admin)->post("/admin/users/{$applicant->id}/verify-owner", [
            'action' => 'approve',
        ]);

        $response->assertRedirect();

        $applicant->refresh();
        $this->assertTrue($applicant->is_owner);
        $this->assertEquals('approved', $applicant->owner_status);
        $this->assertEquals('owner', $applicant->role);
        $this->assertTrue($applicant->is_verified_owner);
    }

    public function test_renter_can_submit_fraud_report_and_creates_thread_message(): void
    {
        $renter = User::where('role', '!=', 'admin')->first();
        $booking = Booking::where('renter_id', $renter->id)->first();

        if (! $booking) {
            $owner = User::where('role', 'owner')->first();
            $item = Item::first();
            $booking = Booking::create([
                'item_id' => $item->id,
                'renter_id' => $renter->id,
                'start_date' => now()->toDateString(),
                'end_date' => now()->addDays(2)->toDateString(),
                'total_days' => 2,
                'total_price' => 150000,
                'status' => 'confirmed',
            ]);
        }

        $response = $this->actingAs($renter)->post('/profile/fraud-reports', [
            'booking_id' => $booking->id,
            'fraud_type' => 'Uang Sudah Ditransfer Pemilik Kabur / Menghilang',
            'message' => 'Saya sudah mentransfer uang sewa sebesar 150.000 ke rekening pemilik, tapi nomor WA saya langsung diblokir dan barang tidak dikirimkan.',
        ]);

        $response->assertRedirect(route('profile.index', ['tab' => 'fraud-messages']));

        $report = SafetyReport::where('booking_id', $booking->id)->latest()->first();
        $this->assertNotNull($report);
        $this->assertEquals('fraud_payment', $report->category);
        $this->assertEquals('pending', $report->status);

        // Check that initial SafetyReportMessage exists
        $this->assertDatabaseHas('safety_report_messages', [
            'safety_report_id' => $report->id,
            'user_id' => $renter->id,
            'is_admin' => false,
        ]);
    }

    public function test_admin_can_view_fraud_messages_inbox_and_reply_to_victim(): void
    {
        $admin = User::where('role', 'admin')->first();
        $report = SafetyReport::first();

        // 1. Admin views messages inbox
        $response = $this->actingAs($admin)->get('/admin/messages');
        $response->assertStatus(200);
        $response->assertSee('Kotak Masuk Aduan Penipuan');

        // 2. Admin replies to the victim
        $replyResponse = $this->actingAs($admin)->post("/admin/messages/{$report->id}/reply", [
            'message' => 'Halo pelapor, aduan Anda telah diterima. Kami sedang mengamankan data transaksi.',
            'status' => 'investigating',
        ]);

        $replyResponse->assertRedirect("/admin/messages/{$report->id}");

        $this->assertDatabaseHas('safety_report_messages', [
            'safety_report_id' => $report->id,
            'user_id' => $admin->id,
            'is_admin' => true,
        ]);

        $report->refresh();
        $this->assertEquals('investigating', $report->status);
    }

    public function test_admin_can_one_click_suspend_fraudster_from_message_thread(): void
    {
        $admin = User::where('role', 'admin')->first();
        $report = SafetyReport::with('reportedUser')->first();

        $this->assertNotNull($report->reportedUser);

        $response = $this->actingAs($admin)->post("/admin/messages/{$report->id}/suspend-user");
        $response->assertRedirect("/admin/messages/{$report->id}");

        $report->reportedUser->refresh();
        $this->assertEquals('suspended', $report->reportedUser->status);

        $report->refresh();
        $this->assertEquals('action_taken', $report->status);
        $this->assertNotNull($report->resolved_at);
    }
}
