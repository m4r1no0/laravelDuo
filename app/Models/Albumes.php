<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'artist_id',
        'release_year',
        'cover_image',
        'description'
    ];

    // Relaciones
    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }

    public function songs()
    {
        return $this->hasMany(Song::class);
    }

    // Accesores
    public function getDurationAttribute()
    {
        return $this->songs()->sum('duration');
    }

    public function getFormattedDurationAttribute()
    {
        $totalSeconds = $this->duration;
        $hours = floor($totalSeconds / 3600);
        $minutes = floor(($totalSeconds % 3600) / 60);
        $seconds = $totalSeconds % 60;

        if ($hours > 0) {
            return sprintf('%d:%02d:%02d', $hours, $minutes, $seconds);
        }

        return sprintf('%d:%02d', $minutes, $seconds);
    }

    // Eventos
    protected static function booted()
    {
        static::saving(function ($album) {
            $album->total_tracks = $album->songs()->count();
        });
    }
}