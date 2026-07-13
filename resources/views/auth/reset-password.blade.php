@extends('layouts.app')

@section('title', 'Reset password')

@section('content')
    <h1 class="page-title">Reset your password</h1>
    <p class="page-lead">Choose a new password for your teacher account.</p>

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
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email', $email) }}" required autofocus autocomplete="email">
            </div>

            <div class="form-group">
                <label for="password">New password</label>
                <input id="password" type="password" name="password" required autocomplete="new-password">
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm new password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password">
            </div>

            <button class="button button-full" type="submit">Reset password</button>
        </form>
    </div>
@endsection
