<?php

namespace Tests\Feature\Api;

use App\Models\Game;
use App\Models\Genre;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class GameTest extends TestCase
{
    use RefreshDatabase;

    public function test_api_returns_games_list(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $genre = Genre::create(['name' => 'Indie']);

        $game = Game::create([
            'title' => 'Test Game',
            'description' => 'This is a test game description.',
        ]);

        $game->genres()->attach([$genre->id]);

        $response = $this->getJson(route('games.index'));

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonFragment([
                'id' => $game->id,
                'title' => 'Test Game',
            ]);
    }

    public function test_api_game_update_successful(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $genre1 = Genre::create(['name' => 'Action']);
        $genre2 = Genre::create(['name' => 'Strategy']);

        $game = Game::create([
            'title' => 'Old Title',
            'description' => 'Old description',
        ]);

        $game->genres()->attach([$genre1->id]);

        $payload = [
            'title' => 'New Title',
            'description' => 'Updated description',
            'genres' => [$genre1->id, $genre2->id],
        ];

        $response = $this->putJson(route('games.update', $game), $payload);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'title' => 'New Title',
                'description' => 'Updated description',
            ]);

        $this->assertDatabaseHas('games', [
            'id' => $game->id,
            'title' => 'New Title',
        ]);

        $this->assertDatabaseHas('game_genre', [
            'game_id' => $game->id,
            'genre_id' => $genre2->id,
        ]);
    }
}