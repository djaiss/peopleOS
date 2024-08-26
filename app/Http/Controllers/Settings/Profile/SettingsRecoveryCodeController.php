<?php

namespace App\Http\Controllers\Settings\Profile;

use App\Http\Controllers\Controller;
use App\Services\GetTwoFactorAuthenticationSettings;
use Illuminate\Http\Request;

class SettingsRecoveryCodeController extends Controller
{
    public function show(Request $request): string
    {
        $array = (new GetTwoFactorAuthenticationSettings(
            user: auth()->user(),
        ))->execute();

        return view('settings.profile.partials.2fa', [
            'user' => $request->user(),
            'codes' => $array['recovery_codes'],
        ])->fragment('recovery-code-show-state');
    }
}
