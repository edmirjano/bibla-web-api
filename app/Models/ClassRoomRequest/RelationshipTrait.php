<?php

namespace App\Models\ClassRoomRequest;

use App\Models\Classroom\Classroom;
use App\Models\Section\Section;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait RelationshipTrait
{

    public function sender():BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function recipient():BelongsTo
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }

    public function classroom():BelongsTo
    {
        return $this->belongsTo(Classroom::class);
    }

}
