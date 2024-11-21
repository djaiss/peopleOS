<?php

namespace App\Http\Controllers\Api\Vaults;

use App\Http\Controllers\Controller;
use App\Http\Resources\ContactPhoneNumberCollection;
use App\Http\Resources\ContactPhoneNumberResource;
use App\Models\Contact;
use App\Models\ContactPhoneNumber;
use App\Models\Vault;
use App\Services\CreateContactPhoneNumber;
use App\Services\DestroyContactPhoneNumber;
use App\Services\UpdateContactPhoneNumber;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @group Contacts
 *
 * @subgroup Phone Numbers
 */
class ContactPhoneNumberController extends Controller
{
    /**
     * Create a contact phone number.
     *
     * A contact can have multiple phone numbers, as many as needed. This
     * number can be a mobile, home, work, fax, etc.
     *
     * @urlParam vault required The id of the vault. Example: 1
     * @urlParam contact required The id of the contact. Example: 1
     *
     * @bodyParam label string required The label of the phone number. The current supported labels are mobile, home, work, fax and other.
     * @bodyParam phone_number string required The phone number. Max 255 characters. Example: +1234567890
     *
     * @response 200 {
     *  "id": 4,
     *  "object": "contact_phone_number",
     *  "contact": {
     *     "id": 1,
     *     "name": "Michael Scott"
     *  },
     *  "label": "mobile",
     *  "phone_number": "+1234567890",
     *  "created_at": 1724320000,
     *  "updated_at": 1724320000
     * }
     */
    public function create(Request $request)
    {
        $contact = $request->attributes->get('contact');

        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'phone_number' => 'required|string|max:255',
        ]);

        $contactPhoneNumber = (new CreateContactPhoneNumber(
            user: Auth::user(),
            contact: $contact,
            label: $validated['label'],
            phoneNumber: $validated['phone_number'],
        ))->execute();

        return new ContactPhoneNumberResource($contactPhoneNumber);
    }

    /**
     * Update a contact phone number.
     *
     * @urlParam vault required The id of the vault. Example: 1
     * @urlParam contact required The id of the contact. Example: 1
     * @urlParam contactPhoneNumber required The id of the contact phone number. Example: 1
     *
     * @bodyParam label string required The label of the phone number. The current supported labels are mobile, home, work, fax and other.
     * @bodyParam phone_number string required The phone number. Max 255 characters. Example: +1234567890
     *
     * @response 200 {
     *  "id": 4,
     *  "object": "contact_phone_number",
     *  "contact": {
     *     "id": 1,
     *     "name": "Michael Scott"
     *  },
     *  "label": "mobile",
     *  "phone_number": "+1234567890",
     *  "created_at": 1724320000,
     *  "updated_at": 1724320000
     * }
     */
    public function update(Request $request)
    {
        $contact = $request->attributes->get('contact');
        $id = $request->route()->parameter('contactPhoneNumber');

        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'phone_number' => 'required|string|max:255',
        ]);

        try {
            $contactPhoneNumber = ContactPhoneNumber::where('contact_id', $contact->id)
                ->findOrFail($id);
        } catch (ModelNotFoundException) {
            abort(401);
        }

        $contactPhoneNumber = (new UpdateContactPhoneNumber(
            user: Auth::user(),
            contactPhoneNumber: $contactPhoneNumber,
            label: $validated['label'],
            phoneNumber: $validated['phone_number'],
        ))->execute();

        return new ContactPhoneNumberResource($contactPhoneNumber);
    }

    /**
     * Delete a contact phone number.
     *
     * @urlParam contact required The id of the contact. Example: 1
     * @urlParam contactPhoneNumber required The id of the contact phone number. Example: 1
     *
     * @response 200 {
     *  "status": "success"
     * }
     */
    public function destroy(Request $request)
    {
        $contact = $request->attributes->get('contact');
        $id = $request->route()->parameter('contactPhoneNumber');

        try {
            $contactPhoneNumber = ContactPhoneNumber::where('contact_id', $contact->id)
                ->findOrFail($id);
        } catch (ModelNotFoundException) {
            abort(401);
        }

        (new DestroyContactPhoneNumber(
            user: Auth::user(),
            contactPhoneNumber: $contactPhoneNumber,
        ))->execute();

        return response()->json([
            'status' => 'success',
        ], 200);
    }

    /**
     * List all phone numbers of a contact.
     *
     * This API call returns a paginated collection of phone numbers that contains
     * 15 items per page.
     *
     * @response 200 {"data": [{
     *  "id": 4,
     *  "object": "contact_phone_number",
     *  "contact": {
     *   "id": 1,
     *   "name": "Michael Scott"
     *  },
     *  "label": "mobile",
     *  "phone_number": "+1234567890",
     *  "created_at": 1514764800,
     *  "updated_at": 1514764800
     * }],
     * }, {
     *  "id": 5
     *  "object": "contact_phone_number",
     *  "contact": {
     *   "id": 1,
     *   "name": "Michael Scott"
     *  },
     *  "label": "mobile",
     *  "phone_number": "+1234567890",
     *  "created_at": 1514764800,
     *  "updated_at": 1514764800
     *  },
     * }],
     * "links": {
     *   "first": "http://peopleos.test/api/vaults/1/contacts/phone-numbers?page=1",
     *   "last": "http://peopleos.test/api/vaults/1/contacts/phone-numbers?page=1",
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
     *        "url": "http://peopleos.test/api/vaults/1/contacts/phone-numbers?page=1",
     *        "label": "1",
     *        "active": true
     *      },
     *      {
     *        "url": null,
     *        "label": "Next &raquo;",
     *        "active": false
     *      }
     *    ],
     *    "path": "http://peopleos.test/api/vaults/1/contacts/phone-numbers",
     *    "per_page": 15,
     *    "to": 1,
     *    "total": 1
     *  }
     *
     * @responseField id Unique identifier for the object.
     * @responseField object The object type. Always "contact_phone_number".
     * @responseField contact The contact object.
     * @responseField label The label of the phone number.
     * @responseField phone_number The phone number.
     * @responseField created_at The date the object was created. Represented as a Unix timestamp.
     * @responseField updated_at The date the object was last updated. Represented as a Unix timestamp.
     */
    public function index(Request $request)
    {
        $contact = $request->attributes->get('contact');

        $contactPhoneNumbers = $contact->contactPhoneNumbers()
            ->with('contact')
            ->paginate();

        return new ContactPhoneNumberCollection($contactPhoneNumbers);
    }
}
