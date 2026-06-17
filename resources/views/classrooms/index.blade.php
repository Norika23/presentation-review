@extends('layouts.app')

@section('title', 'Classes')

@section('content')
    <h1 class="page-title">Classes</h1>
    <p class="page-lead">Choose a class first, then open one of its presentations.</p>

    <div class="card">
        <h2>Classrooms</h2>

        <div class="actions">
            <a class="button" href="{{ route('classrooms.create') }}">Create new class</a>
        </div>
    </div>

    <div class="card">
        @if($classrooms->isEmpty())
            <p class="muted">No classes yet.</p>
        @else
            <ul class="list">
                @foreach($classrooms as $classroom)
                    <li class="list-item">
                        <div class="list-title">{{ $classroom->name }}</div>
                        <div class="muted">
                            {{ $classroom->presentation_types_count }} types
                            @if($classroom->presentationTypes->isNotEmpty())
                                / {{ $classroom->presentationTypes->flatMap->presentations->count() }} presentations
                            @endif
                        </div>

                        <div class="actions">
                            <a class="button button-secondary" href="{{ route('classrooms.show', $classroom) }}">
                                Open class
                            </a>
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
