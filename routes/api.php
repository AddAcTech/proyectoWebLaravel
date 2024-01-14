<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::get('users', [AuthController::class, 'allUsers']);
Route::delete('users/{id}', [AuthController::class, 'deleteUser']);

Route::middleware('auth:sanctum')->group(function () {
/*     Route::get('users', [AuthController::class, 'allUsers']);
    Route::delete('users/{id}', [AuthController::class, 'deleteUser']); */
    Route::get('profile', [AuthController::class, 'userProfile']); // Nueva ruta para obtener el perfil del usuario
});
