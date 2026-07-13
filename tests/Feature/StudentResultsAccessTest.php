<?php

namespace Tests\Feature;

use App\Models\Classroom;
use App\Models\Presentation;
use App\Models\PresentationType;
use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class StudentResultsAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_result_page_is_public_with_valid_token(): void
    {
        $student = $this->createStudent();

        $response = $this->get(route('students.results', $student->result_token));

        $response->assertOk();
        $response->assertSee($student->name . '\'s Results', false);
    }

    public function test_student_result_page_returns_not_found_with_invalid_token(): void
    {
        $this->createStudent();

        $response = $this->get(route('students.results', Str::random(32)));

        $response->assertNotFound();
    }

    private function createStudent(): Student
    {
        $classroom = Classroom::create(['name' => 'Class 1']);
        $presentationType = PresentationType::create([
            'classroom_id' => $classroom->id,
            'name' => 'Speech',
        ]);
        $presentation = Presentation::create([
            'presentation_type_id' => $presentationType->id,
            'title' => 'My Topic',
            'token' => Str::random(16),
        ]);

        return Student::create([
            'presentation_id' => $presentation->id,
            'name' => 'Aiko',
            'result_token' => Str::random(32),
        ]);
    }
}
