<?php

namespace App\Models\Author;

use App\Models\Category\Category;
use App\Models\Classroom\Classroom;
use App\Models\Group\Group;
use App\Models\Song\Song;
use App\Models\Topic\Topic;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

trait RelationshipTrait
{
    /**
     * Get the songs for the author.
     */
    public function songs(): BelongsToMany
    {
        return $this->belongstoMany(Song::class, 'author_song');
    }
}
