<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\SendMagicLinkToLogin;
use App\Services\CreateMagicLink;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SendMagicLinkController extends Controller
{
    public function create(): View
    {
        return view('auth.request-magic-link');
    }

    public function store(Request $request): View
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        try {
            $link = (new CreateMagicLink(
                email: $request->input('email'),
            ))->execute();

            SendMagicLinkToLogin::dispatch(
                email: $request->input('email'),
                url: $link,
            )->onQueue('high');
        } catch (ModelNotFoundException) {
        }

        return view('auth.magic-link-sent');
    }
}
