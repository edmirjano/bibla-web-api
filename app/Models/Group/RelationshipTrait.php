<?php

namespace App\Models\Group;

use App\Models\Book\Book;
use App\Models\Topic\Topic;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait RelationshipTrait
{
    public function book():BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
    public function topics(): HasMany
    {
        return $this->hasMany(Topic::class);
    }

}
