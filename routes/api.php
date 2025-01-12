<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ColaboradorController;
use App\Http\Controllers\EmpresaController;
use Illuminate\Support\Facades\Route;

// Rotas públicas (sem autenticação)
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::post('/empresa/register', [EmpresaController::class, 'register']);
Route::post('/empresa/login', [EmpresaController::class, 'login'])->name('empresa.login');

// Rotas protegidas (com autenticação via JWT)
Route::middleware('auth:api')->group(function () {
    Route::post('/upload', [ColaboradorController::class, 'uploadCSV']);

    Route::prefix('empresa')->group(function () {
        Route::get('/me', [EmpresaController::class, 'me']);
        Route::post('/logout', [EmpresaController::class, 'logout']);
    });
});
