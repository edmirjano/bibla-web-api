<?php

namespace App\Models\Group;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory,RelationshipTrait;
    protected $fillable = [
        'name','book_id'
    ];
}
