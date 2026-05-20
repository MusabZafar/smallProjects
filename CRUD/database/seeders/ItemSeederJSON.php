<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;
use App\Models\Category;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

/**
 * ItemSeederJSON handles the automated parsing and population of the database 
 * using the static fleet listing defined in cars.json.
 */
class ItemSeederJSON extends Seeder
{
    public function run(): void
    {
        // 1. TEMPORARILY DISABLE FOREIGN KEY CHECKS
        // This is crucial during development to safely truncate (clear) tables containing 
        // constraints, preventing SQLite/MySQL from throwing relationship violations.
        Schema::disableForeignKeyConstraints();

        // Clear out existing records so every seed starts with a clean slate.
        Item::truncate();
        Category::truncate();

        // Re-enable constraint checks for database transaction safety.
        Schema::enableForeignKeyConstraints();

        // 2. READ & DECODE JSON FILE
        // Locate cars.json inside database/data, read raw string content, 
        // and decode into a readable associative array.
        $json = File::get(database_path('data/cars.json'));
        $vehicles = json_decode($json, true);

        // Tracker dictionary mapping Category Name (string) -> Category ID (int).
        $categoryMap = [];

        // 3. SEED CATEGORIES FIRST
        // Loop through all vehicle definitions, extract their textual category, 
        // and register distinct Category models to get their autoincrement primary keys.
        foreach ($vehicles as $vehicle) {
            $name = $vehicle['category'];

            // If we have not created this category yet, write it to database.
            if (! isset($categoryMap[$name])) {
                $category = Category::create([
                    'name' => $name,
                ]);

                // Store Category ID in our lookup dictionary.
                $categoryMap[$name] = $category->id;
            }
        }

        // 4. SEED VEHICLES
        // Loop through the vehicles list again to create Item records, 
        // dynamically linking them using the Category ID lookup we built in Step 3.
        foreach ($vehicles as $vehicle) {
            Item::create([
                'product' => $vehicle['product'],
                'category' => $vehicle['category'],
                // Set the foreign key constraint referencing Category.
                'category_id' => $categoryMap[$vehicle['category']],
                'quantity' => $vehicle['quantity'],
                'price' => $vehicle['price'],
            ]);
        }

        // Output success feedback statement directly inside the CLI output.
        $this->command->info('Seeded ' . count($vehicles) . ' vehicles from cars.json');
    }
}
