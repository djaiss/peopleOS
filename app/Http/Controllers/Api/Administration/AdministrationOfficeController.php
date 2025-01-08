<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Administration;

use App\Http\Controllers\Controller;
use App\Http\Resources\OfficeCollection;
use App\Http\Resources\OfficeResource;
use App\Models\Office;
use App\Services\CreateOffice;
use App\Services\DestroyOffice;
use App\Services\UpdateOffice;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

/**
 * @group Administration
 *
 * @subgroup Manage offices
 */
class AdministrationOfficeController extends Controller
{
    /**
     * Create an office.
     *
     * An office is a physical location where employees work. It can be a branch,
     * a department, or any other location where employees work.
     *
     * Only administrators can create an office.
     *
     * @bodyParam name string required The name of the office. Max 255 characters. Example: Scranton Branch
     *
     * @response 201 {
     *  "id": 4,
     *  "object": "office",
     *  "account_id": 1,
     *  "name": "Scranton Branch",
     *  "created_at": "1679090539"
     * }
     *
     * @responseField id The ID of the office.
     * @responseField object The type of the object. Always "office".
     * @responseField account_id The ID of the account.
     * @responseField name The name of the office.
     * @responseField created_at Time at which the object was created. Measured in seconds since the Unix epoch.
     */
    public function store(Request $request): JsonResource
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $office = (new CreateOffice(
            user: $request->user(),
            name: $validated['name'],
        ))->execute();

        return new OfficeResource($office);
    }

    /**
     * Update an office.
     *
     * Only administrators can update an office.
     *
     * @urlParam office integer required The ID of the office. Example: 4
     *
     * @bodyParam name string required The name of the office. Max 255 characters. Example: Scranton Branch
     *
     * @response 200 {
     *  "id": 4,
     *  "object": "office",
     *  "account_id": 1,
     *  "name": "Scranton Branch",
     *  "created_at": "1679090539"
     * }
     *
     * @responseField id The ID of the office.
     * @responseField object The type of the object. Always "office".
     * @responseField account_id The ID of the account.
     * @responseField name The name of the office.
     * @responseField created_at Time at which the object was created. Measured in seconds since the Unix epoch.
     */
    public function update(Request $request, Office $office): JsonResource
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $office = (new UpdateOffice(
            user: $request->user(),
            office: $office,
            name: $validated['name'],
        ))->execute();

        return new OfficeResource($office);
    }

    /**
     * Delete an office.
     *
     * Only administrators can delete an office.
     *
     * @urlParam office integer required The ID of the office. Example: 4
     *
     * @response 200 {
     *  "status": "success"
     * }
     */
    public function destroy(Request $request, Office $office): JsonResponse
    {
        (new DestroyOffice(
            user: $request->user(),
            office: $office,
        ))->execute();

        return response()->json(['status' => 'success']);
    }

    /**
     * List offices.
     *
     * This API call returns a paginated collection of offices that contains
     * 15 items per page. This list is ordered by the creation date.
     * The offices in this call are for the administration of the account.
     *
     * Only administrators can list the offices from an administration point of
     * view.
     *
     * @response 200 {"data": [{
     *  "id": 1,
     *  "object": "office",
     *  "account_id": 1,
     *  "name": "New York Branch",
     *  "created_at": 1514764800,
     * }, {
     *  "id": 2,
     *  "object": "office",
     *  "account_id": 1,
     *  "name": "Scranton Branch",
     *  "created_at": 1514764800,
     * }],
     * "links": {
     *   "first": "http://organizationos.test/api/administration/offices?page=1",
     *   "last": "http://organizationos.test/api/administration/offices?page=1",
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
     *        "url": "http://organizationos.test/api/administration/offices?page=1",
     *        "label": "1",
     *        "active": true
     *      },
     *      {
     *        "url": null,
     *        "label": "Next &raquo;",
     *        "active": false
     *      }
     *    ],
     *    "path": "http://organizationos.test/api/administration/offices",
     *    "per_page": 15,
     *    "to": 1,
     *    "total": 1
     *  }
     *
     * @responseField id Unique identifier for the object.
     * @responseField object The object type. Always "office".
     * @responseField account_id The ID of the account.
     * @responseField name The name of the office.
     * @responseField created_at Time at which the object was created. Measured in seconds since the Unix epoch.
     */
    public function index(Request $request): OfficeCollection
    {
        $offices = Auth::user()->account
            ->offices()
            ->paginate(15);

        return new OfficeCollection($offices);
    }
}
