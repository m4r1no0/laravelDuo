<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instrument extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'type'
    ];

    public function songs()
    {
        return $this->belongsToMany(Song::class, 'song_instrument');
    }

    public function getSongsCountAttribute()
    {
        return $this->songs()->count();
    }
}