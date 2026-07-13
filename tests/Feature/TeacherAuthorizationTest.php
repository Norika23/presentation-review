<?php

namespace Tests\Feature;

use App\Models\Classroom;
use App\Models\Presentation;
use App\Models\PresentationType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class TeacherAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login_for_results_page(): void
    {
        $presentation = $this->createPresentation();

        $response = $this->get(route('presentations.results', $presentation));

        $response->assertRedirect(route('login'));
    }

    public function test_student_cannot_open_results_page(): void
    {
        $presentation = $this->createPresentation();
        $student = User::factory()->create(['role' => 'student']);

        $response = $this->actingAs($student)->get(route('presentations.results', $presentation));

        $response->assertForbidden();
    }

    public function test_teacher_can_open_results_page(): void
    {
        $presentation = $this->createPresentation();
        $teacher = User::factory()->create(['role' => 'teacher']);

        $response = $this->actingAs($teacher)->get(route('presentations.results', $presentation));

        $response->assertOk();
        $response->assertSee('Evaluation Results');
        $response->assertSee($presentation->title);
    }

    private function createPresentation(): Presentation
    {
        $classroom = Classroom::create(['name' => 'Class 1']);
        $presentationType = PresentationType::create([
            'classroom_id' => $classroom->id,
            'name' => 'Speech',
        ]);

        return Presentation::create([
            'presentation_type_id' => $presentationType->id,
            'title' => 'My Topic',
            'token' => Str::random(16),
        ]);
    }
}
