@extends('layouts.app')

@section('title', 'Log in')

@section('content')
    <h1 class="page-title">Login</h1>
    <p class="page-lead">Teachers and students can continue with their Google account.</p>

    @if (session('status'))
        <div class="success">{{ session('status') }}</div>
    @endif

    @if ($errors->any())
        <div class="error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <a class="button button-google button-full" href="{{ route('auth.google.redirect') }}">
            Continue with Google
        </a>

        <div class="form-divider"><span>or use a teacher password</span></div>

        <form method="POST" action="{{ route('login.store') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" required>
                <div class="form-help">
                    <a href="{{ route('password.request') }}">Forgot your password?</a>
                </div>
            </div>

            <div class="form-group">
                <label>
                    <input type="checkbox" name="remember" value="1">
                    Remember me
                </label>
            </div>

            <button class="button button-full" type="submit">Log in</button>
        </form>
    </div>
@endsection
