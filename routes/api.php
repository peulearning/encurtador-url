<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\RedirectController;


// =================== ROTA DE POST ===========================
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login',[LoginController::class, 'login']);

// =================== ROTA DE GET ===========================


Route::get('/s/{slug}', [RedirectController::class, 'show']);


// =================== ROTA DE UPDATE ===========================



// =================== ROTA DE DELETE ===========================






// =================== ROTAS DE MIDDLEWARE ===========================

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/links', [LinkController::class, 'store']);
});
