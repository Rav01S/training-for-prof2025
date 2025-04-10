<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function auth(Request $request): JsonResponse {
        $validated = $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string'
        ]);

        if(!auth()->attempt($request->only('email', 'password'))) {
               throw ValidationException::withMessages([
                   'email' => 'Неверный Email или пароль'
               ]);
        }

        $user = auth()->user();

        $token = $user->createToken('token')->plainTextToken;

        return response()->json([
            'token' => $token
        ]);
    }

    public function registration(Request $request): JsonResponse {
        $validated = $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:3'
        ]);

        User::query()->create($validated);

        return response()->json([
            'success' => true
        ]);
    }
}
