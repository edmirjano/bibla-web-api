<?php

namespace App\Models\Song;

use App\Models\Author\Author;
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
}
