@extends('layouts.app')

@section('title', 'Presentation Details')

@section('content')
    <h1 class="page-title">{{ $presentation->title }}</h1>
    <p class="page-lead">Share this QR code or URL so reviewers can score each student in this presentation.</p>

    <div class="card">
        <p><strong>Class:</strong> {{ $presentation->presentationType->classroom->name }}</p>
        <p><strong>Type:</strong> {{ $presentation->presentationType->name }}</p>
        <p><strong>Title:</strong> {{ $presentation->title }}</p>
        <p><strong>Students:</strong> {{ $presentation->students->pluck('name')->join(', ') }}</p>

        <div class="actions">
            <a class="button button-secondary" href="{{ route('presentation-types.show', [$presentation->presentationType->classroom, $presentation->presentationType]) }}">Back to type</a>
            <a class="button button-secondary" href="{{ route('presentations.results', $presentation) }}">View results</a>
        </div>
    </div>

    <div class="card qr-box">
        <h2>Evaluation QR Code</h2>

        {!! QrCode::format('svg')->size(280)->generate(route('evaluations.create', $presentation->token)) !!}

        <p class="muted">Reviewers can open the evaluation form directly from this QR code.</p>
    </div>

    <div class="card">
        <h2>Evaluation URL</h2>

        <p class="url-box">
            <a href="{{ route('evaluations.create', $presentation->token) }}" target="_blank">
                {{ route('evaluations.create', $presentation->token) }}
            </a>
        </p>
    </div>
@endsection
