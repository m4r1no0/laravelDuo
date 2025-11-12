<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Instrumentos extends Model
{
    //
     public function songs() {
        return $this->belongsToMany(Song::class, 'song_instrument');
    }
}
