<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BooksController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Public Routes: Anyone can access these (to sign up or sign in)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected Routes: Requires a valid Sanctum 'Bearer Token' in the header
Route::middleware('auth:sanctum')->group(function () {
    
    // apiResource generates: GET (index), POST (store), GET (show), PUT (update), DELETE (destroy)
    Route::apiResource('books', BooksController::class);
    
    Route::post('/logout', [AuthController::class, 'logout']);
});
