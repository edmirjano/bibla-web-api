<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'author_id', 'mp3link', 'cover', 'views', 'favorites'];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function playlists()
    {
        return $this->belongsToMany(Playlist::class);
    }
}
