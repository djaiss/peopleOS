<?php

namespace App\Http\Controllers\Settings\Profile;

use App\Http\Controllers\Controller;
use App\Services\DisableTwoFactorAuthentication;
use App\Services\GetTwoFactorAuthenticationSettings;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use PragmaRX\Google2FA\Google2FA;

class Settings2FAController extends Controller
{
    public function show(Request $request): string
    {
        return view('settings.profile.partials.2fa', [
            'user' => $request->user(),
        ])->fragment('2fa-show-state');
    }

    public function new(): View
    {
        $array = (new GetTwoFactorAuthenticationSettings(
            user: auth()->user(),
        ))->execute();

        return view('settings.profile.partials.2fa_new', [
            'qrcode_image' => $array['svg_qr_code'],
        ]);
    }

    public function store(Request $request): string|JsonResponse
    {
        $validated = $request->validateWithBag('validate2FA', [
            'code_verification' => ['required', 'string'],
        ]);

        $google2fa = new Google2FA;
        $secret = decrypt(auth()->user()->two_factor_secret);
        $valid = $google2fa->verifyKey($secret, $validated['code_verification']);

        if (! $valid) {
            return response()->json(['message' => 'The code is not valid.'], 400);
        }

        auth()->user()->two_factor_confirmed_at = now();
        auth()->user()->save();

        return view('settings.profile.partials.2fa', [
            'user' => $request->user(),
        ])->fragment('2fa-show-state');
    }

    public function destroy(): string
    {
        $user = (new DisableTwoFactorAuthentication(
            user: auth()->user(),
        ))->execute();

        return view('settings.profile.partials.2fa', [
            'user' => $user,
        ])->fragment('2fa-show-state');
    }
}
