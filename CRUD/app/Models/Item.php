<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Category;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'product',
        'category',
        'quantity',
        'price',
        'category_id',
    ];

    public function categoryRel()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
