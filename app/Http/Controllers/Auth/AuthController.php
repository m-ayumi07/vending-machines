<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    // ユーザーログイン画面表示
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // ユーザーログイン処理
    public function login(Request $request)
    {
        $credentials = $request->only('password', 'address');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'password' => 'パスワードが正しくありません。',
        ]);
    }

    // ユーザー新規登録画面表示
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // ユーザー新規登録処理
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'password' => 'required|confirmed',
            'address' => 'required|unique:users',
        ]);

        $user = new User([
            'password' => Hash::make($validatedData['password']),
            'address' => $validatedData['address'],
        ]);

        $user->save();

        Auth::login($user);

        return redirect('/');
    }
}