<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\PresentationType;
use Illuminate\Http\Request;

class PresentationTypeController extends Controller
{
    public function create(Classroom $classroom)
    {
        return view('presentation_types.create', compact('classroom'));
    }

    public function store(Request $request, Classroom $classroom)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $presentationType = PresentationType::create([
            'classroom_id' => $classroom->id,
            'name' => trim($validated['name']),
        ]);

        return redirect()->route('presentation-types.show', [$classroom, $presentationType]);
    }

    public function show(Classroom $classroom, PresentationType $presentationType)
    {
        abort_unless($presentationType->classroom_id === $classroom->id, 404);

        $presentationType->load('presentations.students');

        return view('presentation_types.show', compact('classroom', 'presentationType'));
    }
}
