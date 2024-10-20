<?php

namespace App\Http\Controllers\Api\Settings;

use App\Http\Controllers\Controller;
use App\Http\Resources\GenderCollection;
use App\Http\Resources\GenderResource;
use App\Models\Gender;
use App\Services\CreateGender;
use App\Services\DestroyGender;
use App\Services\UpdateGender;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @group Genders
 *
 * Gender for a human refers to the roles, behaviors, activities, expectations,
 * and societal norms that cultures and societies consider appropriate for men,
 * women, and other gender identities.
 *
 * Genders are defined at the account level and shared by all users in the
 * account. If you delete a gender it will be removed from all the contacts
 * that are using it.
 */
class GenderController extends Controller
{
    /**
     * Create a gender
     *
     * @bodyParam label string required The label of the gender. Max 255 characters. Example: Male
     *
     * @response 201 {
     *  "id": 1,
     *  "object": "gender",
     *  "label": "Male",
     *  "created_at": 1514764800,
     *  "updated_at": 1514764800,
     * }
     *
     * @responseField id Unique identifier for the object.
     * @responseField label The name of the gender.
     * @responseField created_at The date the object was created. Represented as a Unix timestamp.
     * @responseField updated_at The date the object was last updated. Represented as a Unix timestamp.
     */
    public function create(Request $request)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
        ]);

        $gender = (new CreateGender(
            user: auth()->user(),
            label: $validated['label'],
        ))->execute();

        return new GenderResource($gender);
    }

    /**
     * Update a gender
     *
     * @urlParam gender required The id of the gender. Example: 1
     *
     * @bodyParam label string required The label of the gender. Max 255 characters. Example: Male
     *
     * @response 200 {
     *  "id": 1,
     *  "object": "gender",
     *  "label": "Male",
     *  "created_at": 1514764800,
     *  "updated_at": 1514764800,
     * }
     *
     * @responseField id Unique identifier for the object.
     * @responseField label The name of the gender.
     * @responseField created_at The date the object was created. Represented as a Unix timestamp.
     * @responseField updated_at The date the object was last updated. Represented as a Unix timestamp.
     */
    public function update(Request $request)
    {
        $id = $request->route()->parameter('gender');

        try {
            $gender = Gender::where('account_id', auth()->user()->account_id)
                ->findOrFail($id);
        } catch (ModelNotFoundException) {
            abort(401, 'There is no gender with this id in your account.');
        }

        $validated = $request->validate([
            'label' => 'required|string|max:255',
        ]);

        $gender = (new UpdateGender(
            user: auth()->user(),
            gender: $gender,
            label: $validated['label'],
        ))->execute();

        return new GenderResource($gender);
    }

    /**
     * Delete a gender
     *
     * @urlParam gender required The id of the gender. Example: 1
     *
     * @response 200 {
     *  "status": "success"
     * }
     */
    public function destroy(Request $request): JsonResponse
    {
        $id = $request->route()->parameter('gender');

        try {
            $gender = Gender::where('account_id', auth()->user()->account_id)
                ->findOrFail($id);
        } catch (ModelNotFoundException) {
            abort(401, 'There is no gender with this id in your account.');
        }

        (new DestroyGender(
            user: auth()->user(),
            gender: $gender,
        ))->execute();

        return response()->json([
            'status' => 'success',
        ], 200);
    }

    /**
     * List all genders
     *
     * This API call returns a paginated collection of genders that contains
     * 15 items per page.
     *
     * @response 200 {"data": [{
     *  "id": 1,
     *  "object": "gender",
     *  "label": "Male",
     *  "created_at": 1514764800,
     *  "updated_at": 1514764800,
     * }, {
     *  "id": 2,
     *  "object": "gender",
     *  "label": "Female",
     *  "created_at": 1514764800,
     *  "updated_at": 1514764800,
     * }],
     * "links": {
     *   "first": "http://peopleos.test/api/genders?page=1",
     *   "last": "http://peopleos.test/api/genders?page=1",
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
     *        "url": "http://peopleos.test/api/genders?page=1",
     *        "label": "1",
     *        "active": true
     *      },
     *      {
     *        "url": null,
     *        "label": "Next &raquo;",
     *        "active": false
     *      }
     *    ],
     *    "path": "http://peopleos.test/api/genders",
     *    "per_page": 15,
     *    "to": 1,
     *    "total": 1
     *  }
     *
     * @responseField id Unique identifier for the object.
     * @responseField label The name of the gender.
     * @responseField created_at The date the object was created. Represented as a Unix timestamp.
     * @responseField updated_at The date the object was last updated. Represented as a Unix timestamp.
     */
    public function index(Request $request)
    {
        $genders = auth()->user()->account
            ->genders()
            ->paginate();

        return new GenderCollection($genders);
    }
}
