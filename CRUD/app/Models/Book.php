<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    /** @use HasFactory<\Database\Factories\BookFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * This allows us to use Book::create($data) securely.
     */
    protected $fillable = [
        'title',
        'author',
        'description',
        'published_year',
    ];

    /**
     * The attributes that should be cast.
     * We cast published_year to integer to ensure consistency in the API.
     */
    protected $casts = [
        'published_year' => 'integer',
    ];
}
