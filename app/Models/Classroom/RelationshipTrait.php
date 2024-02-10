<?php

namespace App\Models\Classroom;

use App\Models\Book\Book;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait RelationshipTrait
{
    public function book():BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function users():BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
