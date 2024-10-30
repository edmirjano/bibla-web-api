<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSongsTable extends Migration
{
    public function up()
    {
        Schema::create('songs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('author_id')->constrained();
            $table->string('mp3link')->nullable();
            $table->string('cover')->nullable();
            $table->integer('views')->default(0);
            $table->integer('favorites')->default(0);
            $table->string('yt_link')->nullable();
            $table->string('spotify_link')->nullable();
            $table->longText('lyrics')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('songs');
    }
}
