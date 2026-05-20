<?php

namespace App\Http\Controllers;

use App\Http\Resources\BooksResource;
use App\Models\Book;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    /**
     * Display a listing of all books.
     * We use query() to build a request, sort it, and then return a collection 
     * of BooksResource to ensure the JSON is formatted correctly.
     */
    public function index()
    {
        $books = Book::query()
            ->orderBy('published_year', 'desc') // Show newest books first
            ->orderBy('title', 'asc')           // Then alphabetize by title
            ->get();

        return BooksResource::collection($books);
    }

    /**
     * Store a newly created book in the database.
     * We validate the incoming request first. If validation fails, 
     * Laravel automatically returns a 422 JSON error.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'description' => 'required|string',
            'published_year' => 'required|integer|min:1000|max:' . date('Y'),
        ]);

        $book = Book::create($validated);

        return new BooksResource($book); // Return the newly created book
    }

    /**
     * Display a specific book by its ID.
     * Laravel uses 'Route Model Binding' to automatically find the Book 
     * instance based on the ID in the URL.
     */
    public function show(Book $book)
    {
        return new BooksResource($book);
    }

    /**
     * Update the specified book.
     * We use 'sometimes' in validation so the user only needs to 
     * send the fields they want to change.
     */
    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'author' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'published_year' => 'sometimes|integer|min:1000|max:' . date('Y'),
        ]);

        $book->update($validated);

        return new BooksResource($book);
    }

    /**
     * Remove the specified book from the database.
     * After deletion, we return a 204 No Content response, 
     * which is the standard for successful deletions in APIs.
     */
    public function destroy(Book $book)
    {
        $book->delete();

        return response()->noContent();
    }
}
