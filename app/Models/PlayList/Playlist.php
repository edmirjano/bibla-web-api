<?php

namespace App\Models\PlayList;

use App\Models\Song\Song;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    use HasFactory,RelationshipTrait;

    protected $fillable = ['title', 'number_of_songs', 'user_id'];

    public function songs()
    {
        return $this->belongsToMany(Song::class);
    }

}
