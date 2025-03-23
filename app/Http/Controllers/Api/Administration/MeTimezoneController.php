<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Administration;

use App\Http\Controllers\Controller;
use App\Services\UpdateTimezone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class MeTimezoneController extends Controller
{
    /**
     * Get the current user's timezone.
     */
    public function show(Request $request)
    {
        return response()->json(['timezone' => Auth::user()->timezone]);
    }

    /**
     * Update your timezone.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'timezone' => ['required', 'string', 'timezone:all'],
        ]);

        (new UpdateTimezone(
            user: Auth::user(),
            timezone: $validated['timezone'],
        ))->execute();

        $response = [
            'id' => Auth::user()->id,
            'timezone' => Auth::user()->timezone,
        ];

        return response()->json($response);
    }
}
