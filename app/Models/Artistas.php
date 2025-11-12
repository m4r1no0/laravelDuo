<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'bio',
        'country',
        'image',
        'birth_date'
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    // Relaciones
    public function songs()
    {
        return $this->hasMany(Song::class);
    }

    public function albums()
    {
        return $this->hasMany(Album::class);
    }

    // Accesores
    public function getTotalSongsAttribute()
    {
        return $this->songs()->count();
    }

    public function getTotalAlbumsAttribute()
    {
        return $this->albums()->count();
    }
}