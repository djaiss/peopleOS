<?php

declare(strict_types=1);

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use App\Services\AddEmailToWaitlist;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

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
