<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\IzinPenelitian;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\UserAuthPostRequest;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function loginProcess(UserAuthPostRequest $request) : RedirectResponse
{        
    $data = $request->validate([
        'email' => 'required',
        'password' => 'required',
        'captcha' => 'required|captcha',
    ], [
        'email.required' => 'Email atau Username Tidak Boleh Kosong',
        'password.required' => 'Password Tidak Boleh Kosong',
        // 'captcha.required' => 'Captcha Tidak Boleh Kosong',
        // 'captcha.captcha' => 'Captcha tidak valid',a
    ]);

    // Login untuk user
    if (Auth::guard('user')->attempt(['email' => $data['email'], 'password' => $data['password']])) {
        $user = Auth::guard('user')->user();
        if ($user->role === 'user') {
            $request->session()->regenerate();
            return redirect()->route('home2');
        }
    }
    // Login untuk admin
    if (Auth::guard('admin')->attempt(['email' => $data['email'], 'password' => $data['password']])) {
        $user = Auth::guard('admin')->user();
        if ($user->role === 'admin') {
            $request->session()->regenerate();
            return redirect()->route('admin.izin_penelitian');
        }
    }

    // Jika login gagal
    return redirect(route('login'))->withErrors('Email atau password salah.')->onlyInput('email', 'password');
}


    public function registration()
    {
        return view('auth.user-registration');
    }

    public function registrationProcess(Request $request)  
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
        ], [
            'password.min' => 'Password minimal 6 karakter.',
        ]);

        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['password'] = Hash::make($request->password);
        $data['role'] = 'user';
        $user = User::create($data);
        if (!$user) {
            return redirect(route('user.registration'))->with('error' , 'Username atau Email telah digunakan');
        }
        return redirect('/login')->with('success' , 'Registrasi berhasil. Silahkan login untuk masuk ke aplikasi');
    }

public function logout(Request $request): RedirectResponse
{
    if (Auth::guard('admin')->check()) {
        Auth::guard('admin')->logout();
    } elseif (Auth::guard('user')->check()) {
        Auth::guard('user')->logout();
    }

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login'); // <--- perbaikan di sini
}


    public function showmsekretariat()
    {
        return view('user.msekretariat');
    }

    public function showProfil()
    {
        return view('user.profil');
    }
    
}
