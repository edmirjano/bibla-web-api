<?php

namespace App\Models\Question;

use App\Models\Section\Section;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait RelationshipTrait
{
    public function section():BelongsTo
    {
        return $this->belongsTo(Section::class);
    }
}
