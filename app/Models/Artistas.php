<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    public function songs() {
        return $this->hasMany(Song::class);
    }
    
    public function albums() {
        return $this->hasMany(Album::class);
    }
}
