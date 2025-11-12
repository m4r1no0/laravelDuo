<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = Favorite::with('song.artist')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();
            
        return view('favorites.index', compact('favorites'));
    }
}