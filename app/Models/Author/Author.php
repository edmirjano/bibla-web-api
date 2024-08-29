<?php

namespace App\Models\Author;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory ,RelationshipTrait;

    protected $fillable = ['name', 'number_of_songs', 'cover'];

}
