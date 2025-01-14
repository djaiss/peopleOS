<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Administration;

use App\Http\Controllers\Controller;
use App\Http\Resources\GenderResource;
use App\Models\Gender;
use App\Services\CreateGender;
use App\Services\DestroyGender;
use App\Services\UpdateGender;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

/**
 * @group Genders
 */
class GenderController extends Controller
{
    /**
     * List all genders.
     *
     * Returns a list of genders in the account, ordered by position.
     *
     * @response 200 {
     *  "data": [
     *   {
     *    "id": 1,
     *    "object": "gender",
     *    "name": "Male",
     *    "position": 1,
     *    "created_at": "1679090539"
     *   }
     *  ]
     * }
     *
     * @responseField id The ID of the gender
     * @responseField object The type of the object. Always "gender"
     * @responseField name The name of the gender
     * @responseField position The position of the gender in the list
     * @responseField created_at Time at which the object was created. Measured in seconds since the Unix epoch
     */
    public function index(): JsonResource
    {
        $genders = Gender::where('account_id', Auth::user()->account_id)
            ->orderBy('position', 'asc')
            ->get();

        return GenderResource::collection($genders);
    }

    /**
     * Create a gender.
     *
     * A gender categorizes the gender identity of a person.
     * Genders are ordered by position. When you create a new gender, it will be
     * added to the end of the list by default - ie after the max gender
     * position.
     * A person can have one gender, or not gender at all.
     *
     * @bodyParam name string required The name of the gender. Max 255 characters. Example: Male
     *
     * @response 201 {
     *  "data": {
     *   "id": 1,
     *   "object": "gender",
     *   "name": "Male",
     *   "position": 1,
     *   "created_at": "1679090539"
     *  }
     * }
     */
    public function store(Request $request): JsonResource
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $gender = (new CreateGender(
            user: $request->user(),
            name: $data['name'],
        ))->execute();

        return new GenderResource($gender);
    }

    /**
     * Update a gender.
     *
     * @urlParam gender required The ID of the gender. Example: 1
     *
     * @bodyParam name string required The name of the gender. Max 255 characters. Example: Female
     * @bodyParam position integer required The position of the gender in the list. Example: 2
     *
     * @response 200 {
     *  "data": {
     *   "id": 1,
     *   "object": "gender",
     *   "name": "Female",
     *   "position": 2,
     *   "created_at": "1679090539"
     *  }
     * }
     */
    public function update(Request $request, Gender $gender): JsonResource
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'position' => ['required', 'integer'],
        ]);

        $gender = (new UpdateGender(
            user: $request->user(),
            gender: $gender,
            name: $data['name'],
            position: $data['position'],
        ))->execute();

        return new GenderResource($gender);
    }

    /**
     * Delete a gender.
     *
     * @urlParam gender required The ID of the gender. Example: 1
     *
     * @response 204
     */
    public function destroy(Request $request, Gender $gender): Response
    {
        (new DestroyGender(
            user: $request->user(),
            gender: $gender,
        ))->execute();

        return response()->noContent();
    }
}
