<?php

namespace App\Http\Controllers\Api\Vaults;

use App\Http\Controllers\Controller;
use App\Http\Resources\ContactCollection;
use App\Http\Resources\ContactResource;
use App\Models\Ethnicity;
use App\Models\Gender;
use App\Models\MaritalStatus;
use App\Services\CreateContact;
use App\Services\DestroyContact;
use App\Services\UpdateContact;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @group Contacts
 *
 * @subgroup Contacts
 */
class ContactController extends Controller
{
    /**
     * Create a contact.
     *
     * Creates a new contact in the vault.
     *
     * You can choose to mark a contact as deletable or not.
     *
     * Once created, the contact will be returned in the response, as well as
     * the display name of the contact. This name's format depends on the user
     * settings.
     *
     * @urlParam vault required The id of the vault. Example: 1
     *
     * @bodyParam gender_id integer The gender object associated with the contact. This object must be a valid Gender object. Example: 1
     * @bodyParam ethnicity_id integer The ethnicity object associated with the contact. This object must be a valid Ethnicity object. Example: 1
     * @bodyParam marital_status_id integer The marital status of the contact. This object must be a valid MaritalStatus object. Example: 1
     * @bodyParam first_name string required The first name of the contact. Max 255 characters. Example: Michael
     * @bodyParam last_name string The last name of the contact. Max 255 characters. Example: Scott
     * @bodyParam middle_name string The middle name of the contact. Max 255 characters. Example: Gary
     * @bodyParam nickname string The nickname of the contact. Max 255 characters. Example: Mike
     * @bodyParam maiden_name string The maiden name of the contact, important in some cultures, where a woman’s surname changes after marriage. Max 255 characters. Example: Johnson
     * @bodyParam patronymic_name string The patronymic name of the contact, which is the name derived from a parent’s name (common in Icelandic, Russian, and some Arabic cultures). Max 255 characters. Example: Einarsdóttir
     * @bodyParam tribal_name string The tribal name of the contact, used in various African and Indigenous cultures (e.g., Zulu clan names). Max 255 characters. Example: Zulu
     * @bodyParam generation_name string The generation name of the contact, often used in Japanese, Chinese, Korean, and Vietnamese culture where part of the name is shared by siblings or cousins to signify their generation. Max 255 characters. Example: 俊
     * @bodyParam romanized_name string The romanized name of the contact, which is the Latin alphabet transliteration of a non-Latin name. Max 255 characters. Example: Wang Junjie
     * @bodyParam nationality string The nationality of the contact. Max 255 characters. Example: American
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
     *  "ethnicity": {
     *   "id": 1,
     *   "object": "ethnicity",
     *   "label": "Asian",
     *   "created_at": 1514764800,
     *   "updated_at": 1514764800,
     *  },
     *  "name": "Michael Scott",
     *  "first_name": "Michael",
     *  "last_name": "Scott",
     *  "middle_name": "Gary",
     *  "nickname": "Mike",
     *  "maiden_name": "Johnson",
     *  "patronymic_name": "Einarsdóttir",
     *  "tribal_name": "Zulu",
     *  "generation_name": "俊",
     *  "romanized_name": "Wang Junjie",
     *  "nationality": "American",
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
     * @responseField ethnicity The ethnicity object.
     * @responseField marital_status The marital status object.
     * @responseField name The display name of the contact.
     * @responseField first_name The first name of the contact.
     * @responseField last_name The last name of the contact.
     * @responseField middle_name The middle name of the contact.
     * @responseField nickname The nickname of the contact.
     * @responseField maiden_name The maiden name of the contact.
     * @responseField patronymic_name The patronymic name of the contact.
     * @responseField tribal_name The tribal name of the contact.
     * @responseField generation_name The generation name of the contact.
     * @responseField romanized_name The romanized name of the contact.
     * @responseField nationality The nationality of the contact.
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
            'gender_id' => 'nullable|exists:genders,id',
            'ethnicity_id' => 'nullable|exists:ethnicities,id',
            'marital_status_id' => 'nullable|exists:marital_statuses,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'nickname' => 'nullable|string|max:255',
            'maiden_name' => 'nullable|string|max:255',
            'patronymic_name' => 'nullable|string|max:255',
            'tribal_name' => 'nullable|string|max:255',
            'generation_name' => 'nullable|string|max:255',
            'romanized_name' => 'nullable|string|max:255',
            'nationality' => 'nullable|string|max:255',
            'prefix' => 'nullable|string|max:255',
            'suffix' => 'nullable|string|max:255',
            'can_be_deleted' => 'boolean',
        ]);

        $contact = (new CreateContact(
            user: Auth::user(),
            vault: $vault,
            gender: $validated['gender_id'] ? Gender::find($validated['gender_id']) : null,
            ethnicity: $validated['ethnicity_id'] ? Ethnicity::find($validated['ethnicity_id']) : null,
            maritalStatus: $validated['marital_status_id'] ? MaritalStatus::find($validated['marital_status_id']) : null,
            firstName: $validated['first_name'],
            lastName: $validated['last_name'],
            middleName: $validated['middle_name'],
            nickname: $validated['nickname'],
            maidenName: $validated['maiden_name'],
            patronymicName: $validated['patronymic_name'],
            tribalName: $validated['tribal_name'],
            generationName: $validated['generation_name'],
            romanizedName: $validated['romanized_name'],
            nationality: $validated['nationality'],
            prefix: $validated['prefix'],
            suffix: $validated['suffix'],
            canBeDeleted: $validated['can_be_deleted'],
        ))->execute();

        return new ContactResource($contact);
    }

    /**
     * Update a contact.
     *
     * Updates an existing contact.
     *
     * You can choose to mark a contact as deletable or not.
     *
     * You can't edit the marital status with this method. Use the partner
     * endpoint to update the marital status.
     *
     * Once updated, the contact will be returned in the response, as well as
     * the display name of the contact. This name's format depends on the user
     * settings.
     *
     * @urlParam vault required The id of the vault. Example: 1
     * @urlParam contact required The id of the contact. Example: 1
     *
     * @bodyParam gender_id integer The gender object associated with the contact. This object must be a valid Gender object. Example: 1
     * @bodyParam ethnicity_id integer The ethnicity object associated with the contact. This object must be a valid Ethnicity object. Example: 1
     * @bodyParam first_name string required The first name of the contact. Max 255 characters. Example: Michael
     * @bodyParam last_name string The last name of the contact. Max 255 characters. Example: Scott
     * @bodyParam middle_name string The middle name of the contact. Max 255 characters. Example: Gary
     * @bodyParam nickname string The nickname of the contact. Max 255 characters. Example: Mike
     * @bodyParam maiden_name string The maiden name of the contact, important in some cultures, where a woman’s surname changes after marriage. Max 255 characters. Example: Johnson
     * @bodyParam patronymic_name string The patronymic name of the contact, which is the name derived from a parent’s name (common in Icelandic, Russian, and some Arabic cultures). Max 255 characters. Example: Einarsdóttir
     * @bodyParam tribal_name string The tribal name of the contact, used in various African and Indigenous cultures (e.g., Zulu clan names). Max 255 characters. Example: Zulu
     * @bodyParam generation_name string The generation name of the contact, often used in Japanese, Chinese, Korean, and Vietnamese culture where part of the name is shared by siblings or cousins to signify their generation. Max 255 characters. Example: 俊
     * @bodyParam romanized_name string The romanized name of the contact, which is the Latin alphabet transliteration of a non-Latin name. Max 255 characters. Example: Wang Junjie
     * @bodyParam nationality string The nationality of the contact. Max 255 characters. Example: American
     * @bodyParam prefix string The prefix of the contact. Max 255 characters. Example: Mr.
     * @bodyParam suffix string The suffix of the contact. Max 255 characters. Example: Jr.
     * @bodyParam can_be_deleted boolean Whether the contact can be deleted. 0 for false, 1 for true. Example: 1
     *
     * @response 200 {
     *  "id": 4,
     *  "object": "contact",
     *  "gender": {
     *   "id": 1,
     *   "object": "gender",
     *   "label": "Male",
     *   "created_at": 1514764800,
     *   "updated_at": 1514764800,
     *  },
     *  "ethnicity": {
     *   "id": 1,
     *   "object": "ethnicity",
     *   "label": "Asian",
     *   "created_at": 1514764800,
     *   "updated_at": 1514764800,
     *  },
     *  "name": "Michael Scott",
     *  "first_name": "Michael",
     *  "last_name": "Scott",
     *  "middle_name": "Gary",
     *  "nickname": "Mike",
     *  "maiden_name": "Johnson",
     *  "patronymic_name": "Einarsdóttir",
     *  "tribal_name": "Zulu",
     *  "generation_name": "俊",
     *  "romanized_name": "Wang Junjie",
     *  "nationality": "American",
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
     * @responseField ethnicity The ethnicity object.
     * @responseField name The display name of the contact.
     * @responseField first_name The first name of the contact.
     * @responseField last_name The last name of the contact.
     * @responseField middle_name The middle name of the contact.
     * @responseField nickname The nickname of the contact.
     * @responseField maiden_name The maiden name of the contact.
     * @responseField patronymic_name The patronymic name of the contact.
     * @responseField tribal_name The tribal name of the contact.
     * @responseField generation_name The generation name of the contact.
     * @responseField romanized_name The romanized name of the contact.
     * @responseField nationality The nationality of the contact.
     * @responseField prefix The prefix of the contact.
     * @responseField suffix The suffix of the contact.
     * @responseField can_be_deleted Whether the contact can be deleted.
     * @responseField created_at The date the object was created. Represented as a Unix timestamp.
     * @responseField updated_at The date the object was last updated. Represented as a Unix timestamp.
     */
    public function update(Request $request)
    {
        $vault = $request->attributes->get('vault');
        $contact = $request->attributes->get('contact');

        $validated = $request->validate([
            'gender_id' => 'nullable|exists:genders,id',
            'ethnicity_id' => 'nullable|exists:ethnicities,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'nickname' => 'nullable|string|max:255',
            'maiden_name' => 'nullable|string|max:255',
            'patronymic_name' => 'nullable|string|max:255',
            'tribal_name' => 'nullable|string|max:255',
            'generation_name' => 'nullable|string|max:255',
            'romanized_name' => 'nullable|string|max:255',
            'nationality' => 'nullable|string|max:255',
            'prefix' => 'nullable|string|max:255',
            'suffix' => 'nullable|string|max:255',
            'can_be_deleted' => 'boolean',
        ]);

        $contact = (new UpdateContact(
            user: Auth::user(),
            contact: $contact,
            gender: $validated['gender_id'] ? Gender::find($validated['gender_id']) : null,
            ethnicity: $validated['ethnicity_id'] ? Ethnicity::find($validated['ethnicity_id']) : null,
            firstName: $validated['first_name'],
            lastName: $validated['last_name'],
            middleName: $validated['middle_name'],
            nickname: $validated['nickname'],
            maidenName: $validated['maiden_name'],
            patronymicName: $validated['patronymic_name'],
            tribalName: $validated['tribal_name'],
            generationName: $validated['generation_name'],
            romanizedName: $validated['romanized_name'],
            nationality: $validated['nationality'],
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
            user: Auth::user(),
            vault: $vault,
            contact: $contact,
        ))->execute();

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
     *   "ethnicity": {
     *     "id": 1,
     *     "object": "ethnicity",
     *     "label": "Asian",
     *     "created_at": 1514764800,
     *     "updated_at": 1514764800
     *   },
     *   "name": "John Doe",
     *   "first_name": "John",
     *   "last_name": "Doe",
     *   "middle_name": null,
     *   "nickname": null,
     *   "maiden_name": null,
     *   "patronymic_name": null,
     *   "tribal_name": null,
     *   "generation_name": null,
     *   "romanized_name": null,
     *   "nationality": "American",
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
     * @responseField ethnicity The ethnicity of the contact.
     * @responseField name The full name of the contact.
     * @responseField first_name The first name of the contact.
     * @responseField last_name The last name of the contact.
     * @responseField middle_name The middle name of the contact.
     * @responseField nickname The nickname of the contact.
     * @responseField maiden_name The maiden name of the contact.
     * @responseField patronymic_name The patronymic name of the contact.
     * @responseField tribal_name The tribal name of the contact.
     * @responseField generation_name The generation name of the contact.
     * @responseField romanized_name The romanized name of the contact.
     * @responseField nationality The nationality of the contact.
     * @responseField prefix The prefix of the contact's name.
     * @responseField suffix The suffix of the contact's name.
     * @responseField can_be_deleted Whether the contact can be deleted.
     * @responseField created_at The date the contact was created. Represented as a Unix timestamp.
     * @responseField updated_at The date the contact was last updated. Represented as a Unix timestamp.
     */
    public function show(Request $request)
    {
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
     *  "ethnicity": {
     *   "id": 1,
     *   "object": "ethnicity",
     *   "label": "Asian",
     *   "created_at": 1514764800,
     *   "updated_at": 1514764800
     *  },
     *  "name": "Michael Scott",
     *  "first_name": "Michael",
     *  "last_name": "Scott",
     *  "middle_name": "Gary",
     *  "nickname": "Mike",
     *  "maiden_name": "Johnson",
     *  "patronymic_name": null,
     *  "tribal_name": null,
     *  "generation_name": null,
     *  "romanized_name": null,
     *  "nationality": "American",
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
     *  "ethnicity": {
     *   "id": 1,
     *   "object": "ethnicity",
     *   "label": "Asian",
     *   "created_at": 1514764800,
     *   "updated_at": 1514764800
     *  },
     *  "name": "Dwight Schrute",
     *  "first_name": "Dwight",
     *  "last_name": "Schrute",
     *  "middle_name": "Kurt",
     *  "nickname": "Dwight",
     *  "maiden_name": "Schrute",
     *  "patronymic_name": null,
     *  "tribal_name": null,
     *  "generation_name": null,
     *  "romanized_name": null,
     *  "nationality": "American",
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
     * @responseField ethnicity The ethnicity object.
     * @responseField name The display name of the contact.
     * @responseField first_name The first name of the contact.
     * @responseField last_name The last name of the contact.
     * @responseField middle_name The middle name of the contact.
     * @responseField nickname The nickname of the contact.
     * @responseField maiden_name The maiden name of the contact.
     * @responseField patronymic_name The patronymic name of the contact.
     * @responseField tribal_name The tribal name of the contact.
     * @responseField generation_name The generation name of the contact.
     * @responseField romanized_name The romanized name of the contact.
     * @responseField nationality The nationality of the contact.
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
            ->with('ethnicity')
            ->paginate();

        return new ContactCollection($contacts);
    }
}
