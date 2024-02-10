<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegisteredUserControllerApi;
use App\Http\Controllers\Api\AuthenticatedSessionControllerApi;

    Route::post('register', [RegisteredUserControllerApi::class, 'store']);

    Route::post('login', [AuthenticatedSessionControllerApi::class, 'store']);






