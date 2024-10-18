<?php

namespace App\Models\PlayList;


use App\Models\User\User;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


trait RelationshipTrait
{
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'playlist_user')->withTimestamps();
    }
}
