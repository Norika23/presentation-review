@extends('layouts.app')

@section('title', 'Create Class')

@section('content')
    <h1 class="page-title">Create Class</h1>
    <p class="page-lead">Create the class first. Presentations are added inside the class.</p>

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
        <form method="POST" action="{{ route('classrooms.store') }}">
            @csrf

            <div class="form-group">
                <label for="name">Class name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" placeholder="Example: Grade 2 Class A" required>
            </div>

            <div class="actions">
                <button class="button" type="submit">Create class</button>
                <a class="button button-secondary" href="{{ route('classrooms.index') }}">Back</a>
            </div>
        </form>
    </div>
@endsection
