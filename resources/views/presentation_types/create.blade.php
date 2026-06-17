@extends('layouts.app')

@section('title', 'Create Presentation Type')

@section('content')
    <h1 class="page-title">Create Presentation Type</h1>
    <p class="page-lead">Add a type inside {{ $classroom->name }}. Each type can contain multiple presentations.</p>

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
        <form method="POST" action="{{ route('presentation-types.store', $classroom) }}">
            @csrf

            <div class="form-group">
                <label for="name">Type name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" placeholder="Example: Self Introduction / Debate / Travel Guide" required>
            </div>

            <div class="actions">
                <button class="button" type="submit">Create type</button>
                <a class="button button-secondary" href="{{ route('classrooms.show', $classroom) }}">Back</a>
            </div>
        </form>
    </div>
@endsection
