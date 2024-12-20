<?php

namespace App\Models\Classroom;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    use HasFactory,RelationshipTrait;
    protected $fillable = [
        'name',
        'description',
        'book_id'
    ];
}
