<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// user registration (sign-up)
Route::post('/register', [RegisterController::class, 'register']);

// user login
Route::post('/login', [LoginController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    // user logout
    Route::get('/logout', [LogoutController::class, 'logout']);
    // user
    Route::get("/user", [UserController::class, "user"]);
});
