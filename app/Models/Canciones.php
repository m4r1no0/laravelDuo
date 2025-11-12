<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Canciones extends Model
{
    public function artist() {
        return $this->belongsTo(Artist::class);
    }
    
    public function album() {
        return $this->belongsTo(Album::class);
    }
    
    public function genre() {
        return $this->belongsTo(Genre::class);
    }
    
    public function playlists() {
        return $this->belongsToMany(Playlist::class, 'playlist_song')
                    ->withPivot('position')
                    ->withTimestamps();
    }
    
    public function favorites() {
        return $this->hasMany(Favorite::class);
    }
    
    public function instruments() {
        return $this->belongsToMany(Instrument::class, 'song_instrument');
    }
    
    // Accessor para duración formateada
    public function getDurationFormattedAttribute() {
        $minutes = floor($this->duration / 60);
        $seconds = $this->duration % 60;
        return sprintf('%d:%02d', $minutes, $seconds);
    }
}