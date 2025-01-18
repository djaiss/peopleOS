<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Administration;

use App\Http\Controllers\Controller;
use App\Http\Resources\MaritalStatusResource;
use App\Models\MaritalStatus;
use App\Services\CreateMaritalStatus;
use App\Services\DestroyMaritalStatus;
use App\Services\UpdateMaritalStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

/**
 * @group Marital statuses
 */
class MaritalStatusController extends Controller
{
    /**
     * List all marital statuses.
     *
     * Returns a list of marital statuses in the account, ordered by position.
     *
     * @response 200 {"data": [{
     *  "id": 1,
     *  "object": "marital_status",
     *  "name": "Married",
     *  "position": 1,
     *  "created_at": 1514764800,
     * }, {
     *  "id": 2,
     *  "object": "marital_status",
     *  "name": "Divorced",
     *  "position": 2,
     *  "created_at": 1514764800,
     * }],
     * "links": {
     *   "first": "http://peopleos.test/api/administration/marital-statuses?page=1",
     *   "last": "http://peopleos.test/api/administration/marital-statuses?page=1",
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
     *        "url": "http://peopleos.test/api/administration/marital-statuses?page=1",
     *        "label": "1",
     *        "active": true
     *      },
     *      {
     *        "url": null,
     *        "label": "Next &raquo;",
     *        "active": false
     *      }
     *    ],
     *    "path": "http://peopleos.test/api/administration/marital-statuses",
     *    "per_page": 15,
     *    "to": 1,
     *    "total": 1
     *  }
     *
     * @responseField id The ID of the marital status
     * @responseField object The type of the object. Always "marital_status"
     * @responseField name The name of the marital status
     * @responseField position The position of the marital status in the list
     * @responseField created_at Time at which the object was created. Measured in seconds since the Unix epoch
     */
    public function index(): JsonResource
    {
        $maritalStatuses = MaritalStatus::where('account_id', Auth::user()->account_id)
            ->orderBy('position', 'asc')
            ->get();

        return MaritalStatusResource::collection($maritalStatuses);
    }

    /**
     * Create a marital status.
     *
     * A marital status categorizes the marital status of a person.
     * Marital statuses are ordered by position. When you create a new marital status, it will be
     * added to the end of the list by default - ie after the max marital status
     * position.
     * A person can have one marital status, or not marital status at all.
     *
     * @bodyParam name string required The name of the marital status. Max 255 characters. Example: Married
     *
     * @response 201 {
     *  "data": {
     *   "id": 1,
     *   "object": "marital_status",
     *   "name": "Married",
     *   "position": 1,
     *   "created_at": "1679090539"
     *  }
     * }
     */
    public function create(Request $request): JsonResource
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $maritalStatus = (new CreateMaritalStatus(
            user: $request->user(),
            name: $data['name'],
        ))->execute();

        return new MaritalStatusResource($maritalStatus);
    }

    /**
     * Update a marital status.
     *
     * @urlParam marital_status required The ID of the marital status. Example: 1
     *
     * @bodyParam name string required The name of the marital status. Max 255 characters. Example: Married
     * @bodyParam position integer required The position of the marital status in the list. Example: 2
     *
     * @response 200 {
     *  "data": {
     *   "id": 1,
     *   "object": "marital_status",
     *   "name": "Divorced",
     *   "position": 2,
     *   "created_at": "1679090539"
     *  }
     * }
     */
    public function update(Request $request, MaritalStatus $maritalStatus): JsonResource
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'position' => ['required', 'integer'],
        ]);

        $maritalStatus = (new UpdateMaritalStatus(
            user: $request->user(),
            maritalStatus: $maritalStatus,
            name: $data['name'],
            position: $data['position'],
        ))->execute();

        return new MaritalStatusResource($maritalStatus);
    }

    /**
     * Delete a marital status.
     *
     * @urlParam marital_status required The ID of the marital status. Example: 1
     *
     * @response 204
     */
    public function destroy(Request $request, MaritalStatus $maritalStatus): Response
    {
        (new DestroyMaritalStatus(
            user: $request->user(),
            maritalStatus: $maritalStatus,
        ))->execute();

        return response()->noContent();
    }
}
