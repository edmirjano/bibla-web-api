<?php

namespace App\Models\Song;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Song extends Model
{
    use HasFactory,RelationshipTrait,SoftDeletes;

    protected $fillable = ['title', 'author_id', 'mp3link', 'cover', 'views', 'favorites', 'yt_link', 'spotify_link', 'lyrics'];

}
