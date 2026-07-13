@extends('layouts.app')

@section('title', 'Evaluation Form')

@section('content')
    <h1 class="page-title">Evaluation Form</h1>
    <p class="page-lead">One reviewer can evaluate every student in this presentation from a single form.</p>

    <div class="card">
        <p><strong>Class:</strong> {{ $presentation->presentationType->classroom->name }}</p>
        <p><strong>Type:</strong> {{ $presentation->presentationType->name }}</p>
        <p><strong>Title:</strong> {{ $presentation->title }}</p>
        <p><strong>Students:</strong> {{ $presentation->students->pluck('name')->join(', ') }}</p>
        <p><strong>Logged in as:</strong> {{ $reviewerName }}</p>

        <form method="POST" action="{{ route('evaluations.logout', $presentation->token) }}">
            @csrf
            <button class="button button-plain" type="submit">Use a different student ID or name</button>
        </form>
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
        <form method="POST" action="{{ route('evaluations.store', $presentation->token) }}">
            @csrf

            @foreach($presentation->students as $index => $student)
                <div class="card" style="margin-top: 24px;">
                    <h2>{{ $student->name }}</h2>
                    <input type="hidden" name="evaluations[{{ $index }}][student_id]" value="{{ $student->id }}">

                    <div class="form-group">
                        <label>Content</label>
                        <div class="score-options">
                            @for($i = 1; $i <= 5; $i++)
                                <label>
                                    <input type="radio" name="evaluations[{{ $index }}][content_score]" value="{{ $i }}" {{ old("evaluations.$index.content_score") == $i ? 'checked' : '' }} required>
                                    {{ $i }}
                                </label>
                            @endfor
                        </div>
                    </div>

                    <div class="form-group">
                        <label>English</label>
                        <div class="score-options">
                            @for($i = 1; $i <= 5; $i++)
                                <label>
                                    <input type="radio" name="evaluations[{{ $index }}][english_score]" value="{{ $i }}" {{ old("evaluations.$index.english_score") == $i ? 'checked' : '' }} required>
                                    {{ $i }}
                                </label>
                            @endfor
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Delivery</label>
                        <div class="score-options">
                            @for($i = 1; $i <= 5; $i++)
                                <label>
                                    <input type="radio" name="evaluations[{{ $index }}][delivery_score]" value="{{ $i }}" {{ old("evaluations.$index.delivery_score") == $i ? 'checked' : '' }} required>
                                    {{ $i }}
                                </label>
                            @endfor
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Communication</label>
                        <div class="score-options">
                            @for($i = 1; $i <= 5; $i++)
                                <label>
                                    <input type="radio" name="evaluations[{{ $index }}][communication_score]" value="{{ $i }}" {{ old("evaluations.$index.communication_score") == $i ? 'checked' : '' }} required>
                                    {{ $i }}
                                </label>
                            @endfor
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Good point</label>
                        <textarea name="evaluations[{{ $index }}][good_point]" placeholder="What was good?">{{ old("evaluations.$index.good_point") }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Advice</label>
                        <textarea name="evaluations[{{ $index }}][advice]" placeholder="What could be improved?">{{ old("evaluations.$index.advice") }}</textarea>
                    </div>
                </div>
            @endforeach

            <button class="button button-full" type="submit">Submit evaluations</button>
        </form>
    </div>
@endsection
