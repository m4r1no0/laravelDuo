<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CancionesFavoritas extends Model
{
    //
    public function user() {
        return $this->belongsTo(User::class);
    }
    
    public function song() {
        return $this->belongsTo(Song::class);
    }
}
