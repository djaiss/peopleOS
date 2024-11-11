<?php

namespace App\Http\Controllers\Api\Settings;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rule;

/**
 * @group Profile
 *
 * You can modify your profile information here.
 */
class MeController extends Controller
{
    /**
     * Get the information about the logged user.
     *
     * This endpoint gets the information about the logged user.
     *
     * @response 200 {
     *  "id": 4,
     *  "first_name": "Jessica",
     *  "last_name": "Jones",
     *  "email": "jessica.jones@gmail.com"
     * }
     */
    public function show(Request $request): JsonResponse
    {
        $response = [
            'id' => $request->user()->id,
            'first_name' => $request->user()->first_name,
            'last_name' => $request->user()->last_name,
            'email' => $request->user()->email,
        ];

        return response()->json($response);
    }

    /**
     * Update your profile.
     *
     * This lets you update the profile of the logged user. Only the logged user
     * can update their profile. If you change your email, you will need to verify
     * it again.
     *
     * Please note that your password can not be changed through the API at
     * the moment.
     *
     * @bodyParam first_name string required The first name of the user. Max 255 characters. Example: Jessica
     * @bodyParam last_name string required The last name of the user. Max 255 characters. Example: Jones
     * @bodyParam email string required The email of the user. Max 255 characters. Example: jessica.jones@gmail.com
     *
     * @response 200 {
     *  "id": 4,
     *  "first_name": "Jessica",
     *  "last_name": "Jones",
     *  "email": "jessica.jones@gmail.com"
     * }
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($request->user()->id)],
        ]);

        $request->user()->fill($validated);

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
            event(new Registered($request->user()));
        }

        $request->user()->save();

        $response = [
            'id' => $request->user()->id,
            'first_name' => $request->user()->first_name,
            'last_name' => $request->user()->last_name,
            'email' => $request->user()->email,
        ];

        return response()->json($response);
    }
}
