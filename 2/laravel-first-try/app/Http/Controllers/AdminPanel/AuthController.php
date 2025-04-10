<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function index(): View
    {
        return view('pages.AdminPanel.login');
    }

    public function login(Request $request): View|RedirectResponse
    {
        $validated = $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required'
        ]);

        if (!auth()->attempt($request->only('email', 'password'))) {
            return back()->withErrors([
                'email' => 'Неверный Email или пароль'
            ]);
        }

        $request->session()->regenerate();

        return redirect()->route('admin.categories.index');
    }

    public function logout(): RedirectResponse
    {
        auth()->logout();

        session()->invalidate();

        return redirect()->route('admin.login.index');
    }
}
