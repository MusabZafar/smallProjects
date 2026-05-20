<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Item;
use App\Models\Category;

/**
 * ItemsTest conducts automated feature validation to assert the business logic,
 * routing, validation constraints, and database states of the Car Rental Fleet Lister.
 */
class ItemsTest extends TestCase
{
    // The RefreshDatabase trait clears and migrates the database schema before each test run,
    // guaranteeing a pristine environment and preventing data bleed between assertions.
    use RefreshDatabase;

    /**
     * Test 1: Verify the /items home page loads successfully.
     */
    public function test_items_page_loads_successfully(): void
    {
        // Execute an HTTP GET request to the items route.
        $response = $this->get('/items');

        // Assert response is HTTP 200 (Success) & page holds the header title 'Car Fleet Listing'.
        $response->assertStatus(200);
        $response->assertSee('Car Fleet Listing');
    }

    /**
     * Test 2: Verify the /items page properly displays records and Category relationships.
     */
    public function test_items_page_shows_a_vehicle_record(): void
    {
        // 1. Create a dummy Category in database.
        $category = Category::create([
            'name' => 'Economy',
        ]);

        // 2. Create a vehicle record associated with the Category.
        Item::create([
            'product' => 'Toyota Corolla',
            'category' => 'Economy',
            'category_id' => $category->id,
            'quantity' => 12,
            'price' => 45,
        ]);

        // 3. Request index list view.
        $response = $this->get('/items');

        // Assert the page lists vehicle product name and category details.
        $response->assertStatus(200);
        $response->assertSee('Toyota Corolla');
        $response->assertSee('Economy');
    }

    /**
     * Test 3: Verify the vehicle addition rules reject empty input payloads.
     */
    public function test_store_validation_rejects_empty_submission(): void
    {
        // Send an empty POST payload to the store endpoint.
        $response = $this->post('/items', []);

        // Assert the user session is immediately populated with validation errors.
        $response->assertSessionHasErrors(['product', 'category', 'quantity', 'price']);
    }

    /**
     * Test 4: Verify that a valid submission successfully creates a vehicle and dynamic category.
     */
    public function test_vehicle_can_be_created_successfully(): void
    {
        // 1. Define standard valid form payload parameters.
        $payload = [
            'product' => 'Skoda Octavia',
            'category' => 'Compact',
            'quantity' => 7,
            'price' => 75,
        ];

        // 2. Dispatch a POST creation request.
        $response = $this->post('/items', $payload);

        // 3. Assert a successful redirect back to listing overview.
        $response->assertRedirect('/items');

        // 4. Assert that the vehicle was successfully saved inside the SQLite database.
        $this->assertDatabaseHas('items', [
            'product' => 'Skoda Octavia',
            'quantity' => 7,
            'price' => 75,
        ]);

        // 5. Assert the seeder/controller created the new category record automatically.
        $this->assertDatabaseHas('categories', [
            'name' => 'Compact',
        ]);
    }

    /**
     * Test 5: Verify that the low stock filter lists only target low stock vehicles.
     */
    public function test_low_stock_filter_shows_low_quantity_vehicle(): void
    {
        // 1. Setup category wrapper.
        $category = Category::create(['name' => 'Electric']);

        // 2. Create one vehicle below low stock threshold (< 5).
        $lowStockVehicle = Item::create([
            'product' => 'Tesla Model 3',
            'category' => 'Electric',
            'category_id' => $category->id,
            'quantity' => 2, // Low stock!
            'price' => 150,
        ]);

        // 3. Create one vehicle with normal stock (>= 5).
        $normalStockVehicle = Item::create([
            'product' => 'Nissan Leaf',
            'category' => 'Electric',
            'category_id' => $category->id,
            'quantity' => 9, // Normal stock!
            'price' => 80,
        ]);

        // 4. Dispatch a GET request to the low stock endpoint.
        $response = $this->get('/items/lowstock/5');

        // Assert response loads successfully.
        $response->assertStatus(200);

        // Assert that the low stock item is displayed on the page.
        $response->assertSee('Tesla Model 3');

        // Assert that the normal stock item is omitted from this list view.
        $response->assertDontSee('Nissan Leaf');
    }
}
