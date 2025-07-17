<?php

declare(strict_types=1);

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdministrationSecurityRecoveryCodeController extends Controller
{
    public function show(): View
    {
        $recoveryCodes = Auth::user()->two_factor_recovery_codes ?? [];

        return view('administration.security.partials.2fa-recovery-codes', [
            'recoveryCodes' => collect($recoveryCodes),
        ]);
    }
}
