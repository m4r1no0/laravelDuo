<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
        'description',
        'is_public',
        'cover_image'
    ];

    protected $casts = [
        'is_public' => 'boolean',
    ];

    // Relaciones
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function songs()
    {
        return $this->belongsToMany(Song::class, 'playlist_song')
                    ->withPivot('position')
                    ->orderBy('position')
                    ->withTimestamps();
    }

    // Accesores
    public function getTotalDurationAttribute()
    {
        return $this->songs->sum('duration');
    }

    public function getFormattedDurationAttribute()
    {
        $totalSeconds = $this->total_duration;
        $hours = floor($totalSeconds / 3600);
        $minutes = floor(($totalSeconds % 3600) / 60);

        if ($hours > 0) {
            return sprintf('%d hr %d min', $hours, $minutes);
        }

        return sprintf('%d min', $minutes);
    }

    // Métodos
    public function addSong($songId, $position = null)
    {
        $maxPosition = $this->songs()->max('position') ?? 0;
        $position = $position ?? $maxPosition + 1;

        $this->songs()->attach($songId, ['position' => $position]);
        $this->update(['songs_count' => $this->songs()->count()]);
    }

    public function removeSong($songId)
    {
        $this->songs()->detach($songId);
        $this->update(['songs_count' => $this->songs()->count()]);
    }
}