<?php

declare(strict_types=1);

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Services\Generate2faQRCode;
use App\Services\Validate2faQRCode;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use PragmaRX\Google2FALaravel\Google2FA;
use Illuminate\Http\Request;

class Administration2faController extends Controller
{
    public function new(): View
    {
        $code = (new Generate2faQRCode(
            user: Auth::user(),
        ))->execute();

        return view('administration.security.partials.2fa-new', [
            'secret' => $code['secret'],
            'qrCodeSvg' => $code['qrCodeSvg'],
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'token' => 'required|numeric|digits:6',
        ]);

        (new Validate2faQRCode(
            user: Auth::user(),
            token: (string) $request->input('token'),
        ))->execute();

        return redirect()->route('administration.security.index')
            ->with('status', __('Two-factor authentication has been enabled successfully.'));
    }
}
