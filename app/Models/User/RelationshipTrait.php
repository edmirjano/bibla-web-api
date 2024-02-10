<?php

namespace App\Models\User;

use App\Models\Classroom\Classroom;
use App\Models\ClassRoomRequest\ClassroomRequest;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait RelationshipTrait
{
    public function classrooms(): BelongsToMany
    {
        return $this->belongsToMany(Classroom::class);
    }
    public function sentRequests(): HasMany
    {
        return $this->hasMany(ClassroomRequest::class, 'sender_id');
    }

    public function receivedRequests(): HasMany
    {
        return $this->hasMany(ClassroomRequest::class, 'recipient_id');
    }
}
