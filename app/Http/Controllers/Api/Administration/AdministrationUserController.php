<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Administration;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\InviteUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @group Administration
 *
 * @subgroup Manage users
 */
class AdministrationUserController extends Controller
{
    /**
     * Invite a user.
     *
     * Invites a user to the account. Only administrators and HR representatives
     * can invite users.
     *
     * By default, the user will have the Member permission.
     *
     * The invitation will be valid for 3 days. After 3 days, the user will need
     * to request a new invitation.
     *
     * @bodyParam email string required The email of the user. Max 255 characters. Example: dwight.schrute@dundermifflin.com
     *
     * @response 200 {
     *  "id": 4,
     *  "object": "user",
     *  "email": "dwight.schrute@dundermifflin.com"
     * }
     *
     * @responseField id The ID of the user.
     * @responseField object The type of the object. Always "user".
     * @responseField email The email of the user.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255'],
        ]);

        $invitedUser = (new InviteUser(
            user: $request->user(),
            email: $validated['email'],
        ))->execute();

        $response = [
            'id' => $invitedUser->id,
            'object' => 'user',
            'email' => $validated['email'],
        ];

        return response()->json($response);
    }
}
