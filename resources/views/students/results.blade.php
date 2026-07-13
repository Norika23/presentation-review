@extends('layouts.app')

@section('title', 'My Results')

@section('content')
    <h1 class="page-title">{{ $student->name }}'s Results</h1>
    <p class="page-lead">Your feedback for "{{ $student->presentation->title }}" in {{ $student->presentation->presentationType->classroom->name }}.</p>

    <div class="card">
        <p><strong>Class:</strong> {{ $student->presentation->presentationType->classroom->name }}</p>
        <p><strong>Type:</strong> {{ $student->presentation->presentationType->name }}</p>
        <p><strong>Presentation:</strong> {{ $student->presentation->title }}</p>
        <p><strong>Student:</strong> {{ $student->name }}</p>
    </div>

    <div class="card">
        <h2>Summary</h2>

        @if($summary['count'] === 0)
            <p class="muted">No feedback has been submitted for you yet.</p>
        @else
            <div class="summary-grid">
                <div class="summary-item">
                    Reviews
                    <strong>{{ $summary['count'] }}</strong>
                </div>
                <div class="summary-item">
                    Total average
                    <strong>{{ $summary['total_avg'] }} / 20</strong>
                </div>
                <div class="summary-item">
                    Content
                    <strong>{{ $summary['content_avg'] }} / 5</strong>
                </div>
                <div class="summary-item">
                    English
                    <strong>{{ $summary['english_avg'] }} / 5</strong>
                </div>
                <div class="summary-item">
                    Delivery
                    <strong>{{ $summary['delivery_avg'] }} / 5</strong>
                </div>
                <div class="summary-item">
                    Communication
                    <strong>{{ $summary['communication_avg'] }} / 5</strong>
                </div>
            </div>
        @endif
    </div>

    <div class="card">
        <h2>Good Points</h2>

        @forelse($student->evaluations->whereNotNull('good_point')->where('good_point', '!=', '') as $evaluation)
            <div class="comment">
                <p>{{ $evaluation->good_point }}</p>
            </div>
        @empty
            <p class="muted">No good points yet.</p>
        @endforelse
    </div>

    <div class="card">
        <h2>Advice</h2>

        @forelse($student->evaluations->whereNotNull('advice')->where('advice', '!=', '') as $evaluation)
            <div class="comment">
                <p>{{ $evaluation->advice }}</p>
            </div>
        @empty
            <p class="muted">No advice yet.</p>
        @endforelse
    </div>
@endsection
