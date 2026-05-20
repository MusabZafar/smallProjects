<?php

namespace Tests\Feature\Api;

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Tests\TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    public function test_api_returns_books_list(): void
    {
        $user = User::factory()->create();

        $book = Book::create([
            'title' => 'Harry Potter',
            'author' => 'JK Rolling',
            'description' => 'Magical World',
            'published_year' => '1998',
        ]);

        $response = $this->actingAs($user, 'sanctum')->getJson('/api/books');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJson([
                'data' => [
                    [
                        'id' => $book->id,
                        'title' => 'Harry Potter'
                    ]
                ],
            ]);
    }

    public function test_api_book_update_successful(): void
    {
        $user = User::factory()->create();

        $book = Book::create([
            'title' => 'Harry Potter',
            'author' => 'JK Rolling',
            'description' => 'Magical World',
            'published_year' => '1998',
        ]);

        $bookChanges = [
            'title' => 'Jungle Book',
            'description' => 'Childrens story about animals',
            'author' => 'Kipling',
            'published_year' => '1894',
        ];

        $response = $this->actingAs($user, 'sanctum')->putJson("/api/books/{$book->id}", $bookChanges);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'id' => $book->id,
                'title' => 'Jungle Book',
                'author' => 'Kipling',
                'description' => 'Childrens story about animals',
                'published_year' => 1894,
            ]);
    }
}
