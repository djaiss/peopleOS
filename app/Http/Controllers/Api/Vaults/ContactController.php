<?php

namespace App\Http\Controllers\Api\Vaults;

use App\Cache\ContactListCache;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Gender;
use App\Models\Vault;
use App\Services\CreateContact;
use App\Services\DestroyContact;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @group Contacts
 */
class ContactController extends Controller
{
    /**
     * Create a contact.
     *
     * This will create a new contact in the vault. To be able to create a
     * contact, the user must have the permission to edit the vault.
     *
     * You can choose to mark a contact as deletable or not.
     *
     * Once created, the contact will be returned in the response, as well as
     * the display name of the contact. This name's format depends on the user
     * settings.
     *
     * @urlParam vault required The id of the vault. Example: 1
     *
     * @bodyParam gender_id integer required The gender object associated with the contact. This object must be a valid Gender object. Example: 1
     * @bodyParam first_name string required The first name of the contact. Max 255 characters. Example: Michael
     * @bodyParam last_name string required The last name of the contact. Max 255 characters. Example: Scott
     * @bodyParam middle_name string The middle name of the contact. Max 255 characters. Example: Gary
     * @bodyParam nickname string The nickname of the contact. Max 255 characters. Example: Mike
     * @bodyParam maiden_name string The maiden name of the contact. Max 255 characters. Example: Johnson
     * @bodyParam prefix string The prefix of the contact. Max 255 characters. Example: Mr.
     * @bodyParam suffix string The suffix of the contact. Max 255 characters. Example: Jr.
     * @bodyParam can_be_deleted boolean Whether the contact can be deleted. Example: 1
     *
     * @response 201 {
     *  "id": 4,
     *  "object": "contact",
     *  "name": "Michael Scott",
     *  "first_name": "Michael",
     *  "last_name": "Scott",
     *  "middle_name": "Gary",
     *  "nickname": "Mike",
     *  "maiden_name": "Johnson",
     *  "prefix": "Mr.",
     *  "suffix": "Jr.",
     *  "can_be_deleted": 1
     * }
     */
    public function create(Request $request): JsonResponse
    {
        $vault = $request->attributes->get('vault');

        $validated = $request->validate([
            'gender_id' => 'required|exists:genders,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'nickname' => 'nullable|string|max:255',
            'maiden_name' => 'nullable|string|max:255',
            'prefix' => 'nullable|string|max:255',
            'suffix' => 'nullable|string|max:255',
            'can_be_deleted' => 'boolean',
        ]);

        $contact = (new CreateContact(
            user: auth()->user(),
            vault: $vault,
            gender: Gender::find($validated['gender_id']),
            firstName: $validated['first_name'],
            lastName: $validated['last_name'],
            middleName: $validated['middle_name'],
            nickname: $validated['nickname'],
            maidenName: $validated['maiden_name'],
            prefix: $validated['prefix'],
            suffix: $validated['suffix'],
            canBeDeleted: $validated['can_be_deleted'],
        ))->execute();

        ContactListCache::make(
            user: auth()->user(),
            vault: $request->attributes->get('vault'),
        )->refresh();

        return response()->json([
            'id' => $contact->id,
            'object' => 'contact',
            'name' => $contact->name,
            'first_name' => $contact->first_name,
            'last_name' => $contact->last_name,
            'middle_name' => $contact->middle_name,
            'nickname' => $contact->nickname,
            'maiden_name' => $contact->maiden_name,
            'prefix' => $contact->prefix,
            'suffix' => $contact->suffix,
            'can_be_deleted' => $contact->can_be_deleted,
        ], 201);
    }

    /**
     * Delete a contact.
     *
     * @urlParam vault required The id of the vault. Example: 1
     * @urlParam contact required The id of the contact. Example: 1
     *
     * @response 200 {
     *  "status": "success"
     * }
     */
    public function destroy(Request $request): JsonResponse
    {
        $vault = $request->attributes->get('vault');
        $contact = $request->attributes->get('contact');

        (new DestroyContact(
            user: auth()->user(),
            vault: $vault,
            contact: $contact,
        ))->execute();

        ContactListCache::make(
            user: auth()->user(),
            vault: $request->attributes->get('vault'),
        )->refresh();

        return response()->json([
            'status' => 'success',
        ], 200);
    }

    /**
     * List all contacts.
     *
     * This will list all the contacts, sorted alphabetically.
     *
     * @response 200 [{
     *  "id": 4,
     *  "object": "contact",
     *  "name": "Michael Scott",
     *  "first_name": "Michael",
     *  "last_name": "Scott",
     *  "middle_name": "Gary",
     *  "nickname": "Mike",
     *  "maiden_name": "Johnson",
     *  "prefix": "Mr.",
     *  "suffix": "Jr.",
     *  "can_be_deleted": 1
     * }, {
     *  "id": 5
     *  "object": "contact",
     *  "name": "Dwight Schrute",
     *  "first_name": "Dwight",
     *  "last_name": "Schrute",
     *  "middle_name": "Kurt",
     *  "nickname": "Dwight",
     *  "maiden_name": "Schrute",
     *  "prefix": "Mr.",
     *  "suffix": "Sr.",
     *  "can_be_deleted": 1
     * }]
     */
    public function index(Request $request): JsonResponse
    {
        $vault = $request->attributes->get('vault');

        $contacts = $vault->contacts()
            ->get()
            ->map(fn (Contact $contact) => [
                'id' => $contact->id,
                'object' => 'contact',
                'name' => $contact->name,
                'first_name' => $contact->first_name,
                'last_name' => $contact->last_name,
                'middle_name' => $contact->middle_name,
                'nickname' => $contact->nickname,
                'maiden_name' => $contact->maiden_name,
                'prefix' => $contact->prefix,
                'suffix' => $contact->suffix,
                'can_be_deleted' => $contact->can_be_deleted,
            ])
            ->sortBy('name')
            ->values();

        return response()->json($contacts, 200);
    }
}
