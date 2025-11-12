<?php

namespace Database\Seeders;

use App\Models\Album;
use App\Models\Artist;
use Illuminate\Database\Seeder;

class AlbumSeeder extends Seeder
{
    public function run()
    {
        $artists = Artist::all();

        $albums = [
            [
                'title' => 'Abbey Road',
                'artist_id' => $artists->where('name', 'The Beatles')->first()->id,
                'release_year' => 1969,
                'description' => 'Undécimo álbum de estudio de la banda británica The Beatles.'
            ],
            [
                'title' => 'Thriller',
                'artist_id' => $artists->where('name', 'Michael Jackson')->first()->id,
                'release_year' => 1982,
                'description' => 'Sexto álbum de estudio del cantante estadounidense Michael Jackson.'
            ],
            [
                'title' => 'A Night at the Opera',
                'artist_id' => $artists->where('name', 'Queen')->first()->id,
                'release_year' => 1975,
                'description' => 'Cuarto álbum de estudio de la banda británica Queen.'
            ],
            [
                'title' => 'YHLQMDLG',
                'artist_id' => $artists->where('name', 'Bad Bunny')->first()->id,
                'release_year' => 2020,
                'description' => 'Segundo álbum de estudio del cantante puertorriqueño Bad Bunny.'
            ],
            [
                'title' => '¿Dónde Están los Ladrones?',
                'artist_id' => $artists->where('name', 'Shakira')->first()->id,
                'release_year' => 1998,
                'description' => 'Cuarto álbum de estudio de la cantante colombiana Shakira.'
            ],
        ];

        foreach ($albums as $album) {
            Album::create($album);
        }
    }
}