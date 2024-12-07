<?php

namespace App\Models\PlayList;

use App\Models\Song\Song;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Playlist extends Model
{
    use HasFactory,RelationshipTrait, SoftDeletes;

    protected $fillable = ['title', 'user_id','is_from_admin'];



}
