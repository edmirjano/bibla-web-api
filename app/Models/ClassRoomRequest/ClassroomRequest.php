<?php

namespace App\Models\ClassRoomRequest;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassroomRequest extends Model
{
    use HasFactory,RelationshipTrait;
    protected $fillable = [
        'sender_id', 'recipient_id', 'classroom_id', 'status'
    ];
}
