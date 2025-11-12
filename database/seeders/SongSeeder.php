<?php

namespace Database\Seeders;

use App\Models\Song;
use App\Models\Album;
use App\Models\Artist;
use App\Models\Genre;
use App\Models\Instrument;
use Illuminate\Database\Seeder;

class SongSeeder extends Seeder
{
    public function run()
    {
        $genres = Genre::all();
        $instruments = Instrument::all();
        $albums = Album::with('artist')->get();

        $songs = [
            [
                'title' => 'Come Together',
                'album_id' => $albums->where('title', 'Abbey Road')->first()->id,
                'artist_id' => $albums->where('title', 'Abbey Road')->first()->artist_id,
                'genre_id' => $genres->where('name', 'Rock')->first()->id,
                'duration' => 259, // 4:19
                'track_number' => 1,
                'lyrics' => 'Here come old flat top...'
            ],
            [
                'title' => 'Billie Jean',
                'album_id' => $albums->where('title', 'Thriller')->first()->id,
                'artist_id' => $albums->where('title', 'Thriller')->first()->artist_id,
                'genre_id' => $genres->where('name', 'Pop')->first()->id,
                'duration' => 294, // 4:54
                'track_number' => 2,
                'lyrics' => 'She was more like a beauty queen...'
            ],
            [
                'title' => 'Bohemian Rhapsody',
                'album_id' => $albums->where('title', 'A Night at the Opera')->first()->id,
                'artist_id' => $albums->where('title', 'A Night at the Opera')->first()->artist_id,
                'genre_id' => $genres->where('name', 'Rock')->first()->id,
                'duration' => 354, // 5:54
                'track_number' => 1,
                'lyrics' => 'Is this the real life? Is this just fantasy?...'
            ],
            [
                'title' => 'Yo Perreo Sola',
                'album_id' => $albums->where('title', 'YHLQMDLG')->first()->id,
                'artist_id' => $albums->where('title', 'YHLQMDLG')->first()->artist_id,
                'genre_id' => $genres->where('name', 'Reggaetón')->first()->id,
                'duration' => 170, // 2:50
                'track_number' => 3,
                'lyrics' => 'Si yo quiero un perreo, yo perreo sola...'
            ],
            [
                'title' => 'Ojos Así',
                'album_id' => $albums->where('title', '¿Dónde Están los Ladrones?')->first()->id,
                'artist_id' => $albums->where('title', '¿Dónde Están los Ladrones?')->first()->artist_id,
                'genre_id' => $genres->where('name', 'Pop')->first()->id,
                'duration' => 235, // 3:55
                'track_number' => 5,
                'lyrics' => 'Tus ojos navegan en mi silencio...'
            ],
        ];

        foreach ($songs as $songData) {
            $song = Song::create($songData);
            
            // Asignar instrumentos aleatorios
            $randomInstruments = $instruments->random(rand(2, 4));
            $song->instruments()->attach($randomInstruments);
        }
    }
}