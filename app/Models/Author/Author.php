<?php

namespace App\Models\Author;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Author extends Model
{
    use HasFactory, RelationshipTrait,SoftDeletes;

    protected $fillable = ['name', 'number_of_songs', 'cover', 'bio'];

}
