<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('songs', function (Blueprint $table) {
            $table->string('yt_link')->nullable();
            $table->string('spotify_link')->nullable();
            $table->longText('lyrics')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('songs', function (Blueprint $table) {
            $table->dropColumn('yt_link');
            $table->dropColumn('spotify_link');
            $table->dropColumn('lyrics');
        });
    }
};
