<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Administration;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UpdateAccountInformation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @group Administration
 *
 * You can modify the account information here.
 */
class AccountController extends Controller
{
    /**
     * Get the information about the account the logged user.
     *
     * @response 200 {
     *  "id": 4,
     *  "object": "account",
     *  "name": "Dunder Mifflin Paper Company"
     * }
     *
     * @responseField id The ID of the account.
     * @responseField object The type of the object. Always "account".
     * @responseField name The name of the account.
     */
    public function show(Request $request): JsonResponse
    {
        $response = [
            'id' => $request->user()->account->id,
            'object' => 'account',
            'name' => $request->user()->account->name,
        ];

        return response()->json($response);
    }

    /**
     * Update the account information.
     *
     * This lets you update the account information. Only administrators can
     * change these fields.
     *
     * @bodyParam name string required The name of the account. Max 255 characters. Example: Dunder Mifflin Paper Company
     *
     * @response 200 {
     *  "id": 4,
     *  "object": "account",
     *  "name": "Dunder Mifflin Paper Company"
     * }
     *
     * @responseField id The ID of the user.
     * @responseField object The type of the object. Always "account".
     * @responseField name The name of the account.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        (new UpdateAccountInformation(
            user: $request->user(),
            name: $validated['name'],
        ))->execute();

        $response = [
            'id' => $request->user()->id,
            'object' => 'account',
            'name' => $request->user()->account->name,
        ];

        return response()->json($response);
    }
}
