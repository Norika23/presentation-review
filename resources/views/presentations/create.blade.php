@extends('layouts.app')

@section('title', 'Create Presentation')

@section('content')
    <h1 class="page-title">Create Presentation</h1>
    <p class="page-lead">Add a presentation inside {{ $classroom->name }} / {{ $presentationType->name }}, then register the student presenters.</p>

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
        <form method="POST" action="{{ route('presentations.store', [$classroom, $presentationType]) }}">
            @csrf

            <div class="form-group">
                <label>Presentation type</label>
                <input type="text" value="{{ $presentationType->name }}" disabled>
            </div>

            <div class="form-group">
                <label for="title">Presentation title</label>
                <input id="title" type="text" name="title" value="{{ old('title') }}" placeholder="Example: My Favorite Place" required>
            </div>

            <div class="form-group">
                <label for="student_names">Student names</label>
                <textarea id="student_names" name="student_names" placeholder="One student per line&#10;Aiko&#10;Haruto&#10;Mio" required>{{ old('student_names') }}</textarea>
                <p class="hint">Enter one student per line. These students will each receive separate evaluations.</p>
            </div>

            <div class="actions">
                <button class="button" type="submit">Create</button>
                <a class="button button-secondary" href="{{ route('presentation-types.show', [$classroom, $presentationType]) }}">Back</a>
            </div>
        </form>
    </div>
@endsection
