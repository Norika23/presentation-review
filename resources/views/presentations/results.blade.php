@extends('layouts.app')

@section('title', 'Evaluation Results')

@section('content')
    <h1 class="page-title">Evaluation Results</h1>
    <p class="page-lead">Results for "{{ $presentation->title }}" in {{ $presentation->presentationType->classroom->name }}.</p>

    <div class="card">
        <p><strong>Class:</strong> {{ $presentation->presentationType->classroom->name }}</p>
        <p><strong>Type:</strong> {{ $presentation->presentationType->name }}</p>
        <p><strong>Title:</strong> {{ $presentation->title }}</p>
        <p><strong>Students:</strong> {{ $presentation->students->pluck('name')->join(', ') }}</p>

        <div class="actions">
            <a class="button button-secondary" href="{{ route('presentation-types.show', [$presentation->presentationType->classroom, $presentation->presentationType]) }}">Back to type</a>
            <a class="button button-secondary" href="{{ route('presentations.show', $presentation) }}">QR and URL</a>
        </div>
    </div>

    <div class="card">
        <h2>Overall Summary</h2>

        @if($presentationSummary['count'] === 0)
            <p class="muted">No evaluations have been submitted yet.</p>
        @else
            <div class="summary-grid">
                <div class="summary-item">
                    Reviews
                    <strong>{{ $presentationSummary['count'] }}</strong>
                </div>
                <div class="summary-item">
                    Total average
                    <strong>{{ $presentationSummary['total_avg'] }} / 20</strong>
                </div>
                <div class="summary-item">
                    Content
                    <strong>{{ $presentationSummary['content_avg'] }} / 5</strong>
                </div>
                <div class="summary-item">
                    English
                    <strong>{{ $presentationSummary['english_avg'] }} / 5</strong>
                </div>
                <div class="summary-item">
                    Delivery
                    <strong>{{ $presentationSummary['delivery_avg'] }} / 5</strong>
                </div>
                <div class="summary-item">
                    Communication
                    <strong>{{ $presentationSummary['communication_avg'] }} / 5</strong>
                </div>
            </div>
        @endif
    </div>

    @foreach($studentSummaries as $studentSummary)
        <div class="card">
            <h2>{{ $studentSummary['student']->name }}</h2>

            @if($studentSummary['summary']['count'] === 0)
                <p class="muted">No evaluations for this student yet.</p>
            @else
                <div class="summary-grid">
                    <div class="summary-item">
                        Reviews
                        <strong>{{ $studentSummary['summary']['count'] }}</strong>
                    </div>
                    <div class="summary-item">
                        Total average
                        <strong>{{ $studentSummary['summary']['total_avg'] }} / 20</strong>
                    </div>
                    <div class="summary-item">
                        Content
                        <strong>{{ $studentSummary['summary']['content_avg'] }} / 5</strong>
                    </div>
                    <div class="summary-item">
                        English
                        <strong>{{ $studentSummary['summary']['english_avg'] }} / 5</strong>
                    </div>
                    <div class="summary-item">
                        Delivery
                        <strong>{{ $studentSummary['summary']['delivery_avg'] }} / 5</strong>
                    </div>
                    <div class="summary-item">
                        Communication
                        <strong>{{ $studentSummary['summary']['communication_avg'] }} / 5</strong>
                    </div>
                </div>

                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Reviewer</th>
                                <th>Content</th>
                                <th>English</th>
                                <th>Delivery</th>
                                <th>Communication</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($studentSummary['evaluations'] as $evaluation)
                                <tr>
                                    <td>{{ $evaluation->reviewer_name }}</td>
                                    <td>{{ $evaluation->content_score }}</td>
                                    <td>{{ $evaluation->english_score }}</td>
                                    <td>{{ $evaluation->delivery_score }}</td>
                                    <td>{{ $evaluation->communication_score }}</td>
                                    <td>{{ $evaluation->total_score }} / 20</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <div class="card">
            <h2>{{ $studentSummary['student']->name }}: Good Points</h2>

            @forelse($studentSummary['evaluations']->whereNotNull('good_point')->where('good_point', '!=', '') as $evaluation)
                <div class="comment">
                    <p class="muted">Reviewer: {{ $evaluation->reviewer_name }}</p>
                    <p>{{ $evaluation->good_point }}</p>
                </div>
            @empty
                <p class="muted">No good points yet.</p>
            @endforelse
        </div>

        <div class="card">
            <h2>{{ $studentSummary['student']->name }}: Advice</h2>

            @forelse($studentSummary['evaluations']->whereNotNull('advice')->where('advice', '!=', '') as $evaluation)
                <div class="comment">
                    <p class="muted">Reviewer: {{ $evaluation->reviewer_name }}</p>
                    <p>{{ $evaluation->advice }}</p>
                </div>
            @empty
                <p class="muted">No advice yet.</p>
            @endforelse
        </div>
    @endforeach
@endsection
