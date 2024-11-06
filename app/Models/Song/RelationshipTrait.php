<?php

namespace App\Models\Song;

use App\Models\Author\Author;
use App\Models\PlayList\Playlist;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait RelationshipTrait
{
    /**
     * Get the songs for the author.
     */
    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class, 'author_song');
    }
    public function playlists(): BelongsToMany
    {
        return $this->belongsToMany(Playlist::class);
    }
}
