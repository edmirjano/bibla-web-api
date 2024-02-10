<?php

namespace App\Models\Section;

use App\Models\Question\Question;
use App\Models\Response\Response;
use App\Models\Topic\Topic;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait RelationshipTrait
{
    public function topic():BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }

    public function questions():HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function responses():HasMany
    {
        return $this->hasMany(Response::class);
    }
}
