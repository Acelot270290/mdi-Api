<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);
Route::middleware('jwt.auth')->get('user', [AuthController::class, 'getAuthenticatedUser']);
Route::post('register', [AuthController::class, 'register']);
