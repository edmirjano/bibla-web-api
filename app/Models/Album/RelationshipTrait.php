<?php

namespace App\Models\Album;


use App\Models\Song\Song;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;


trait RelationshipTrait
{
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
    public function songs(): HasMany
    {
        return $this->hasMany(Song::class);
    }
}
