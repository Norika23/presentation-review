<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Support\Collection;

class StudentResultController extends Controller
{
    public function show(string $resultToken)
    {
        $student = Student::with(['presentation.presentationType.classroom', 'evaluations'])
            ->where('result_token', $resultToken)
            ->firstOrFail();

        $summary = $this->buildSummary($student->evaluations);

        return view('students.results', compact('student', 'summary'));
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
