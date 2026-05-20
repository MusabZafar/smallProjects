<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BooksResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    /**
     * Transform the resource into an array.
     * This defines the exact JSON structure that our API returns.
     * We can change field names or format dates here without touching the database.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'author' => $this->author,
            'description' => $this->description,
            'published_year' => $this->published_year,
            'created_at' => $this->created_at?->toDateTimeString(), // Human-readable date
            'updated_at' => $this->updated_at?->toDateTimeString(),
        ];
    }
}
