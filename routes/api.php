<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;


// =================== ROTA DE POST ===========================
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login',[LoginController::class, 'login']);

// =================== ROTA DE GET ===========================



// =================== ROTA DE UPDATE ===========================



// =================== ROTA DE DELETE ===========================


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
