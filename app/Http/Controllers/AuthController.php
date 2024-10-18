<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Handle Registration
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'customer', // Mặc định là customer
        ]);

        return redirect()->route('login')->with('success', 'Registration successful!');
    }

    // Show Login Form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Handle Login
    public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $user = Auth::user();
        \Log::info('User Role:', ['role' => $user->role]); // Kiểm tra vai trò người dùng
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('products.index');
        }
    }

    return back()->withErrors(['email' => 'Invalid credentials.']);
}

    // Handle Logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
