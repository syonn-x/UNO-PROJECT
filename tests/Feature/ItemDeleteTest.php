<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemDeleteTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test admin can delete an item without bookings.
     */
    public function test_admin_can_delete_item_without_bookings(): void
    {
        $this->artisan('db:seed');
        $admin = User::where('role', 'admin')->first();

        // Find an item without bookings (e.g. item 5, 6, 8, 9, or 10)
        $item = Item::doesntHave('bookings')->first();
        $this->assertNotNull($item);

        $response = $this->actingAs($admin)->delete('/admin/items/'.$item->id);
        $response->assertRedirect();
        $this->assertDatabaseMissing('items', ['id' => $item->id]);
    }

    /**
     * Test deleting an item with bookings.
     */
    public function test_deleting_item_with_bookings(): void
    {
        $this->artisan('db:seed');
        $admin = User::where('role', 'admin')->first();

        $itemWithBooking = Item::has('bookings')->first();
        $this->assertNotNull($itemWithBooking);

        $itemId = $itemWithBooking->id;
        $bookingIds = $itemWithBooking->bookings->pluck('id')->all();

        $response = $this->actingAs($admin)->delete('/admin/items/'.$itemId);
        $response->assertRedirect();
        $this->assertDatabaseMissing('items', ['id' => $itemId]);
        foreach ($bookingIds as $bId) {
            $this->assertDatabaseMissing('bookings', ['id' => $bId]);
        }
    }

    /**
     * Test admin can delete an item via AJAX JSON request.
     */
    public function test_admin_can_delete_item_via_ajax(): void
    {
        $this->artisan('db:seed');
        $admin = User::where('role', 'admin')->first();
        $item = Item::first();

        $response = $this->actingAs($admin)->deleteJson('/admin/items/'.$item->id);
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);
        $this->assertDatabaseMissing('items', ['id' => $item->id]);
    }

    /**
     * Test item with quotes in name can be deleted.
     */
    public function test_can_delete_item_with_quotes_in_name(): void
    {
        $this->artisan('db:seed');
        $admin = User::where('role', 'admin')->first();

        // Polygon Siskiu 29" has double quote in name
        $item = Item::where('name', 'like', '%29"%')->first();
        $this->assertNotNull($item);

        $response = $this->actingAs($admin)->deleteJson('/admin/items/'.$item->id);
        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        $this->assertDatabaseMissing('items', ['id' => $item->id]);
    }
}
