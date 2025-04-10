<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request) {
        $validated = $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:3'
        ]);

        $user = User::query()->create($request->only('email', 'password'));

        return response()->json([
            'success' => true
        ], 201);
    }

    public function login(Request $request) {
        $validated = $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string'
        ]);

        if (!auth()->attempt($request->only('email', 'password'))) {
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
}
