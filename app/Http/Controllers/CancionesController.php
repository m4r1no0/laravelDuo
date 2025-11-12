<?php

namespace App\Http\Controllers;

use App\Models\Canciones;
use App\Models\Albumes;
use App\Models\Artistas;
use App\Models\Generos;
use App\Models\Instrumentos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SongController extends Controller
{
    public function index()
    {
        $songs = Canciones::with(['artist', 'album', 'genre'])->latest()->get();
        return view('songs.index', compact('songs'));
    }

    public function create()
    {
        $artists = Artistas::all();
        $albums = Albumes::all();
        $genres = Generos::all();
        $instruments = Instrumentos::all();
        
        return view('songs.create', compact('artists', 'albums', 'genres', 'instruments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'album_id' => 'required|exists:albums,id',
            'artist_id' => 'required|exists:artists,id',
            'genre_id' => 'required|exists:genres,id',
            'duration' => 'required|integer|min:1',
            'track_number' => 'required|integer|min:1',
            'audio_file' => 'nullable|file|mimes:mp3,wav,ogg|max:10240', // 10MB
            'lyrics' => 'nullable|string',
            'instruments' => 'nullable|array',
            'instruments.*' => 'exists:instruments,id'
        ]);

        if ($request->hasFile('audio_file')) {
            $validated['audio_file'] = $request->file('audio_file')->store('songs', 'public');
        }

        $song = Canciones::create($validated);

        // Sincronizar instrumentos
        if ($request->has('instruments')) {
            $song->instruments()->sync($request->instruments);
        }

        return redirect()->route('songs.index')->with('success', 'Canción creada exitosamente.');
    }

    public function show(Canciones $song)
    {
        $song->load(['artist', 'album', 'genre', 'instruments', 'playlists']);
        return view('songs.show', compact('song'));
    }

    public function edit(Canciones $song)
    {
        $artists = Artistas::all();
        $albums = Albumes::all();
        $genres = Generos::all();
        $instruments = Instrumentos::all();
        
        return view('songs.edit', compact('song', 'artists', 'albums', 'genres', 'instruments'));
    }

    public function update(Request $request, Canciones $song)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'album_id' => 'required|exists:albums,id',
            'artist_id' => 'required|exists:artists,id',
            'genre_id' => 'required|exists:genres,id',
            'duration' => 'required|integer|min:1',
            'track_number' => 'required|integer|min:1',
            'audio_file' => 'nullable|file|mimes:mp3,wav,ogg|max:10240',
            'lyrics' => 'nullable|string',
            'instruments' => 'nullable|array',
            'instruments.*' => 'exists:instruments,id'
        ]);

        if ($request->hasFile('audio_file')) {
            // Eliminar archivo anterior
            if ($song->audio_file) {
                Storage::disk('public')->delete($song->audio_file);
            }
            $validated['audio_file'] = $request->file('audio_file')->store('songs', 'public');
        }

        $song->update($validated);

        // Sincronizar instrumentos
        $song->instruments()->sync($request->instruments ?? []);

        return redirect()->route('songs.index')->with('success', 'Canción actualizada exitosamente.');
    }

    public function destroy(Canciones $song)
    {
        if ($song->audio_file) {
            Storage::disk('public')->delete($song->audio_file);
        }

        $song->delete();

        return redirect()->route('songs.index')->with('success', 'Canción eliminada exitosamente.');
    }

    public function incrementPlays(Canciones $song)
    {
        $song->increment('plays_count');
        return response()->json(['plays_count' => $song->plays_count]);
    }

    public function toggleFavorite(Canciones $song)
    {
        $user = auth()->user();
        
        if ($song->is_favorite) {
            $song->favorites()->where('user_id', $user->id)->delete();
            $message = 'Canción removida de favoritos';
        } else {
            $song->favorites()->create(['user_id' => $user->id]);
            $message = 'Canción agregada a favoritos';
        }

        return response()->json([
            'is_favorite' => !$song->is_favorite,
            'message' => $message
        ]);
    }
}