@extends('layouts.app')

@section('title', 'Student Login')

@section('content')
    <h1 class="page-title">Student Login</h1>
    <p class="page-lead">Enter your student ID or name to open the evaluation form. An email address is not required.</p>

    <div class="card">
        <p><strong>Class:</strong> {{ $presentation->presentationType->classroom->name }}</p>
        <p><strong>Type:</strong> {{ $presentation->presentationType->name }}</p>
        <p><strong>Presentation:</strong> {{ $presentation->title }}</p>
    </div>

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
        <form method="POST" action="{{ route('evaluations.login', $presentation->token) }}">
            @csrf

            <div class="form-group">
                <label for="student_identifier">Student ID or name</label>
                <input
                    id="student_identifier"
                    type="text"
                    name="student_identifier"
                    value="{{ old('student_identifier') }}"
                    placeholder="Example: 2-A-12 Suzuki"
                    required
                    autofocus
                    autocomplete="username"
                >
                <p class="hint">Use the same ID or name each time so duplicate submissions can be prevented.</p>
            </div>

            <button class="button button-full" type="submit">Log in and start evaluation</button>
        </form>
    </div>
@endsection
