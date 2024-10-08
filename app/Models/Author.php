<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'number_of_songs', 'cover'];

    public function songs()
    {
        return $this->hasMany(Song::class);
    }
}
