<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $datos = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $usuario = User::with('role')
            ->where('email', $datos['email'])
            ->first();

        if (
            ! $usuario ||
            ! Hash::check($datos['password'], $usuario->password)
        ) {
            return response()->json([
                'message' => 'El correo o la contraseña son incorrectos.',
            ], 401);
        }

        $token = $usuario->createToken('angular-app')->plainTextToken;

        return response()->json([
            'message' => 'Inicio de sesión exitoso.',
            'token' => $token,
            'user' => $usuario,
        ]);
    }
}
