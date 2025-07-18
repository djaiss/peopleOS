<?php

declare(strict_types=1);

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Services\Update2faMethod;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdministrationPreferred2FAController extends Controller
{
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'method' => 'required|string|min:3|max:255',
        ]);

        (new Update2faMethod(
            user: Auth::user(),
            preferredMethods: $validated['method'],
        ))->execute();

        return redirect()->route('administration.security.index')
            ->with('status', trans('Changes saved'));
    }
}
