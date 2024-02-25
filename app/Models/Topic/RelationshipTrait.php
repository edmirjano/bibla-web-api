<?php

namespace App\Models\Topic;

use App\Models\Book\Book;
use App\Models\Group\Group;
use App\Models\Section\Section;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait RelationshipTrait
{
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function sections(): HasMany
    {
        return $this->hasMany(Section::class);
    }
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

}
