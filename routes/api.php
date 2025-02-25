<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
    return $request->user();
});

Route::post('login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|string|min:6',
    ]);

    $credentials = $request->only(['email', 'password']);

    if (Auth::attempt($credentials)) {
        $user = Auth::user();

        if ($user->status == 1) {
            return response()->json([
                'success' => true,
                'message' => 'Login realizado com sucesso.',
                'data' => [
                    'user' => $user,
                    // 'token' => $user->createToken('authToken')->plainTextToken, // Gerar token se você estiver usando Sanctum ou Passport
                ],
            ], 200);
        } else {
            Auth::logout();
            return response()->json([
                'success' => false,
                'message' => 'Usuário inativo. Verifique com o administrador.',
            ], 403);
        }
    }

    return response()->json([
        'success' => false,
        'message' => 'Credenciais inválidas. Verifique o email e senha.',
    ], 401);
});
