@extends('layouts.app')

@section('title', 'Student Home')

@section('content')
    <h1 class="page-title">Student Home</h1>
    <p class="page-lead">Students can use the evaluation link to review presentations and their personal results link to check feedback.</p>

    <div class="card">
        <h2>How to use</h2>
        <ul class="list">
            <li class="list-item">Use the evaluation link shared by the teacher to submit scores and comments.</li>
            <li class="list-item">Use your personal results link shared by the teacher to view only your own feedback.</li>
            <li class="list-item">The teacher management screens and class-wide results are not available to student accounts.</li>
        </ul>
    </div>
@endsection
