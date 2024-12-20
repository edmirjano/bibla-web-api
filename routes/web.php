<?php

use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ClassRoomController;
use App\Http\Controllers\Admin\GroupController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\TopicController;
use App\Http\Controllers\ProfileController;
use \App\Http\Controllers\Admin\QuestionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\AuthorController;
use App\Http\Controllers\Admin\PlaylistController;
use App\Http\Controllers\Admin\SongController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'create']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('/book', BookController::class);
    Route::resource('/classroom', ClassRoomController::class);
    Route::resource('/category', CategoryController::class);
    Route::resource('/group', GroupController::class);
    Route::resource('/topic', TopicController::class);
    Route::get('/book-topic/{bookId}', [TopicController::class, 'getByBook'])->name('topic.byBook');
    Route::resource('/section', SectionController::class);
    Route::resource('/question', QuestionController::class);
    Route::get('/classrooms/{classroomId}/remove-user/{userId}', [ClassRoomController::class, 'removeUser'])
        ->name('classroom.removeUser');
    Route::post('classroom/{classroomId}/add-user/{userId}', [ClassRoomController::class, 'addUser'])->name('classroom.addUser');
    Route::resource('/song', SongController::class);
    Route::resource('/author', AuthorController::class);
    Route::resource('/playlist', PlaylistController::class);

    Route::get('playlists/{playlist}/songs', [PlaylistController::class, 'manageSongs'])->name('playlist.songs.manage');
    Route::put('playlists/{playlist}/songs', [PlaylistController::class, 'updateSongs'])->name('playlist.songs.update');

    Route::resource('/users', UsersController::class)->except(['show']);
    // Route::post('/group',[BookController::class,'storeGroup'])->name('group.store');
});

require __DIR__ . '/auth.php';
