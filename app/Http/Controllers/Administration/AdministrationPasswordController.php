<?php

declare(strict_types=1);

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Services\UpdateUserPassword;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdministrationPasswordController extends Controller
{
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        (new UpdateUserPassword(
            user: Auth::user(),
            currentPassword: $validated['current_password'],
            newPassword: $validated['new_password'],
        ))->execute();

        return redirect()->route('administration.security.index')
            ->with('status', trans('Password updated successfully'));
    }
}
