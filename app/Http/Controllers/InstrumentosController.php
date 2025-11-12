<?php

namespace App\Http\Controllers;

use App\Models\Instrumentos;
use Illuminate\Http\Request;

class InstrumentController extends Controller
{
    public function index(Request $request)
    {
        $query = Instrumentos::withCount('songs');
        
        if ($request->has('type') && $request->type) {
            $query->where('type', $request->type);
        }
        
        $instruments = $query->latest()->get();
        return view('instruments.index', compact('instruments'));
    }

    public function create()
    {
        return view('instruments.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:instruments',
            'type' => 'required|string|in:cuerda,viento,percusion,electrico',
            'description' => 'nullable|string'
        ]);

        Instrumentos::create($validated);

        return redirect()->route('instruments.index')->with('success', 'Instrumento creado exitosamente.');
    }

    public function edit(Instrumentos $instrument)
    {
        return view('instruments.edit', compact('instrument'));
    }

    public function update(Request $request, Instrumentos $instrument)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:instruments,name,' . $instrument->id,
            'type' => 'required|string|in:cuerda,viento,percusion,electrico',
            'description' => 'nullable|string'
        ]);

        $instrument->update($validated);

        return redirect()->route('instruments.index')->with('success', 'Instrumento actualizado exitosamente.');
    }

    public function destroy(Instrumentos $instrument)
    {
        $instrument->delete();
        return redirect()->route('instruments.index')->with('success', 'Instrumento eliminado exitosamente.');
    }
}