<?php

namespace App\Models\Song;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    use HasFactory,RelationshipTrait;

    protected $fillable = ['title', 'author_id', 'mp3link', 'cover', 'views', 'favorites'];

}
