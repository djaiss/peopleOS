<?php

declare(strict_types=1);

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use App\Services\AddEmailToWaitlist;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use NjoguAmos\Turnstile\Rules\TurnstileRule;

class WaitlistController extends Controller
{
    public function index(): View
    {
        return view('marketing.waitlist.subscribe');
    }

    public function store(Request $request): View|RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email', 'unique:user_waitlist,email'],
        ]);

        if (config('peopleos.enable_anti_spam')) {
            $validated = $request->validate([
                'token' => ['required', new TurnstileRule()],
            ]);

            if ($validated['token'] !== 'success') {
                return redirect()->back()->withErrors(['token' => 'Invalid captcha']);
            }
        }

        try {
            (new AddEmailToWaitlist(
                email: $request->email,
            ))->execute();
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['email' => $e->getMessage()]);
        }

        return view('marketing.waitlist.waiting');
    }
}
