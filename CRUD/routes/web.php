<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemsController;

Route::get('/', function () {
    return redirect()->route('items.index');
});

Route::get('/items/lowstock/{threshold}', [ItemsController::class, 'lowStock'])
    ->name('items.lowstock');

Route::resource('/items', ItemsController::class);
