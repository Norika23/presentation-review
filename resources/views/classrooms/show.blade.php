@extends('layouts.app')

@section('title', $classroom->name)

@section('content')
    <h1 class="page-title">{{ $classroom->name }}</h1>
    <p class="page-lead">Choose a presentation type first, then open one of its presentations.</p>

    <div class="card">
        <p><strong>Class:</strong> {{ $classroom->name }}</p>
        <p><strong>Types:</strong> {{ $classroom->presentationTypes->count() }}</p>

        <div class="actions">
            <a class="button" href="{{ route('presentation-types.create', $classroom) }}">Create presentation type</a>
            <a class="button button-secondary" href="{{ route('classrooms.index') }}">Back to classes</a>
        </div>
    </div>

    <div class="card">
        <h2>Presentation Types</h2>

        @if($classroom->presentationTypes->isEmpty())
            <p class="muted">No presentation types in this class yet.</p>
        @else
            <ul class="list">
                @foreach($classroom->presentationTypes as $presentationType)
                    <li class="list-item">
                        <div class="list-title">{{ $presentationType->name }}</div>
                        <div class="muted">{{ $presentationType->presentations->count() }} presentations</div>

                        <div class="actions">
                            <a class="button button-secondary" href="{{ route('presentation-types.show', [$classroom, $presentationType]) }}">
                                Open type
                            </a>
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
