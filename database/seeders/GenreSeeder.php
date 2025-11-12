<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    public function run()
    {
        $genres = [
            ['name' => 'Rock', 'color' => '#ef4444', 'description' => 'Música rock caracterizada por guitarras eléctricas'],
            ['name' => 'Pop', 'color' => '#3b82f6', 'description' => 'Música popular comercial'],
            ['name' => 'Jazz', 'color' => '#8b5cf6', 'description' => 'Música improvisada con ritmos complejos'],
            ['name' => 'Clásica', 'color' => '#f59e0b', 'description' => 'Música clásica tradicional'],
            ['name' => 'Hip Hop', 'color' => '#10b981', 'description' => 'Rap y música urbana'],
            ['name' => 'Electrónica', 'color' => '#06b6d4', 'description' => 'Música creada con sintetizadores'],
            ['name' => 'Reggaetón', 'color' => '#f97316', 'description' => 'Música urbana latina'],
            ['name' => 'Country', 'color' => '#84cc16', 'description' => 'Música folk estadounidense'],
        ];

        foreach ($genres as $genre) {
            Genre::create($genre);
        }
    }
}