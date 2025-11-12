<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'album_id',
        'artist_id',
        'genre_id',
        'duration',
        'track_number',
        'audio_file',
        'lyrics'
    ];

    // Relaciones
    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }

    public function album()
    {
        return $this->belongsTo(Album::class);
    }

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    public function playlists()
    {
        return $this->belongsToMany(Playlist::class, 'playlist_song')
                    ->withPivot('position')
                    ->withTimestamps();
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function instruments()
    {
        return $this->belongsToMany(Instrument::class, 'song_instrument');
    }

    // Accesores
    public function getDurationFormattedAttribute()
    {
        $minutes = floor($this->duration / 60);
        $seconds = $this->duration % 60;
        return sprintf('%d:%02d', $minutes, $seconds);
    }

    public function getIsFavoriteAttribute()
    {
        if (auth()->check()) {
            return $this->favorites()->where('user_id', auth()->id())->exists();
        }
        return false;
    }

    // Scopes
    public function scopePopular($query)
    {
        return $query->orderBy('plays_count', 'desc');
    }

    public function scopeByGenre($query, $genreId)
    {
        return $query->where('genre_id', $genreId);
    }
}