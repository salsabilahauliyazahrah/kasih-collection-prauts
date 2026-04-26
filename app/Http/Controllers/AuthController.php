<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //tampilkan login 
    public function showLoginForm()
    {
        return view('login');
    }

    //proses login 
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // cek login dulu
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // baru cek role
            if (Auth::user()->role === 'admin') {
                return redirect('/admin');
            } else {
                return redirect()->route('landing');
            }
        }

        // kalau gagal login
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    //menampilkan form register
    public function showRegisterForm()
    {
        return view('register');  
    }

    //proses register
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]); 
        
        User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'role' => 'user',
        ]);

        return redirect()->route('login')->with('success', 'Registration successful. Please login.');   
    }

    //logout
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Logged out successfully.');
    }
}
