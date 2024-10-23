<?php

namespace App\Http\Controllers\Api\Vaults;

use App\Http\Controllers\Controller;
use App\Http\Resources\ContactPhoneNumberResource;
use App\Models\Contact;
use App\Models\Vault;
use App\Services\CreateContactPhoneNumber;
use Illuminate\Http\Request;

/**
 * @group Contacts
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
            user: auth()->user(),
            contact: $contact,
            label: $validated['label'],
            phoneNumber: $validated['phone_number'],
        ))->execute();

        return new ContactPhoneNumberResource($contactPhoneNumber);
    }
}
