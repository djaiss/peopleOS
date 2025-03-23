<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Administration;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UpdateUserInformation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class MeController extends Controller
{
    /**
     * Get the information about the logged user.
     */
    public function show(Request $request): JsonResponse
    {
        $response = [
            'id' => Auth::user()->id,
            'first_name' => Auth::user()->first_name,
            'last_name' => Auth::user()->last_name,
            'nickname' => Auth::user()->nickname,
            'email' => Auth::user()->email,
            'born_at' => Auth::user()->born_at?->timestamp,
        ];

        return response()->json($response);
    }

    /**
     * Update your profile.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore(Auth::user()->id)],
            'nickname' => ['nullable', 'string', 'max:255'],
            'born_at' => ['nullable', 'date'],
        ]);

        (new UpdateUserInformation(
            user: Auth::user(),
            email: $validated['email'],
            firstName: $validated['first_name'],
            lastName: $validated['last_name'],
            nickname: $validated['nickname'] ?? null,
            bornAt: $validated['born_at'] ?? null,
        ))->execute();

        $response = [
            'id' => Auth::user()->id,
            'first_name' => Auth::user()->first_name,
            'last_name' => Auth::user()->last_name,
            'email' => Auth::user()->email,
            'nickname' => Auth::user()->nickname,
            'born_at' => Auth::user()->born_at?->timestamp,
        ];

        return response()->json($response);
    }
}
