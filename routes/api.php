<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/songs', [\App\Http\Controllers\Admin\SongController::class, 'apiGetAllSongs']);
    Route::get('/getSongs', [\App\Http\Controllers\Admin\SongController::class, 'getSongs']);
    Route::get('/getAuthors', [\App\Http\Controllers\Admin\AuthorController::class, 'getAuthors']);
    Route::get('/getPlaylists', [\App\Http\Controllers\Admin\PlaylistController::class, 'getPlaylists']);
    Route::post('/addSongViewer/{id}', [\App\Http\Controllers\Admin\SongController::class, 'addViewer']);
    Route::post('/addSongFavorite/{id}', [\App\Http\Controllers\Admin\SongController::class, 'addFavorite']);
    Route::post('/removeSongFavorite/{id}', [\App\Http\Controllers\Admin\SongController::class, 'removeFavorite']);
    Route::post('/addSongToPlaylist', [\App\Http\Controllers\Admin\PlaylistController::class, 'addSong']);
    Route::post('/removeSongFromPlaylist', [\App\Http\Controllers\Admin\PlaylistController::class, 'removeSong']);
    Route::post('/createPlaylist', [\App\Http\Controllers\Api\PlaylistController::class, 'store']);
});

