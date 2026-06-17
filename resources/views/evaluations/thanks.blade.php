@extends('layouts.app')

@section('title', 'Submitted')

@section('content')
    <div class="card" style="text-align: center;">
        <h1 class="page-title">Submitted</h1>
        <p>Your evaluations for "{{ $presentation->title }}" have been saved.</p>
        <p class="muted">Thank you for reviewing every student in this presentation.</p>
    </div>
@endsection
