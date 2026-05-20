<?php

namespace App\Http\Controllers;

use App\Models\Game;

class WebGameController extends Controller
{
    public function index()
    {
        $games = Game::with('genres')->orderBy('title')->get();

        return view('games.index', compact('games'));
    }
}