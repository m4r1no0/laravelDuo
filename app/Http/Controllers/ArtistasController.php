<?php

namespace App\Http\Controllers;

use App\Models\Artistas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArtistController extends Controller
{
    public function index()
    {
        $artists = Artist::withCount(['songs', 'albums'])->latest()->get();
        return view('artists.index', compact('artists'));
    }

    public function create()
    {
        return view('artists.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'country' => 'nullable|string|max:100',
            'image' => 'nullable|image|max:2048',
            'birth_date' => 'nullable|date'
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('artists', 'public');
        }

        Artistas::create($validated);

        return redirect()->route('artists.index')->with('success', 'Artista creado exitosamente.');
    }

    public function show(Artist $artist)
    {
        $artist->load(['songs.album', 'albums.songs']);
        return view('artists.show', compact('artist'));
    }

    public function edit(Artist $artist)
    {
        return view('artists.edit', compact('artist'));
    }

    public function update(Request $request, Artistas $artist)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'country' => 'nullable|string|max:100',
            'image' => 'nullable|image|max:2048',
            'birth_date' => 'nullable|date'
        ]);

        if ($request->hasFile('image')) {
            // Eliminar imagen anterior
            if ($artist->image) {
                Storage::disk('public')->delete($artist->image);
            }
            $validated['image'] = $request->file('image')->store('artists', 'public');
        }

        $artist->update($validated);

        return redirect()->route('artists.index')->with('success', 'Artista actualizado exitosamente.');
    }

    public function destroy(Artistas $artist)
    {
        if ($artist->image) {
            Storage::disk('public')->delete($artist->image);
        }

        $artist->delete();

        return redirect()->route('artists.index')->with('success', 'Artista eliminado exitosamente.');
    }
}