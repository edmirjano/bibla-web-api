<?php

namespace App\Models\Response;

use App\Models\Section\Section;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait RelationshipTrait
{

    public function section():BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
