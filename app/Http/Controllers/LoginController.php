<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // Valida as credenciais
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Tenta autenticar o usuário
        if (!Auth::attempt($request->only('email', 'password'))) {
            throw ValidationException::withMessages([
                'email' => ['Invalid credentials.'],
            ])->status(401);
        }

        // Pega o usuário autenticado
        $user = $request->user();

        // Gera um token de API (Sanctum)
        $token = $user->createToken('auth_token')->plainTextToken;

        // Retorna a resposta de sucesso
        return response()->json([
            'message' => 'Login successful.',
            'token' => $token,
        ]);
    }
}
