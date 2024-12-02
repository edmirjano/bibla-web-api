<?php

namespace App\Models\Album;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    use HasFactory, RelationshipTrait;

    protected $fillable = ['title', 'user_id'];



}
