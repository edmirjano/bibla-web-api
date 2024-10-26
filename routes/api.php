<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PlaylistController;
use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\Api\SongController;
use App\Http\Controllers\Api\ClassRoomController;

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
Route::get('/songs', [SongController::class, 'getAllSongs']);
Route::get('/songs/{song}', [SongController::class, 'getSong']);
Route::post('/addSongViewer/{song}', [SongController::class, 'addViewer']);
Route::get('/playlists', [PlaylistController::class, 'getPlaylists']);
Route::get('/authors', [AuthorController::class, 'getAuthors']);
Route::get('/playlists/{playlist}', [PlaylistController::class, 'getPlaylist']);
Route::get('/authors/{author}', [AuthorController::class, 'getAuthor']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/addSongFavorite/{song}', [SongController::class, 'addFavorite']);
    Route::post('/removeSongFavorite/{song}', [SongController::class, 'removeFavorite']);

    Route::get('/authors', [AuthorController::class, 'getAuthors']);
    Route::get('/authors/{author}', [AuthorController::class, 'getAuthor']);
    Route::put('/authors/{author}', [AuthorController::class, 'updateAuthor']);
    Route::delete('/authors/{author}', [AuthorController::class, 'deleteAuthor']);
    // Playlist-related routes
    Route::get('/playlists/{playlist}', [PlaylistController::class, 'getPlaylist']);
    Route::put('/playlists/{playlist}', [PlaylistController::class, 'updatePlaylist']);
    Route::delete('/playlists/{playlist}', [PlaylistController::class, 'deletePlaylist']);
    Route::post('/updateSongs/{playlist}', [PlaylistController::class, 'updateSongs']);
    Route::post('/playlists/{playlist}/addSong', [PlaylistController::class, 'addSongToPlaylist']);
    Route::post('/playlists/{playlist}/removeSong', [PlaylistController::class, 'removeSongFromPlaylist']);


    // Classrooms
    Route::get('/classrooms', [ClassroomController::class, 'getAllClassrooms']);
    Route::get('/classrooms/{classroom}', [ClassroomController::class, 'getClassroom']);
    Route::post('/classrooms', [ClassroomController::class, 'store']);
    Route::put('/classrooms/{classroom}', [ClassroomController::class, 'update']);
    Route::delete('/classrooms/{classroom}', [ClassroomController::class, 'destroy']);
    Route::get('/classrooms/user/{user}/', [ClassroomController::class, 'getClassroomsByUser']);
    Route::post('/classrooms/{classroom}/addUser/{userId}', [ClassroomController::class, 'addUser']);
    Route::post('/classrooms/{classroom}/removeUser/{userId}', [ClassroomController::class, 'removeUser']);

});

