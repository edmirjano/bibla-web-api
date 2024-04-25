<?php

namespace App\Models\Book;

use App\Models\Category\Category;
use App\Models\Classroom\Classroom;
use App\Models\Group\Group;
use App\Models\Topic\Topic;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

trait RelationshipTrait
{
    public function category():BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function classroom(): HasOne
    {
        return $this->hasOne(Classroom::class);
    }
    public function groups(): HasMany
    {
        return $this->hasMany(Group::class);
    }
    public function topics()
    {
        return $this->hasManyThrough(Topic::class, Group::class);
    }
}
