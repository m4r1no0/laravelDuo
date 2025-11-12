<?php

namespace App\Http\Controllers;

use App\Models\CancionesFavoritas;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = CancionesFavoritas::with('song.artist')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();
            
        return view('favorites.index', compact('favorites'));
    }
}