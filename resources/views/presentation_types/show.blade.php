@extends('layouts.app')

@section('title', $presentationType->name)

@section('content')
    <h1 class="page-title">{{ $presentationType->name }}</h1>
    <p class="page-lead">Choose a presentation in this type, or add a new one.</p>

    <div class="card">
        <p><strong>Class:</strong> {{ $classroom->name }}</p>
        <p><strong>Type:</strong> {{ $presentationType->name }}</p>
        <p><strong>Presentations:</strong> {{ $presentationType->presentations->count() }}</p>

        <div class="actions">
            <a class="button" href="{{ route('presentations.create', [$classroom, $presentationType]) }}">Create presentation</a>
            <a class="button button-secondary" href="{{ route('classrooms.show', $classroom) }}">Back to class</a>
        </div>
    </div>

    <div class="card">
        <h2>Presentations</h2>

        @if($presentationType->presentations->isEmpty())
            <p class="muted">No presentations in this type yet.</p>
        @else
            <ul class="list">
                @foreach($presentationType->presentations as $presentation)
                    <li class="list-item">
                        <div class="list-title">{{ $presentation->title }}</div>
                        <div class="muted">{{ $presentation->students->pluck('name')->join(', ') }}</div>

                        <div class="actions">
                            <a class="button button-secondary" href="{{ route('presentations.show', $presentation) }}">
                                QR and URL
                            </a>
                            <a class="button button-secondary" href="{{ route('presentations.results', $presentation) }}">
                                View results
                            </a>
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
