<?php

namespace App\Http\Controllers\Api\Vaults;

use App\Cache\ContactListCache;
use App\Http\Controllers\Controller;
use App\Http\Resources\ContactCollection;
use App\Http\Resources\ContactResource;
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
     * Creates a new contact in the vault. For this to happen, the user must
     * have the permission to edit the vault.
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
     * @bodyParam can_be_deleted boolean Whether the contact can be deleted. 0 for false, 1 for true. Example: 1
     *
     * @response 201 {
     *  "id": 4,
     *  "object": "contact",
     *  "gender": {
     *   "id": 1,
     *   "object": "gender",
     *   "label": "Male",
     *   "created_at": 1514764800,
     *   "updated_at": 1514764800,
     *  },
     *  "name": "Michael Scott",
     *  "first_name": "Michael",
     *  "last_name": "Scott",
     *  "middle_name": "Gary",
     *  "nickname": "Mike",
     *  "maiden_name": "Johnson",
     *  "prefix": "Mr.",
     *  "suffix": "Jr.",
     *  "can_be_deleted": 1,
     *  "created_at": 1514764800,
     *  "updated_at": 1514764800,
     * }
     *
     * @responseField id Unique identifier for the object.
     * @responseField object The object type. Always "contact".
     * @responseField gender The gender object.
     * @responseField name The display name of the contact.
     * @responseField first_name The first name of the contact.
     * @responseField last_name The last name of the contact.
     * @responseField middle_name The middle name of the contact.
     * @responseField nickname The nickname of the contact.
     * @responseField maiden_name The maiden name of the contact.
     * @responseField prefix The prefix of the contact.
     * @responseField suffix The suffix of the contact.
     * @responseField can_be_deleted Whether the contact can be deleted.
     * @responseField created_at The date the object was created. Represented as a Unix timestamp.
     * @responseField updated_at The date the object was last updated. Represented as a Unix timestamp.
     */
    public function create(Request $request)
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

        return new ContactResource($contact);
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
     * Retrieve a contact.
     *
     * @urlParam vault required The id of the vault. Example: 1
     * @urlParam contact required The id of the contact. Example: 1
     *
     * @response 200 {
     *   "id": 1,
     *   "object": "contact",
     *   "gender": {
     *     "id": 1,
     *     "object": "gender",
     *     "label": "Male",
     *     "created_at": 1514764800,
     *     "updated_at": 1514764800
     *   },
     *   "name": "John Doe",
     *   "first_name": "John",
     *   "last_name": "Doe",
     *   "middle_name": null,
     *   "nickname": null,
     *   "maiden_name": null,
     *   "prefix": null,
     *   "suffix": null,
     *   "can_be_deleted": true,
     *   "created_at": 1514764800,
     *   "updated_at": 1514764800
     * }
     *
     * @responseField id Unique identifier for the contact.
     * @responseField object The object type. Always "contact".
     * @responseField gender The gender of the contact.
     * @responseField name The full name of the contact.
     * @responseField first_name The first name of the contact.
     * @responseField last_name The last name of the contact.
     * @responseField middle_name The middle name of the contact.
     * @responseField nickname The nickname of the contact.
     * @responseField maiden_name The maiden name of the contact.
     * @responseField prefix The prefix of the contact's name.
     * @responseField suffix The suffix of the contact's name.
     * @responseField can_be_deleted Whether the contact can be deleted.
     * @responseField created_at The date the contact was created. Represented as a Unix timestamp.
     * @responseField updated_at The date the contact was last updated. Represented as a Unix timestamp.
     */
    public function show(Request $request)
    {
        $vault = $request->attributes->get('vault');
        $contact = $request->attributes->get('contact');

        return new ContactResource($contact);
    }

    /**
     * List all contacts.
     *
     * This API call returns a paginated collection of contacts that contains
     * 15 items per page.
     *
     * @response 200 {"data": [{
     *  "id": 4,
     *  "object": "contact",
     *  "gender": {
     *   "id": 1,
     *   "object": "gender",
     *   "label": "Male",
     *   "created_at": 1514764800,
     *   "updated_at": 1514764800,
     *  },
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
     *  "gender": {
     *   "id": 1,
     *   "object": "gender",
     *   "label": "Male",
     *   "created_at": 1514764800,
     *   "updated_at": 1514764800,
     *  },
     *  "name": "Dwight Schrute",
     *  "first_name": "Dwight",
     *  "last_name": "Schrute",
     *  "middle_name": "Kurt",
     *  "nickname": "Dwight",
     *  "maiden_name": "Schrute",
     *  "prefix": "Mr.",
     *  "suffix": "Sr.",
     *  "can_be_deleted": 1
     * }],
     * "links": {
     *   "first": "http://peopleos.test/api/vaults/1/contacts?page=1",
     *   "last": "http://peopleos.test/api/vaults/1/contacts?page=1",
     *   "prev": null,
     *   "next": null
     *  },
     *  "meta": {
     *    "current_page": 1,
     *    "from": 1,
     *    "last_page": 1,
     *    "links": [
     *      {
     *        "url": null,
     *        "label": "&laquo; Previous",
     *        "active": false
     *      },
     *      {
     *        "url": "http://peopleos.test/api/vaults/1/contacts?page=1",
     *        "label": "1",
     *        "active": true
     *      },
     *      {
     *        "url": null,
     *        "label": "Next &raquo;",
     *        "active": false
     *      }
     *    ],
     *    "path": "http://peopleos.test/api/vaults/1/contacts",
     *    "per_page": 15,
     *    "to": 1,
     *    "total": 1
     *  }
     *
     * @responseField id Unique identifier for the object.
     * @responseField object The object type. Always "contact".
     * @responseField gender The gender object.
     * @responseField name The display name of the contact.
     * @responseField first_name The first name of the contact.
     * @responseField last_name The last name of the contact.
     * @responseField middle_name The middle name of the contact.
     * @responseField nickname The nickname of the contact.
     * @responseField maiden_name The maiden name of the contact.
     * @responseField prefix The prefix of the contact.
     * @responseField suffix The suffix of the contact.
     * @responseField can_be_deleted Whether the contact can be deleted.
     * @responseField created_at The date the object was created. Represented as a Unix timestamp.
     * @responseField updated_at The date the object was last updated. Represented as a Unix timestamp.
     */
    public function index(Request $request)
    {
        $vault = $request->attributes->get('vault');

        $contacts = $vault->contacts()
            ->with('gender')
            ->paginate();

        return new ContactCollection($contacts);
    }
}
