<?php

namespace App\Http\Controllers;

use App\Http\Resources\GamesResource;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rule;

/**
 * GamesController handles all API operations for the 'games' resource.
 */
class GamesController extends Controller
{
    /**
     * Display a listing of the games.
     * Supports filtering by genre_id and caching results.
     */
    public function index(Request $request)
    {
        // 1. Validate genre_id if it exists in the query string
        $request->validate([
            'genre_id' => ['nullable', 'integer', 'exists:genres,id'],
        ]);

        // 2. Generate a unique cache key based on the filter
        $cacheKey = 'games:' . ($request->genre_id ?? 'all');

        // 3. Retrieve games from cache or database (cache for 3600 seconds / 1 hour)
        return Cache::remember($cacheKey, 3600, function () use ($request) {
            $games = Game::with('genres')
                // Use when() to conditionally add a where clause if genre_id is present
                ->when($request->integer('genre_id'), function ($query, $genreId) {
                    // Query the relationship to filter games by the pivot table genre_id
                    return $query->whereHas('genres', fn ($q) => $q->where('genres.id', $genreId));
                })
                // Always sort alphabetically by title as per requirements
                ->orderBy('title', 'asc')
                ->get();

            // Return using the API Resource for consistent JSON structure
            return GamesResource::collection($games);
        });
    }

    /**
     * Store a newly created game.
     */
    public function store(Request $request)
    {
        // 1. Validate incoming data
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255', 'unique:games,title'],
            'description' => ['nullable', 'string'],
            'genres' => ['nullable', 'array'],
            'genres.*' => ['integer', 'exists:genres,id'],
        ]);

        // 2. Create the game record
        $game = Game::create([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
        ]);

        // 3. Attach genres to the pivot table (if any provided)
        if (!empty($data['genres'])) {
            $game->genres()->attach($data['genres']);
        }

        // 4. Flush (clear) the cache so users see the new game immediately
        Cache::flush();

        // Load genres relationship before returning
        return new GamesResource($game->load('genres'));
    }

    /**
     * Display the specified game.
     */
    public function show(Game $game)
    {
        // Return a single game with its genres loaded
        return new GamesResource($game->load('genres'));
    }

    /**
     * Update the specified game.
     */
    public function update(Request $request, Game $game)
    {
        // 1. Validate data (ignoring the current record's ID for uniqueness)
        $data = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('games', 'title')->ignore($game->id),
            ],
            'description' => ['nullable', 'string'],
            'genres' => ['nullable', 'array'],
            'genres.*' => ['integer', 'exists:genres,id'],
        ]);

        // 2. Update basic fields
        $game->update([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
        ]);

        // 3. Synchronize pivot table relationships
        // sync() removes existing links and adds new ones to match the provided array
        if (array_key_exists('genres', $data)) {
            $game->genres()->sync($data['genres'] ?? []);
        }

        // 4. Clear cache to reflect updates
        Cache::flush();

        return new GamesResource($game->load('genres'));
    }

    /**
     * Remove the specified game from storage.
     */
    public function destroy(Game $game)
    {
        // 1. Delete the record (pivot table links will cascade delete)
        $game->delete();

        // 2. Clear cache
        Cache::flush();

        // Return 204 No Content
        return response()->noContent();
    }
}