<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Playlist extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'number_of_songs', 'user_id'];

    public function songs()
    {
        return $this->belongsToMany(Song::class);
    }

    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }
}
