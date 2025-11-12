<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\{
    ArtistasController,
    AlbumesController,
    CancionesController,
    GenerosController,
    PlaylistController,
    InstrumentsController,
    CancionesFavoritasController
};
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Artistas
    Route::resource('artistas', ArtistasController::class);

    // Géneros
    Route::resource('generos', GenerosController::class);

    // Álbumes
    Route::resource('albumes', AlbumesController::class);

    // Canciones
    Route::resource('canciones', CancionesController::class);
    Route::post('/canciones/{cancion}/play', [CancionesController::class, 'incrementarReproducciones'])->name('canciones.play');
    Route::post('/canciones/{cancion}/toggle-favorite', [CancionesController::class, 'toggleFavorito'])->name('canciones.toggle-favorite');

    // Playlists
    Route::resource('playlists', PlaylistController::class);
    Route::post('/playlists/{playlist}/add-song', [PlaylistController::class, 'agregarCancion'])->name('playlists.add-song');
    Route::delete('/playlists/{playlist}/remove-song/{cancion}', [PlaylistController::class, 'removerCancion'])->name('playlists.remove-song');

    // Instrumentos
    Route::resource('instruments', InstrumentsController::class);

    // Favoritos
    Route::get('/favoritos', [CancionesFavoritasController::class, 'index'])->name('favorites.index');
});

require __DIR__.'/auth.php';