<?php

declare(strict_types=1);

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Services\UpdateTimezone;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdministrationTimezoneController extends Controller
{
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'timezone' => ['required', 'string', 'timezone:all'],
        ]);

        (new UpdateTimezone(
            user: Auth::user(),
            timezone: $validated['timezone'],
        ))->execute();

        return redirect()->route('administration.index')
            ->with('status', trans('Changes saved'));
    }
}
