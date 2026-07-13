<?php

namespace App\Http\Controllers;

use App\Models\Presentation;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EvaluationController extends Controller
{
    public function create(Request $request, string $token)
    {
        $presentation = Presentation::with(['presentationType.classroom', 'students'])
            ->where('token', $token)
            ->firstOrFail();

        $reviewerName = $request->session()->get($this->sessionKey($token));

        if (! $reviewerName) {
            return view('evaluations.login', compact('presentation'));
        }

        return view('evaluations.create', compact('presentation', 'reviewerName'));
    }

    public function login(Request $request, string $token)
    {
        Presentation::where('token', $token)->firstOrFail();

        $validated = $request->validate([
            'student_identifier' => ['required', 'string', 'max:255'],
        ]);

        $request->session()->put(
            $this->sessionKey($token),
            trim($validated['student_identifier'])
        );

        return redirect()->route('evaluations.create', $token);
    }

    public function logout(Request $request, string $token)
    {
        $request->session()->forget($this->sessionKey($token));

        return redirect()->route('evaluations.create', $token);
    }

    public function store(Request $request, string $token)
    {
        $presentation = Presentation::with('students')
            ->where('token', $token)
            ->firstOrFail();

        $reviewerName = $request->session()->get($this->sessionKey($token));

        if (! $reviewerName) {
            return redirect()
                ->route('evaluations.create', $token)
                ->withErrors(['student_identifier' => 'Please log in before submitting an evaluation.']);
        }

        $studentIds = $presentation->students->pluck('id')->all();

        $validated = $request->validate([
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
                    'reviewer_name' => $reviewerName,
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
                    'evaluations' => 'You have already submitted scores for one or more students in this presentation.',
                ]);
        }

        return view('evaluations.thanks', compact('presentation'));
    }

    private function sessionKey(string $token): string
    {
        return "evaluation_reviewers.$token";
    }
}
