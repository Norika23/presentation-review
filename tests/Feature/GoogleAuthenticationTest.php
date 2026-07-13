<?php

namespace Tests\Feature;

use App\Models\Classroom;
use App\Models\Presentation;
use App\Models\PresentationType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialiteUser;
use Tests\TestCase;

class GoogleAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_google_login_redirects_to_google(): void
    {
        Socialite::fake('google');

        $this->get(route('auth.google.redirect'))->assertRedirect();
    }

    public function test_new_google_user_is_created_as_a_student(): void
    {
        $this->fakeGoogleUser('google-123', 'student@example.com', 'Student Name');

        $this->get(route('auth.google.callback'))
            ->assertRedirect(route('home'));

        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'email' => 'student@example.com',
            'google_id' => 'google-123',
            'role' => 'student',
        ]);
    }

    public function test_existing_teacher_keeps_teacher_role_when_linking_google(): void
    {
        User::factory()->create([
            'email' => 'teacher@example.com',
            'role' => 'teacher',
        ]);
        $this->fakeGoogleUser('google-teacher', 'teacher@example.com', 'Teacher Name');

        $this->get(route('auth.google.callback'))
            ->assertRedirect(route('classrooms.index'));

        $this->assertDatabaseHas('users', [
            'email' => 'teacher@example.com',
            'google_id' => 'google-teacher',
            'role' => 'teacher',
        ]);
    }

    public function test_google_student_returns_to_the_evaluation_from_a_qr_link(): void
    {
        $presentation = $this->createPresentation();
        Socialite::fake('google');

        $this->get(route('auth.google.redirect', ['evaluation' => $presentation->token]))
            ->assertRedirect();

        $this->fakeGoogleUser('google-reviewer', 'reviewer@example.com', 'Reviewer');

        $this->get(route('auth.google.callback'))
            ->assertRedirect(route('evaluations.create', $presentation->token))
            ->assertSessionHas("evaluation_reviewers.$presentation->token", 'reviewer@example.com');
    }

    private function fakeGoogleUser(string $id, string $email, string $name): void
    {
        Socialite::fake('google', (new SocialiteUser)->map([
            'id' => $id,
            'email' => $email,
            'name' => $name,
        ]));
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
