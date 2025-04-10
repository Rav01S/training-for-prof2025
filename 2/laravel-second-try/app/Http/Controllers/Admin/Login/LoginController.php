<?php

namespace App\Http\Controllers\Admin\Login;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function index(): View
    {
        return view('pages.admin.login.index');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
        ]);

        if (!auth()->attempt($request->only('email', 'password'))) {
            throw ValidationException::withMessages([
                'email' => 'Неверный Email или пароль'
            ]);
        };

        $user = auth()->user();

        if ($user->role !== 'admin') {
            auth()->logout();

            session()->invalidate();

            throw ValidationException::withMessages([
                'email' => 'Неверный Email или пароль'
            ]);
        }

        return redirect()->intended(route('admin.categories.index'));
    }

    public function logout(): RedirectResponse {
        auth()->logout();

        session()->invalidate();

        return redirect()->route('admin.login');
    }
}
