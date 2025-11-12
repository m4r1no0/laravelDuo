<?php

namespace Database\Seeders;

use App\Models\Artist;
use Illuminate\Database\Seeder;

class ArtistSeeder extends Seeder
{
    public function run()
    {
        $artists = [
            [
                'name' => 'The Beatles',
                'country' => 'Reino Unido',
                'bio' => 'Banda de rock británica formada en Liverpool durante los años 1960.',
                'birth_date' => '1960-01-01'
            ],
            [
                'name' => 'Michael Jackson',
                'country' => 'USA',
                'bio' => 'Conocido como el Rey del Pop, fue un cantante, compositor y bailarín.',
                'birth_date' => '1958-08-29'
            ],
            [
                'name' => 'Queen',
                'country' => 'Reino Unido',
                'bio' => 'Banda británica de rock formada en 1970 en Londres.',
                'birth_date' => '1970-01-01'
            ],
            [
                'name' => 'Bad Bunny',
                'country' => 'Puerto Rico',
                'bio' => 'Cantante y compositor de reggaetón y trap latino.',
                'birth_date' => '1994-03-10'
            ],
            [
                'name' => 'Shakira',
                'country' => 'Colombia',
                'bio' => 'Cantante, compositora, bailarina y productora discográfica.',
                'birth_date' => '1977-02-02'
            ],
        ];

        foreach ($artists as $artist) {
            Artist::create($artist);
        }
    }
}