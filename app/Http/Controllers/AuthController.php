<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function showLoginForm()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' =>  'required|email',
            'password'  => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            return match ($user->role) {
                'manager' => redirect()->route('manager.index')->with('success', 'Welcome back, Petugas!'),
                'kasir' => redirect()->route('kasir.index')->with('success', 'Welcome back, Admin!'),
                'admin' =>redirect()->route('admin.index')->with('success, Welcome back'),
               'waiter' => redirect()->route('waiter.dashboard')->with('success', 'Welcome back, Waiter!')
                // default => redirect()->route('visitor.index')->with('success', 'Berhasil login sebagai Visitor!'),
            };
        }
        return back()->withInput()->with('error', 'Email Atau Password Salah!');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        Auth::login($user);

        return redirect('/login');
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'logout berhasil');
    }
}
