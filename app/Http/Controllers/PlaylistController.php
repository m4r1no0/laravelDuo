<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use App\Models\Song;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PlaylistController extends Controller
{
    public function index()
    {
        $playlists = Playlist::with('user')
            ->where('user_id', auth()->id())
            ->orWhere('is_public', true)
            ->latest()
            ->get();
            
        return view('playlists.index', compact('playlists'));
    }

    public function create()
    {
        $songs = Song::all();
        return view('playlists.create', compact('songs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_public' => 'boolean',
            'cover_image' => 'nullable|image|max:2048',
            'songs' => 'nullable|array',
            'songs.*' => 'exists:songs,id'
        ]);

        $validated['user_id'] = auth()->id();

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('playlists', 'public');
        }

        $playlist = Playlist::create($validated);

        // Agregar canciones seleccionadas
        if ($request->has('songs')) {
            foreach ($request->songs as $position => $songId) {
                $playlist->songs()->attach($songId, ['position' => $position + 1]);
            }
            $playlist->update(['songs_count' => count($request->songs)]);
        }

        return redirect()->route('playlists.index')->with('success', 'Playlist creada exitosamente.');
    }

    public function show(Playlist $playlist)
    {
        // Verificar si el usuario puede ver la playlist
        if (!$playlist->is_public && $playlist->user_id !== auth()->id()) {
            abort(403);
        }

        $playlist->load(['songs.artist', 'songs.album', 'user']);
        return view('playlists.show', compact('playlist'));
    }

    public function edit(Playlist $playlist)
    {
        // Verificar si el usuario es el dueño
        if ($playlist->user_id !== auth()->id()) {
            abort(403);
        }

        $songs = Song::all();
        $playlist->load('songs');
        
        return view('playlists.edit', compact('playlist', 'songs'));
    }

    public function update(Request $request, Playlist $playlist)
    {
        // Verificar si el usuario es el dueño
        if ($playlist->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_public' => 'boolean',
            'cover_image' => 'nullable|image|max:2048',
            'songs' => 'nullable|array',
            'songs.*' => 'exists:songs,id'
        ]);

        if ($request->hasFile('cover_image')) {
            // Eliminar imagen anterior
            if ($playlist->cover_image) {
                Storage::disk('public')->delete($playlist->cover_image);
            }
            $validated['cover_image'] = $request->file('cover_image')->store('playlists', 'public');
        }

        $playlist->update($validated);

        // Sincronizar canciones
        if ($request->has('songs')) {
            $syncData = [];
            foreach ($request->songs as $position => $songId) {
                $syncData[$songId] = ['position' => $position + 1];
            }
            $playlist->songs()->sync($syncData);
            $playlist->update(['songs_count' => count($request->songs)]);
        }

        return redirect()->route('playlists.index')->with('success', 'Playlist actualizada exitosamente.');
    }

    public function destroy(Playlist $playlist)
    {
        // Verificar si el usuario es el dueño
        if ($playlist->user_id !== auth()->id()) {
            abort(403);
        }

        if ($playlist->cover_image) {
            Storage::disk('public')->delete($playlist->cover_image);
        }

        $playlist->delete();

        return redirect()->route('playlists.index')->with('success', 'Playlist eliminada exitosamente.');
    }

    public function addSong(Request $request, Playlist $playlist)
    {
        $request->validate([
            'song_id' => 'required|exists:songs,id'
        ]);

        $playlist->addSong($request->song_id);

        return redirect()->back()->with('success', 'Canción agregada a la playlist.');
    }

    public function removeSong(Playlist $playlist, Song $song)
    {
        $playlist->removeSong($song->id);

        return redirect()->back()->with('success', 'Canción removida de la playlist.');
    }
}