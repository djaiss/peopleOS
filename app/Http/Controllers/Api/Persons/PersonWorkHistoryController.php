<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Persons;

use App\Http\Controllers\Controller;
use App\Http\Resources\WorkHistoryCollection;
use App\Http\Resources\WorkHistoryResource;
use App\Models\Person;
use App\Models\WorkHistory;
use App\Services\CreateWorkHistory;
use App\Services\DestroyWorkHistory;
use App\Services\UpdateWorkHistory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

/**
 * @group Work History
 */
class PersonWorkHistoryController extends Controller
{
    /**
     * Create a work history entry.
     *
     * A work history entry is a piece of information that you want to keep about a person's work history.
     *
     * @urlParam person required The id of the person. Example: 1
     *
     * @bodyParam company_name string required The name of the company. Example: Google
     * @bodyParam job_title string required The job title. Example: Software Engineer
     * @bodyParam estimated_salary string required The estimated salary. Example: $100,000
     * @bodyParam active boolean required Whether the work history entry is active. Example: true
     * @bodyParam duration string required The duration of the work history entry. Example: 1 year
     *
     * @response 201 {
     *  "id": 4,
     *  "object": "work_history",
     *  "company_name": "Google",
     *  "job_title": "Software Engineer",
     *  "estimated_salary": "$100,000",
     *  "duration": "1 year",
     *  "active": true,
     *  "created_at": 1514764800,
     *  "updated_at": 1514764800,
     * }
     *
     * @responseField id Unique identifier for the object.
     * @responseField object The object type. Always "work_history".
     * @responseField company_name The name of the company.
     * @responseField job_title The job title.
     * @responseField estimated_salary The estimated salary.
     * @responseField duration The duration of the work history entry.
     * @responseField active Whether the work history entry is active.
     * @responseField created_at The date the object was created. Represented as a Unix timestamp.
     * @responseField updated_at The date the object was last updated. Represented as a Unix timestamp.
     */
    public function create(Request $request): WorkHistoryResource
    {
        $person = $request->attributes->get('person');

        $validated = $request->validate([
            'company_name' => 'nullable|string|max:255',
            'job_title' => 'required|string|max:255',
            'estimated_salary' => 'nullable|string|max:255',
            'active' => 'required|boolean',
            'duration' => 'nullable|string|max:255',
        ]);

        $workHistory = (new CreateWorkHistory(
            user: Auth::user(),
            person: $person,
            companyName: $validated['company_name'],
            jobTitle: $validated['job_title'],
            estimatedSalary: $validated['estimated_salary'],
            active: $validated['active'],
            duration: $validated['duration'] ?? null,
        ))->execute();

        return new WorkHistoryResource($workHistory);
    }

    /**
     * Update a work history entry.
     *
     * Updates an existing work history entry.
     *
     * Once updated, the work history entry will be returned in the response.
     *
     * @urlParam person required The id of the person. Example: 1
     * @urlParam work_history required The id of the work history entry. Example: 1
     *
     * @bodyParam company_name string required The name of the company. Example: Google
     * @bodyParam job_title string required The job title. Example: Software Engineer
     * @bodyParam estimated_salary string required The estimated salary. Example: $100,000
     * @bodyParam active boolean required Whether the work history entry is active. Example: true
     * @bodyParam duration string required The duration of the work history entry. Example: 1 year
     *
     * @response 200 {
     *  "id": 4,
     *  "object": "work_history",
     *  "company_name": "Google",
     *  "job_title": "Software Engineer",
     *  "estimated_salary": "$100,000",
     *  "duration": "1 year",
     *  "active": true,
     *  "created_at": 1514764800,
     *  "updated_at": 1514764800,
     * }
     *
     * @responseField id Unique identifier for the object.
     * @responseField object The object type. Always "work_history".
     * @responseField company_name The name of the company.
     * @responseField job_title The job title.
     * @responseField estimated_salary The estimated salary.
     * @responseField active Whether the work history entry is active.
     * @responseField duration The duration of the work history entry.
     * @responseField created_at The date the object was created. Represented as a Unix timestamp.
     * @responseField updated_at The date the object was last updated. Represented as a Unix timestamp.
     */
    public function update(Request $request): WorkHistoryResource
    {
        $workHistory = $request->attributes->get('workHistory');

        $validated = $request->validate([
            'company_name' => 'nullable|string|max:255',
            'job_title' => 'required|string|max:255',
            'estimated_salary' => 'nullable|string|max:255',
            'active' => 'required|boolean',
            'duration' => 'nullable|string|max:255',
        ]);

        $workHistory = (new UpdateWorkHistory(
            user: Auth::user(),
            workHistory: $workHistory,
            companyName: $validated['company_name'],
            jobTitle: $validated['job_title'],
            estimatedSalary: $validated['estimated_salary'],
            active: $validated['active'],
            duration: $validated['duration'] ?? null,
        ))->execute();

        return new WorkHistoryResource($workHistory);
    }

    /**
     * Delete a work history entry.
     *
     * @urlParam person required The id of the person. Example: 1
     * @urlParam work_history required The id of the work history entry. Example: 1
     *
     * @response 204
     */
    public function destroy(Request $request): Response
    {
        $workHistory = $request->attributes->get('workHistory');

        try {
            (new DestroyWorkHistory(
                user: Auth::user(),
                workHistory: $workHistory,
            ))->execute();
        } catch (Exception) {
            return response()->noContent(404);
        }

        return response()->noContent();
    }

    /**
     * Retrieve a work history entry.
     *
     * @urlParam person required The id of the person. Example: 1
     * @urlParam work_history required The id of the work history entry. Example: 1
     *
     * @response 200 {
     *   "id": 1,
     *   "object": "work_history",
     *   "company_name": "Google",
     *   "job_title": "Software Engineer",
     *   "estimated_salary": "$100,000",
     *   "duration": "1 year",
     *   "active": true,
     *   "created_at": 1514764800,
     *   "updated_at": 1514764800,
     * }
     *
     * @responseField id Unique identifier for the object.
     * @responseField object The object type. Always "work_history".
     * @responseField company_name The name of the company.
     * @responseField job_title The job title.
     * @responseField estimated_salary The estimated salary.
     * @responseField duration The duration of the work history entry.
     * @responseField active Whether the work history entry is active.
     * @responseField created_at The date the object was created. Represented as a Unix timestamp.
     * @responseField updated_at The date the object was last updated. Represented as a Unix timestamp.
     */
    public function show(Request $request): WorkHistoryResource
    {
        $workHistory = $request->attributes->get('workHistory');

        return new WorkHistoryResource($workHistory);
    }

    /**
     * List all work history entries.
     *
     * This API call returns a paginated collection of work history entries that contains
     * 15 items per page.
     *
     * @urlParam person required The id of the person. Example: 1
     *
     * @response 200 {"data": [{
     *  "id": 4,
     *  "object": "work_history",
     *  "company_name": "Google",
     *  "job_title": "Software Engineer",
     *  "estimated_salary": "$100,000",
     *  "duration": "1 year",
     *  "active": true,
     *  "created_at": 1514764800,
     *  "updated_at": 1514764800,
     * }, {
     *  "id": 5,
     *  "object": "work_history",
     *  "company_name": "Facebook",
     *  "job_title": "Software Engineer",
     *  "estimated_salary": "$120,000",
     *  "duration": "1 year",
     *  "active": true,
     *  "created_at": 1514764800,
     *  "updated_at": 1514764800
     * },
     * "links": {
     *   "first": "http://peopleos.test/api/persons/1/work-history?page=1",
     *   "last": "http://peopleos.test/api/persons/1/work-history?page=1",
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
     *        "url": "http://peopleos.test/api/persons/1/work-history?page=1",
     *        "label": "1",
     *        "active": true
     *      },
     *      {
     *        "url": null,
     *        "label": "Next &raquo;",
     *        "active": false
     *      }
     *    ],
     *    "path": "http://peopleos.test/api/persons/1/work-history",
     *    "per_page": 15,
     *    "to": 1,
     *    "total": 1
     *  }
     *
     * @responseField id Unique identifier for the object.
     * @responseField object The object type. Always "work_history".
     * @responseField company_name The name of the company.
     * @responseField job_title The job title.
     * @responseField estimated_salary The estimated salary.
     * @responseField duration The duration of the work history entry.
     * @responseField active Whether the work history entry is active.
     * @responseField created_at The date the object was created. Represented as a Unix timestamp.
     * @responseField updated_at The date the object was last updated. Represented as a Unix timestamp.
     */
    public function index(Request $request): WorkHistoryCollection
    {
        $person = $request->attributes->get('person');

        $workHistory = WorkHistory::where('person_id', $person->id)
            ->paginate();

        return new WorkHistoryCollection($workHistory);
    }
}
