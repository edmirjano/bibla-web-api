<?php

namespace App\Models\Category;

use App\Models\Book\Book;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait RelationshipTrait
{
    public function books():HasMany
    {
        return $this->hasMany(Book::class);
    }
}
