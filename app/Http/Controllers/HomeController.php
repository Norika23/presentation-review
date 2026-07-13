<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->isTeacher()) {
            return redirect()->route('classrooms.index');
        }

        return view('home.student');
    }
}
