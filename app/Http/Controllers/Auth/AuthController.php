<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * ログイン処理
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        // バリデーション
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 認証処理
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // 認証成功時の処理
            $request->session()->regenerate();

            return redirect()->intended('dashboard');
        }

        // 認証失敗時の処理
        return back()->withErrors([
            'email' => 'メールアドレスまたはパスワードが正しくありません。',
        ]);

        // 新規登録の処理が成功した後
        return redirect()->route('login')->with('success', '登録が完了しました。ログインしてください。');
    }
}