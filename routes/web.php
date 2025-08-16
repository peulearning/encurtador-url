<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\RegisterController;


Route::get('/', function () {
    return view('welcome');
});


Route::get('/ping', function () {
    return response()->json(['message' => 'pong']);
});


