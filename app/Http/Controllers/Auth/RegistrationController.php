<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Enums\UserWaitlistStatus;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserWaitlist;
use App\Services\CreateAccount;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegistrationController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        if (config('peopleos.enable_anti_spam')) {
            $validated = $request->validate([
                'cf-turnstile-response' => ['required', Rule::turnstile()],
            ]);

            if ($validated['cf-turnstile-response'] !== 'success') {
                return redirect()->back()->withErrors(['cf-turnstile-response' => 'Invalid captcha']);
            }
        }

        if (config('peopleos.enable_waitlist')) {
            try {
                UserWaitlist::where('email', $validated['email'])
                    ->where('status', UserWaitlistStatus::SUBSCRIBED_AND_CONFIRMED->value)
                    ->firstOrFail();
            } catch (Exception) {
                return redirect()->back()->withErrors(['email' => 'You are not part of the beta yet.']);
            }
        }

        $user = (new CreateAccount(
            email: $request->input('email'),
            password: $request->input('password'),
            firstName: $request->input('first_name'),
            lastName: $request->input('last_name'),
        ))->execute();

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard.index', absolute: false));
    }
}
