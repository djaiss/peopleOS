<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Administration;

use App\Http\Controllers\Controller;
use App\Http\Resources\TimezoneResource;
use App\Services\UpdateTimezone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MeTimezoneController extends Controller
{
    /**
     * Get the current user's timezone.
     */
    public function show(): TimezoneResource
    {
        return new TimezoneResource(Auth::user());
    }

    /**
     * Update your timezone.
     */
    public function update(Request $request): TimezoneResource
    {
        $validated = $request->validate([
            'timezone' => ['required', 'string', 'timezone:all'],
        ]);

        (new UpdateTimezone(
            user: Auth::user(),
            timezone: $validated['timezone'],
        ))->execute();

        return new TimezoneResource(Auth::user()->refresh());
    }
}
