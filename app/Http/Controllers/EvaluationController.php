<?php

namespace App\Http\Controllers;

use App\Models\Presentation;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EvaluationController extends Controller
{
    public function create($token)
    {
        $presentation = Presentation::with(['presentationType.classroom', 'students'])
            ->where('token', $token)
            ->firstOrFail();

        return view('evaluations.create', compact('presentation'));
    }

    public function store(Request $request, $token)
    {
        $presentation = Presentation::with('students')
            ->where('token', $token)
            ->firstOrFail();

        $studentIds = $presentation->students->pluck('id')->all();

        $validated = $request->validate([
            'reviewer_name' => ['required', 'string', 'max:255'],
            'evaluations' => ['required', 'array', 'min:1'],
            'evaluations.*.student_id' => ['required', 'integer', Rule::in($studentIds)],
            'evaluations.*.content_score' => ['required', 'integer', 'min:1', 'max:5'],
            'evaluations.*.english_score' => ['required', 'integer', 'min:1', 'max:5'],
            'evaluations.*.delivery_score' => ['required', 'integer', 'min:1', 'max:5'],
            'evaluations.*.communication_score' => ['required', 'integer', 'min:1', 'max:5'],
            'evaluations.*.good_point' => ['nullable', 'string', 'max:1000'],
            'evaluations.*.advice' => ['nullable', 'string', 'max:1000'],
        ]);

        try {
            foreach ($validated['evaluations'] as $evaluationData) {
                $student = $presentation->students->firstWhere('id', $evaluationData['student_id']);

                $student->evaluations()->create([
                    'reviewer_name' => $validated['reviewer_name'],
                    'content_score' => $evaluationData['content_score'],
                    'english_score' => $evaluationData['english_score'],
                    'delivery_score' => $evaluationData['delivery_score'],
                    'communication_score' => $evaluationData['communication_score'],
                    'good_point' => $evaluationData['good_point'] ?? null,
                    'advice' => $evaluationData['advice'] ?? null,
                ]);
            }
        } catch (QueryException $e) {
            return back()
                ->withInput()
                ->withErrors([
                    'reviewer_name' => 'This reviewer has already submitted scores for one or more students in this presentation.',
                ]);
        }

        return view('evaluations.thanks', compact('presentation'));
    }
}
