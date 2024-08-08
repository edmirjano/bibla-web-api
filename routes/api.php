<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    $user = $request->user();

    return response()->json(['user' => $user], 200);
});
Route::post('/login', function (Request $request) {
    \Illuminate\Support\Facades\Log::info('indf',[$request->all()]);

    $credentials = $request->only('email', 'password');
    if (auth()->attempt($credentials)) {
        $token = auth()->user()->createToken('')->plainTextToken;

        return response()->json(['token' => $token]);
    }

    return response()->json(['error' => 'Invalid credentials'], 401);
});


Route::get('/getSongs', [\App\Http\Controllers\Admin\SongController::class, 'getSongs']);
Route::get('/getAuthors', [\App\Http\Controllers\Admin\AuthorController::class, 'getAuthors']);
Route::get('/getPlaylists', [\App\Http\Controllers\Admin\PlaylistController::class, 'getPlaylists']);
Route::post('/addSongViewer/{id}', [\App\Http\Controllers\Admin\SongController::class, 'addViewer']);
Route::post('/addSongFavorite/{id}', [\App\Http\Controllers\Admin\SongController::class, 'addFavorite']);
Route::post('/removeSongFavorite/{id}', [\App\Http\Controllers\Admin\SongController::class, 'removeFavorite']);
// Route::post('/createPlaylist', [\App\Http\Controllers\Admin\PlaylistController::class, 'store']);
Route::post('/addSongToPlaylist', [\App\Http\Controllers\Admin\PlaylistController::class, 'addSong']);
Route::post('/removeSongFromPlaylist', [\App\Http\Controllers\Admin\PlaylistController::class, 'removeSong']);

Route::post('/createPlaylist', [\App\Http\Controllers\Admin\PlaylistController::class, 'createPlaylist']);
Route::post('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'register']);
