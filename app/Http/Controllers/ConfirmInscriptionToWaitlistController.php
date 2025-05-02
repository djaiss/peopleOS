<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\ValidateConfirmationCodeToWaitlist;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ConfirmInscriptionToWaitlistController extends Controller
{
    public function show(Request $request): View|RedirectResponse
    {
        $code = (string) $request->route()->parameter('code');

        if (! $request->hasValidSignature()) {
            abort(401);
        }

        try {
            (new ValidateConfirmationCodeToWaitlist(
                code: $code,
            ))->execute();
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['content' => $e->getMessage()]);
        }

        return view('auth.register');
    }
}
