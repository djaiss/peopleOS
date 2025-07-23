<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Enums\TwoFactorType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Jobs\SendFailedLoginEmail;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use App\Services\VerifyTwoFactorCode;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        $quotes = config('quotes');
        $randomQuote = $quotes[array_rand($quotes)];

        return view('auth.login', [
            'quote' => $randomQuote,
        ]);
    }

    /**
     * Display the 2FA challenge form if required.
     *
     * @return View
     */
    public function show2faForm(): View
    {
        if (!session('2fa:user:id')) {
            return view('auth.2fa', [
                'error' => __('Session expired. Please login again.'),
            ]);
        }

        return view('auth.2fa');
    }

    /**
     * Verify the 2FA code and complete login.
     *
     * @return RedirectResponse
     */
    public function verify2fa(Request $request): RedirectResponse
    {
        $request->validate([
            'code' => ['required', 'string'],
        ]);

        $userId = session('2fa:user:id');
        $user = User::find($userId);

        if (!(new VerifyTwoFactorCode(user: $user, code: $request->input('code')))->execute()) {
            return back()->withErrors(['code' => 'Invalid code']);
        }

        Auth::login($user);
        session()->forget('2fa:user:id');
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard.index', absolute: false));
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        if (config('peopleos.enable_anti_spam')) {
            $request->validate([
                'cf-turnstile-response' => ['required', Rule::turnstile()],
            ]);
        }

        try {
            $request->authenticate();
        } catch (ValidationException $e) {
            SendFailedLoginEmail::dispatch($request->input('email'))
                ->onQueue('high');

            return redirect()->back()->withErrors($e->errors());
        }

        if (Auth::user()->two_factor_preferred_method === TwoFactorType::AUTHENTICATOR->value) {
            $userId = Auth::user()->id; // Retrieve the user's ID before logging out
            Auth::logout();
            session(['2fa:user:id' => $userId]); // Use the stored ID to set the session value
            return redirect()->route('2fa.challenge');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard.index', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
