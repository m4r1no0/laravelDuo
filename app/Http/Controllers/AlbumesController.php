<?php

namespace App\Http\Controllers;

use App\Models\Albumes;
use App\Models\Artistas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AlbumController extends Controller
{
    public function index()
    {
        $albums = Albumes::with(['artist'])->latest()->get();
        return view('albums.index', compact('albums'));
    }

    public function create()
    {
        $artists = Artistas::all();
        return view('albums.create', compact('artists'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'artist_id' => 'required|exists:artists,id',
            'release_year' => 'required|integer|min:1900|max:' . date('Y'),
            'cover_image' => 'nullable|image|max:2048',
            'description' => 'nullable|string'
        ]);

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('albums', 'public');
        }

        Album::create($validated);

        return redirect()->route('albums.index')->with('success', 'Álbum creado exitosamente.');
    }

    public function show(Albumes $album)
    {
        $album->load(['artist', 'songs' => function($query) {
            $query->orderBy('track_number');
        }]);
        return view('albums.show', compact('album'));
    }

    public function edit(Album $album)
    {
        $artists = Artistas::all();
        return view('albums.edit', compact('album', 'artists'));
    }

    public function update(Request $request, Albumes $album)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'artist_id' => 'required|exists:artists,id',
            'release_year' => 'required|integer|min:1900|max:' . date('Y'),
            'cover_image' => 'nullable|image|max:2048',
            'description' => 'nullable|string'
        ]);

        if ($request->hasFile('cover_image')) {
            if ($album->cover_image) {
                Storage::disk('public')->delete($album->cover_image);
            }
            $validated['cover_image'] = $request->file('cover_image')->store('albums', 'public');
        }

        $album->update($validated);

        return redirect()->route('albums.index')->with('success', 'Álbum actualizado exitosamente.');
    }

    public function destroy(Albumes $album)
    {
        if ($album->cover_image) {
            Storage::disk('public')->delete($album->cover_image);
        }

        $album->delete();

        return redirect()->route('albums.index')->with('success', 'Álbum eliminado exitosamente.');
    }
}