<?php

namespace App\Models\Album;


use App\Models\Author\Author;
use App\Models\Song\Song;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;


trait RelationshipTrait
{
    public function songs(): HasMany
    {
        return $this->hasMany(Song::class);
    }
    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class, 'album_author', 'album_id', 'author_id');
    }
}
