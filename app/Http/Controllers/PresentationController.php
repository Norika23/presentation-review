<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Presentation;
use App\Models\PresentationType;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class PresentationController extends Controller
{
    public function index()
    {
        return redirect()->route('classrooms.index');
    }

    public function create(Classroom $classroom, PresentationType $presentationType)
    {
        abort_unless($presentationType->classroom_id === $classroom->id, 404);

        return view('presentations.create', compact('classroom', 'presentationType'));
    }

    public function store(Request $request, Classroom $classroom, PresentationType $presentationType)
    {
        abort_unless($presentationType->classroom_id === $classroom->id, 404);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'student_names' => ['required', 'string'],
        ]);

        $studentNames = collect(preg_split('/\r\n|\r|\n/', $validated['student_names']))
            ->map(fn ($name) => trim($name))
            ->filter()
            ->unique()
            ->values();

        if ($studentNames->isEmpty()) {
            return back()
                ->withInput()
                ->withErrors(['student_names' => 'At least one student is required.']);
        }

        $presentation = Presentation::create([
            'presentation_type_id' => $presentationType->id,
            'title' => trim($validated['title']),
            'token' => Str::random(16),
        ]);

        $presentation->students()->createMany(
            $studentNames->map(fn ($name) => ['name' => $name])->all()
        );

        return redirect()->route('presentation-types.show', [$classroom, $presentationType]);
    }

    public function show(Presentation $presentation)
    {
        $presentation->load(['presentationType.classroom', 'students']);

        return view('presentations.show', compact('presentation'));
    }

    public function results(Presentation $presentation)
    {
        $presentation->load([
            'presentationType.classroom',
            'students.evaluations',
        ]);

        $studentSummaries = $presentation->students
            ->map(function ($student) {
                $evaluations = $student->evaluations;

                return [
                    'student' => $student,
                    'evaluations' => $evaluations,
                    'summary' => $this->buildSummary($evaluations),
                ];
            });

        $allEvaluations = $presentation->students
            ->flatMap(fn ($student) => $student->evaluations);

        $presentationSummary = $this->buildSummary($allEvaluations);

        return view('presentations.results', compact(
            'presentation',
            'studentSummaries',
            'presentationSummary'
        ));
    }

    private function buildSummary(Collection $evaluations): array
    {
        return [
            'count' => $evaluations->count(),
            'content_avg' => $evaluations->isEmpty() ? null : round($evaluations->avg('content_score'), 1),
            'english_avg' => $evaluations->isEmpty() ? null : round($evaluations->avg('english_score'), 1),
            'delivery_avg' => $evaluations->isEmpty() ? null : round($evaluations->avg('delivery_score'), 1),
            'communication_avg' => $evaluations->isEmpty() ? null : round($evaluations->avg('communication_score'), 1),
            'total_avg' => $evaluations->isEmpty()
                ? null
                : round($evaluations->avg(fn ($evaluation) => $evaluation->total_score), 1),
        ];
    }
}
