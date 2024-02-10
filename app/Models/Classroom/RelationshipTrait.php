<?php

namespace App\Models\Classroom;

use App\Models\Book\Book;
use App\Models\ClassRoomRequest\ClassroomRequest;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
    public function requestsSent(): HasMany
    {
        return $this->hasMany(ClassroomRequest::class, 'classroom_id');
    }
}
