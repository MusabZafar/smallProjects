<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\Genre;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

/**
 * GameSeederJSON automates the importing of game data from a external JSON file.
 */
class GameSeederJSON extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Define the path to the JSON data file
        $jsonPath = database_path('data/games.json');

        // 2. Safety check: Stop if the file doesn't exist to prevent errors
        if (!File::exists($jsonPath)) {
            $this->command->error('games.json file not found!');
            return;
        }

        // 3. Read the file contents and decode into a PHP array
        $json = File::get($jsonPath);
        $games = json_decode($json, true);

        // 4. Validate that the decoding was successful
        if (!is_array($games)) {
            $this->command->error('games.json did not decode to an array.');
            return;
        }

        // 5. Iterate through each game entry in the JSON
        foreach ($games as $gameData) {
            // firstOrCreate ensures we don't create duplicate games if seeder runs twice
            $game = Game::firstOrCreate(
                ['title' => $gameData['title']],
                ['description' => $gameData['description'] ?? null]
            );

            // 6. Process the 'genres' string array for this game
            $genreIds = collect($gameData['genres'] ?? [])
                ->map(function ($name) {
                    // Create the genre if it's new, otherwise retrieve the existing ID
                    return Genre::firstOrCreate(['name' => $name])->id;
                })
                ->all();

            // 7. Sync the genres to the pivot table
            // This links the game to all its associated genres in 'game_genre'
            $game->genres()->sync($genreIds);
        }

        // 8. Log success message to the console
        $this->command->info('Successfully seeded ' . count($games) . ' games with genres.');
    }
}