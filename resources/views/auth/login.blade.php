@extends('layouts.app')

@section('title', 'ログイン')

@section('content')
    <h1>ログイン</h1>
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <label for="email">メールアドレス</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
            @error('email')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="password">パスワード</label>
            <input id="password" type="password" name="password" required>
            @error('password')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <div>
            <button type="submit">ログイン</button>
        </div>
    </form>

    <a href="{{ route('register') }}">新規登録</a>
@endsection