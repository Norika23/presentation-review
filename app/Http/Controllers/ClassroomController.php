<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    public function index()
    {
        $classrooms = Classroom::withCount('presentationTypes')
            ->with('presentationTypes.presentations.students')
            ->orderBy('name')
            ->get();

        return view('classrooms.index', compact('classrooms'));
    }

    public function create()
    {
        return view('classrooms.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:classrooms,name'],
        ]);

        $classroom = Classroom::create([
            'name' => trim($validated['name']),
        ]);

        return redirect()->route('classrooms.show', $classroom);
    }

    public function show(Classroom $classroom)
    {
        $classroom->load('presentationTypes.presentations.students');

        return view('classrooms.show', compact('classroom'));
    }
}
