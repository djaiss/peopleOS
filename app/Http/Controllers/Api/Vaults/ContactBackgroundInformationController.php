<?php

namespace App\Http\Controllers\Api\Vaults;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Vault;
use App\Services\UpdateBackgroundInformation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @group Contacts
 */
class ContactBackgroundInformationController extends Controller
{
    /**
     * Update a contact's background information.
     *
     * @urlParam vault required The id of the vault. Example: 1
     * @urlParam contact required The id of the contact. Example: 1
     *
     * @bodyParam information string required The background information about the contact. Can be anything, really. Max 255 characters. Example: CEO
     *
     * @response 200 {
     *  "id": 4,
     *  "object": "contact",
     *  "name": "Michael Scott",
     *  "background_information": "Met him at a conference.",
     * }
     */
    public function update(Request $request): JsonResponse
    {
        $contact = $request->attributes->get('contact');

        $validated = $request->validate([
            'information' => 'required|string|max:255',
        ]);

        (new UpdateBackgroundInformation(
            user: Auth::user(),
            contact: $contact,
            information: $validated['information'],
        ))->execute();

        return response()->json([
            'id' => $contact->id,
            'object' => 'contact',
            'name' => $contact->name,
            'background_information' => $contact->background_information,
        ], 200);
    }
}
