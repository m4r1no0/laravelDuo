<?php

namespace Database\Seeders;

use App\Models\Instrument;
use Illuminate\Database\Seeder;

class InstrumentSeeder extends Seeder
{
    public function run()
    {
        $instruments = [
            // Cuerda
            ['name' => 'Guitarra Eléctrica', 'type' => 'cuerda', 'description' => 'Guitarra que requiere amplificación'],
            ['name' => 'Guitarra Acústica', 'type' => 'cuerda', 'description' => 'Guitarra de caja resonante'],
            ['name' => 'Bajo', 'type' => 'cuerda', 'description' => 'Instrumento de graves'],
            ['name' => 'Violín', 'type' => 'cuerda', 'description' => 'Instrumento de cuerda frotada'],
            ['name' => 'Piano', 'type' => 'cuerda', 'description' => 'Instrumento de teclado y cuerdas percutidas'],
            
            // Viento
            ['name' => 'Saxofón', 'type' => 'viento', 'description' => 'Instrumento de viento-madera'],
            ['name' => 'Trompeta', 'type' => 'viento', 'description' => 'Instrumento de viento-metal'],
            ['name' => 'Flauta', 'type' => 'viento', 'description' => 'Instrumento de viento-madera'],
            
            // Percusión
            ['name' => 'Batería', 'type' => 'percusion', 'description' => 'Set de instrumentos de percusión'],
            ['name' => 'Congas', 'type' => 'percusion', 'description' => 'Tumbadoras latinas'],
            ['name' => 'Bongós', 'type' => 'percusion', 'description' => 'Percusión cubana'],
            
            // Eléctricos
            ['name' => 'Sintetizador', 'type' => 'electrico', 'description' => 'Generador de sonidos electrónicos'],
            ['name' => 'Teclado', 'type' => 'electrico', 'description' => 'Piano electrónico'],
        ];

        foreach ($instruments as $instrument) {
            Instrument::create($instrument);
        }
    }
}