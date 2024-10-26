<?php

namespace App\Models\Song;

use App\Models\Author\Author;
use App\Models\PlayList\Playlist;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait RelationshipTrait
{
    /**
     * Get the songs for the author.
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }
    public function playlists(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Playlist::class);
    }
}
