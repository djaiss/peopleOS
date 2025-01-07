<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Administration;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\SendNewInvitation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @group Administration
 *
 * @subgroup Manage users
 */
class AdministrationInviteUserAgainController extends Controller
{
    /**
     * Send a new invitation to a user.
     *
     * Sends a new invitation to a user who has not yet accepted the invitation.
     * Only administrators and HR representatives can send a new invitation.
     *
     * The invitation will be valid for 3 days. After 3 days, the user will need
     * to request a new invitation.
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
    public function update(Request $request, User $user): JsonResponse
    {
        (new SendNewInvitation(
            user: $request->user(),
            invitedUser: $user,
        ))->execute();

        $response = [
            'id' => $user->id,
            'object' => 'user',
            'email' => $user->email,
        ];

        return response()->json($response);
    }
}
