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

Route::post('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'register']);
