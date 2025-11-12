<?php

namespace App\Http\Controllers;

use App\Models\Genero;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function index()
    {
        $genres = Generos::withCount('songs')->latest()->get();
        return view('genres.index', compact('genres'));
    }

    public function create()
    {
        return view('genres.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:genres',
            'description' => 'nullable|string',
            'color' => 'nullable|string|max:7'
        ]);

        Generos::create($validated);

        return redirect()->route('genres.index')->with('success', 'Género creado exitosamente.');
    }

    public function edit(Generos $genre)
    {
        return view('genres.edit', compact('genre'));
    }

    public function update(Request $request, Generos $genre)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:genres,name,' . $genre->id,
            'description' => 'nullable|string',
            'color' => 'nullable|string|max:7'
        ]);

        $genre->update($validated);

        return redirect()->route('genres.index')->with('success', 'Género actualizado exitosamente.');
    }

    public function destroy(Generos $genre)
    {
        $genre->delete();
        return redirect()->route('genres.index')->with('success', 'Género eliminado exitosamente.');
    }
}