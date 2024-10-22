<?php

namespace App\Http\Controllers\Api\Settings;

use App\Http\Controllers\Controller;
use App\Http\Resources\EthnicityCollection;
use App\Http\Resources\EthnicityResource;
use App\Models\Ethnicity;
use App\Services\CreateEthnicity;
use App\Services\DestroyEthnicity;
use App\Services\UpdateEthnicity;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @group Ethnicities
 *
 * Ethnicity refers to a person's identification with a group based on
 * common ancestry, language, cultural heritage, or national origin.
 *
 * Ethnicities are defined at the account level and shared by all users in the
 * account. If you delete an ethnicity it will be removed from all the contacts
 * that are using it.
 */
class EthnicityController extends Controller
{
    /**
     * Create an ethnicity.
     *
     * @bodyParam label string required The name of the ethnicity. Max 255 characters. Example: Hispanic
     *
     * @response 201 {
     *  "id": 1,
     *  "object": "ethnicity",
     *  "label": "Hispanic",
     *  "created_at": 1514764800,
     *  "updated_at": 1514764800,
     * }
     *
     * @responseField id Unique identifier for the object.
     * @responseField object The object type. Always "ethnicity".
     * @responseField label The label of the ethnicity.
     * @responseField created_at The date the object was created. Represented as a Unix timestamp.
     * @responseField updated_at The date the object was last updated. Represented as a Unix timestamp.
     */
    public function create(Request $request)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
        ]);

        $ethnicity = (new CreateEthnicity(
            user: auth()->user(),
            label: $validated['label'],
        ))->execute();

        return new EthnicityResource($ethnicity);
    }

    /**
     * Update an ethnicity.
     *
     * @urlParam ethnicity required The id of the ethnicity. Example: 1
     *
     * @bodyParam label string required The label of the ethnicity. Max 255 characters. Example: Latino
     *
     * @response 200 {
     *  "id": 1,
     *  "object": "ethnicity",
     *  "label": "Latino",
     *  "created_at": 1514764800,
     *  "updated_at": 1514764800,
     * }
     *
     * @responseField id Unique identifier for the object.
     * @responseField object The object type. Always "ethnicity".
     * @responseField label The name of the ethnicity.
     * @responseField created_at The date the object was created. Represented as a Unix timestamp.
     * @responseField updated_at The date the object was last updated. Represented as a Unix timestamp.
     */
    public function update(Request $request)
    {
        $id = $request->route()->parameter('ethnicity');

        try {
            $ethnicity = Ethnicity::where('account_id', auth()->user()->account_id)
                ->findOrFail($id);
        } catch (ModelNotFoundException) {
            abort(401, 'There is no ethnicity with this id in your account.');
        }

        $validated = $request->validate([
            'label' => 'required|string|max:255',
        ]);

        $ethnicity = (new UpdateEthnicity(
            user: auth()->user(),
            ethnicity: $ethnicity,
            label: $validated['label'],
        ))->execute();

        return new EthnicityResource($ethnicity);
    }

    /**
     * Delete an ethnicity.
     *
     * @urlParam ethnicity required The id of the ethnicity. Example: 1
     *
     * @response 200 {
     *  "status": "success"
     * }
     */
    public function destroy(Request $request): JsonResponse
    {
        $id = $request->route()->parameter('ethnicity');

        try {
            $ethnicity = Ethnicity::where('account_id', auth()->user()->account_id)
                ->findOrFail($id);
        } catch (ModelNotFoundException) {
            abort(401, 'There is no ethnicity with this id in your account.');
        }

        (new DestroyEthnicity(
            user: auth()->user(),
            ethnicity: $ethnicity,
        ))->execute();

        return response()->json([
            'status' => 'success',
        ], 200);
    }

    /**
     * Retrieve an ethnicity.
     *
     * @urlParam ethnicity required The id of the ethnicity. Example: 1
     *
     * @response 200 {
     *   "id": 1,
     *   "object": "ethnicity",
     *   "label": "Hispanic",
     *   "created_at": 1514764800,
     *   "updated_at": 1514764800
     * }
     * @response 401 {
     *   "message": "There is no ethnicity with this id in your account."
     * }
     *
     * @responseField id Unique identifier for the object.
     * @responseField object The object type. Always "ethnicity".
     * @responseField label The name of the ethnicity.
     * @responseField created_at The date the object was created. Represented as a Unix timestamp.
     * @responseField updated_at The date the object was last updated. Represented as a Unix timestamp.
     */
    public function show(Request $request)
    {
        $id = $request->route()->parameter('ethnicity');

        try {
            $ethnicity = Ethnicity::where('account_id', auth()->user()->account_id)
                ->findOrFail($id);
        } catch (ModelNotFoundException) {
            abort(401, 'There is no ethnicity with this id in your account.');
        }

        return new EthnicityResource($ethnicity);
    }

    /**
     * List all ethnicities.
     *
     * This API call returns a paginated collection of ethnicities that contains
     * 15 items per page.
     *
     * @response 200 {"data": [{
     *  "id": 1,
     *  "object": "ethnicity",
     *  "label": "Hispanic",
     *  "created_at": 1514764800,
     *  "updated_at": 1514764800,
     * }, {
     *  "id": 2,
     *  "object": "ethnicity",
     *  "label": "Asian",
     *  "created_at": 1514764800,
     *  "updated_at": 1514764800,
     * }],
     * "links": {
     *   "first": "http://peopleos.test/api/ethnicities?page=1",
     *   "last": "http://peopleos.test/api/ethnicities?page=1",
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
     *        "url": "http://peopleos.test/api/ethnicities?page=1",
     *        "label": "1",
     *        "active": true
     *      },
     *      {
     *        "url": null,
     *        "label": "Next &raquo;",
     *        "active": false
     *      }
     *    ],
     *    "path": "http://peopleos.test/api/ethnicities",
     *    "per_page": 15,
     *    "to": 2,
     *    "total": 2
     *  }
     *
     * @responseField id Unique identifier for the object.
     * @responseField object The object type. Always "ethnicity".
     * @responseField label The name of the ethnicity.
     * @responseField created_at The date the object was created. Represented as a Unix timestamp.
     * @responseField updated_at The date the object was last updated. Represented as a Unix timestamp.
     */
    public function index(Request $request)
    {
        $ethnicities = auth()->user()->account
            ->ethnicities()
            ->paginate();

        return new EthnicityCollection($ethnicities);
    }
}
