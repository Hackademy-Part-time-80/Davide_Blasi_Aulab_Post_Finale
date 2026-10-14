<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showRegister() { return view('pages.auth.register'); }
    public function showLogin() { return view('pages.auth.login'); }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        Auth::login(User::create($data));

        return redirect()->route('homepage')->with('success', 'Registrazione completata, benvenuto!');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate(['email' => 'required|email', 'password' => 'required']);

        if (! Auth::attempt($credentials)) {
            return back()->withErrors(['email' => 'Email o password non corretti.'])->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('homepage'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('homepage');
    }
}
