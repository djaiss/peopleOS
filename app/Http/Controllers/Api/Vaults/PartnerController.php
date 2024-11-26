<?php

namespace App\Http\Controllers\Api\Vaults;

use App\Http\Controllers\Controller;
use App\Http\Resources\PartnerCollection;
use App\Http\Resources\PartnerResource;
use App\Models\MaritalStatus;
use App\Models\Partner;
use App\Services\CreatePartner;
use App\Services\DestroyPartner;
use App\Services\UpdatePartner;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @group Contacts
 *
 * @subgroup Partners
 */
class PartnerController extends Controller
{
    /**
     * Create a partner.
     *
     * Creates a new partner for the given contact.
     * A partner has currently three pieces of information: marital status, name
     * and occupation. Only the marital status is required, the name and
     * occupation are optional. A contact can have multiple partners.
     *
     * Once created, the partner will be returned in the response.
     *
     * @urlParam vault required The id of the vault. Example: 1
     * @urlParam contact required The id of the contact. Example: 1
     *
     * @bodyParam marital_status_id int required The id of the marital status. Example: 1
     * @bodyParam name string The name of the partner. Max 255 characters. Example: Michael
     * @bodyParam occupation string The occupation of the partner. Max 255 characters. Example: Software Engineer
     *
     * @response 201 {
     *  "id": 4,
     *  "object": "partner",
     *  "contact": {
     *      "id": 1,
     *      "name": "Dwight Schrute",
     *  },
     *  "marital_status": {
     *      "id": 1,
     *      "name": "Single",
     *  },
     *  "name": "Michael",
     *  "occupation": "Software Engineer",
     *  "created_at": 1514764800,
     *  "updated_at": 1514764800,
     * }
     *
     * @responseField id Unique identifier for the object.
     * @responseField object The object type. Always "partner".
     * @responseField contact The contact object who represents the parent.
     * @responseField marital_status The marital status object of the partner.
     * @responseField name The name of the partner.
     * @responseField occupation The occupation of the partner.
     * @responseField created_at The date the object was created. Represented as a Unix timestamp.
     * @responseField updated_at The date the object was last updated. Represented as a Unix timestamp.
     */
    public function create(Request $request)
    {
        $contact = $request->attributes->get('contact');

        $validated = $request->validate([
            'marital_status_id' => 'required|integer',
            'name' => 'nullable|string|max:255',
            'occupation' => 'nullable|string|max:255',
        ]);

        $partner = (new CreatePartner(
            user: Auth::user(),
            contact: $contact,
            maritalStatus: MaritalStatus::find($validated['marital_status_id']),
            name: $validated['name'],
            occupation: $validated['occupation'],
        ))->execute();

        return new PartnerResource($partner);
    }

    /**
     * Update a partner.
     *
     * Updates an existing partner.
     *
     * Once updated, the partner will be returned in the response.
     *
     * @urlParam vault required The id of the vault. Example: 1
     * @urlParam contact required The id of the contact. Example: 1
     * @urlParam partner required The id of the partner. Example: 1
     *
     * @bodyParam marital_status_id int required The id of the marital status. Example: 1
     * @bodyParam name string The name of the partner. Max 255 characters. Example: Michael
     * @bodyParam occupation string The occupation of the partner. Max 255 characters. Example: Software Engineer
     *
     * @response 200 {
     *  "id": 4,
     *  "object": "partner",
     *  "contact": {
     *      "id": 1,
     *      "name": "Dwight Schrute",
     *  },
     *  "marital_status": {
     *      "id": 1,
     *      "name": "Single",
     *  },
     *  "name": "Michael",
     *  "occupation": "Software Engineer",
     *  "created_at": 1514764800,
     *  "updated_at": 1514764800,
     * }
     *
     * @responseField id Unique identifier for the object.
     * @responseField object The object type. Always "partner".
     * @responseField contact The contact object who represents the parent.
     * @responseField marital_status The marital status object of the partner.
     * @responseField name The name of the partner.
     * @responseField occupation The occupation of the partner.
     * @responseField created_at The date the object was created. Represented as a Unix timestamp.
     * @responseField updated_at The date the object was last updated. Represented as a Unix timestamp.
     */
    public function update(Request $request)
    {
        $contact = $request->attributes->get('contact');
        $partner = $request->route()->parameter('partner');

        $validated = $request->validate([
            'marital_status_id' => 'required|integer',
            'name' => 'nullable|string|max:255',
            'occupation' => 'nullable|string|max:255',
        ]);

        try {
            $partner = Partner::where('contact_id', $contact->id)
                ->findOrFail($partner);
        } catch (ModelNotFoundException) {
            abort(401);
        }

        $partner = (new UpdatePartner(
            user: Auth::user(),
            partner: $partner,
            maritalStatus: MaritalStatus::find($validated['marital_status_id']),
            name: $validated['name'],
            occupation: $validated['occupation'],
        ))->execute();

        return new PartnerResource($partner);
    }

    /**
     * Delete a partner.
     *
     * @urlParam vault required The id of the vault. Example: 1
     * @urlParam contact required The id of the contact. Example: 1
     * @urlParam partner required The id of the partner. Example: 1
     *
     * @response 200 {
     *  "status": "success"
     * }
     */
    public function destroy(Request $request): JsonResponse
    {
        $contact = $request->attributes->get('contact');
        $partner = $request->route()->parameter('partner');

        try {
            $partner = Partner::where('contact_id', $contact->id)
                ->findOrFail($partner);
        } catch (ModelNotFoundException) {
            abort(401);
        }

        (new DestroyPartner(
            user: Auth::user(),
            partner: $partner,
        ))->execute();

        return response()->json([
            'status' => 'success',
        ], 200);
    }

    /**
     * Retrieve a partner.
     *
     * @urlParam vault required The id of the vault. Example: 1
     * @urlParam contact required The id of the contact. Example: 1
     * @urlParam partner required The id of the partner. Example: 1
     *
     * @response 200 {
     *   "id": 1,
     *   "object": "partner",
     *   "contact": {
     *      "id": 1,
     *      "name": "Dwight Schrute",
     *   },
     *   "marital_status": {
     *      "id": 1,
     *      "name": "Single",
     *   },
     *   "name": "John Doe",
     *   "occupation": "Software Engineer",
     *   "created_at": 1514764800,
     *   "updated_at": 1514764800
     * }
     *
     * @responseField id Unique identifier for the object.
     * @responseField object The object type. Always "partner".
     * @responseField contact The contact object who represents the parent.
     * @responseField marital_status The marital status object of the partner.
     * @responseField name The name of the partner.
     * @responseField occupation The occupation of the partner.
     * @responseField created_at The date the object was created. Represented as a Unix timestamp.
     * @responseField updated_at The date the object was last updated. Represented as a Unix timestamp.
     */
    public function show(Request $request)
    {
        $contact = $request->attributes->get('contact');
        $partner = $request->route()->parameter('partner');

        try {
            $partner = Partner::where('contact_id', $contact->id)
                ->with('maritalStatus')
                ->findOrFail($partner);
        } catch (ModelNotFoundException) {
            abort(401);
        }

        return new PartnerResource($partner);
    }

    /**
     * List all partners.
     *
     * This API call returns a paginated collection of partners.
     *
     * @response 200 {"data": [{
     *  "id": 4,
     *  "object": "partner",
     *  "contact": {
     *      "id": 1,
     *      "name": "Dwight Schrute",
     *  },
     *  "marital_status": {
     *      "id": 1,
     *      "name": "Single",
     *  },
     *  "name": "Michael",
     *  "occupation": "Software Engineer",
     *  "created_at": 1514764800,
     *  "updated_at": 1514764800,
     * }, {
     *  "id": 5,
     *  "object": "partner",
     *  "contact": {
     *      "id": 1,
     *      "name": "Dwight Schrute",
     *  },
     *  "marital_status": {
     *      "id": 1,
     *      "name": "Single",
     *  },
     *  "name": "Dwight",
     *  "occupation": "Salesman",
     *  "created_at": 1514764800,
     *  "updated_at": 1514764800,
     * }],
     * "links": {
     *   "first": "http://peopleos.test/api/vaults/1/contacts/1/partners?page=1",
     *   "last": "http://peopleos.test/api/vaults/1/contacts/1/partners?page=1",
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
     *    "path": "http://peopleos.test/api/vaults/1/contacts/1/partners",
     *    "per_page": 15,
     *    "to": 1,
     *    "total": 1
     *  }
     *
     * @responseField id Unique identifier for the object.
     * @responseField object The object type. Always "partner".
     * @responseField contact The contact object who represents the parent.
     * @responseField marital_status The marital status object of the partner.
     * @responseField name The name of the partner.
     * @responseField occupation The occupation of the partner.
     * @responseField created_at The date the object was created. Represented as a Unix timestamp.
     * @responseField updated_at The date the object was last updated. Represented as a Unix timestamp.
     */
    public function index(Request $request)
    {
        $contact = $request->attributes->get('contact');

        $partners = $contact->partners()
            ->with('maritalStatus')
            ->with('contact')
            ->paginate();

        return new PartnerCollection($partners);
    }
}
