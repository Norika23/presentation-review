<?php

namespace Tests\Feature;

use App\Models\Classroom;
use App\Models\Evaluation;
use App\Models\Presentation;
use App\Models\PresentationType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class EvaluationStudentLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_evaluation_url_opens_student_login_first(): void
    {
        $presentation = $this->createPresentation();

        $this->get(route('evaluations.create', $presentation->token))
            ->assertOk()
            ->assertSee('Student Login')
            ->assertSee('Student ID or name')
            ->assertDontSee('name="email"', false);
    }

    public function test_student_can_log_in_without_an_email_address(): void
    {
        $presentation = $this->createPresentation();

        $this->post(route('evaluations.login', $presentation->token), [
            'student_identifier' => '2-A-12 Suzuki',
        ])->assertRedirect(route('evaluations.create', $presentation->token));

        $this->get(route('evaluations.create', $presentation->token))
            ->assertOk()
            ->assertSee('Evaluation Form')
            ->assertSee('Logged in as:')
            ->assertSee('2-A-12 Suzuki');
    }

    public function test_logged_in_student_identity_is_used_for_the_evaluation(): void
    {
        $presentation = $this->createPresentation();
        $student = $presentation->students()->create([
            'name' => 'Presenter',
            'result_token' => Str::random(32),
        ]);

        $this->withSession(["evaluation_reviewers.$presentation->token" => 'S-001'])
            ->post(route('evaluations.store', $presentation->token), [
                'evaluations' => [[
                    'student_id' => $student->id,
                    'content_score' => 5,
                    'english_score' => 4,
                    'delivery_score' => 3,
                    'communication_score' => 4,
                    'good_point' => 'Clear structure',
                    'advice' => 'Speak more slowly',
                ]],
            ])->assertOk();

        $this->assertSame('S-001', Evaluation::first()->reviewer_name);
    }

    private function createPresentation(): Presentation
    {
        $classroom = Classroom::create(['name' => 'Class 2-A']);
        $type = PresentationType::create([
            'classroom_id' => $classroom->id,
            'name' => 'Speech',
        ]);

        return Presentation::create([
            'presentation_type_id' => $type->id,
            'title' => 'My Presentation',
            'token' => Str::random(16),
        ]);
    }
}
