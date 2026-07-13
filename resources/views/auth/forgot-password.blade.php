@extends('layouts.app')

@section('title', 'Forgot password')

@section('content')
    <h1 class="page-title">Forgot your password?</h1>
    <p class="page-lead">Enter your email address and we will send you a password reset link.</p>

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
        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email">
            </div>

            <button class="button button-full" type="submit">Send password reset link</button>
        </form>

        <div class="form-help">
            <a href="{{ route('login') }}">Back to log in</a>
        </div>
    </div>
@endsection
