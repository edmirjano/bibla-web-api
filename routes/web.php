<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ClassRoomController;
use App\Http\Controllers\Admin\BookController;
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

Route::get('/',[\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'create']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('/classroom',ClassRoomController::class);
    Route::resource('/categories',\App\Http\Controllers\Admin\CategoryController::class);
    Route::get('/classrooms/{classroomId}/remove-user/{userId}', [ClassRoomController::class, 'removeUser'])
        ->name('classroom.removeUser');

    Route::resource('/books',BookController::class);
    Route::post('/group',[BookController::class,'storeGroup'])->name('group.store');
});

require __DIR__.'/auth.php';
