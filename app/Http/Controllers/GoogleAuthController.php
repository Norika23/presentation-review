<?php

namespace App\Http\Controllers;

use App\Models\Presentation;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class GoogleAuthController extends Controller
{
    public function redirect(Request $request): RedirectResponse
    {
        $evaluationToken = $request->string('evaluation')->toString();

        if ($evaluationToken !== '') {
            Presentation::where('token', $evaluationToken)->firstOrFail();
            $request->session()->put('google_evaluation_token', $evaluationToken);
        } else {
            $request->session()->forget('google_evaluation_token');
        }

        return Socialite::driver('google')->redirect();
    }

    public function callback(Request $request): RedirectResponse
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $email = $googleUser->getEmail();

            if (! $email) {
                return $this->failedRedirect($request, 'Your Google account did not provide an email address.');
            }

            $user = DB::transaction(function () use ($googleUser, $email): User {
                $user = User::query()
                    ->where('google_id', $googleUser->getId())
                    ->orWhere('email', $email)
                    ->first();

                if (! $user) {
                    return User::forceCreate([
                        'name' => $googleUser->getName() ?: $email,
                        'email' => $email,
                        'google_id' => $googleUser->getId(),
                        'email_verified_at' => now(),
                        'password' => Str::random(64),
                        'role' => 'student',
                    ]);
                }

                $user->forceFill([
                    'google_id' => $googleUser->getId(),
                    'name' => $googleUser->getName() ?: $user->name,
                    'email_verified_at' => $user->email_verified_at ?: now(),
                ])->save();

                return $user;
            });

            Auth::login($user, true);
            $request->session()->regenerate();

            $evaluationToken = $request->session()->pull('google_evaluation_token');

            if ($evaluationToken && Presentation::where('token', $evaluationToken)->exists()) {
                $request->session()->put("evaluation_reviewers.$evaluationToken", $user->email);

                return redirect()->route('evaluations.create', $evaluationToken);
            }

            return $user->isTeacher()
                ? redirect()->route('classrooms.index')
                : redirect()->route('home');
        } catch (Throwable $exception) {
            report($exception);

            return $this->failedRedirect($request, 'Google login could not be completed. Please try again.');
        }
    }

    private function failedRedirect(Request $request, string $message): RedirectResponse
    {
        $evaluationToken = $request->session()->pull('google_evaluation_token');

        return $evaluationToken
            ? redirect()->route('evaluations.create', $evaluationToken)->withErrors(['google' => $message])
            : redirect()->route('login')->withErrors(['google' => $message]);
    }
}
