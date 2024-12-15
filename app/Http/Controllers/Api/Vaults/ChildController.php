<?php

namespace App\Http\Controllers\Api\Vaults;

use App\Http\Controllers\Controller;
use App\Http\Resources\ChildCollection;
use App\Http\Resources\ChildResource;
use App\Models\Child;
use App\Models\Gender;
use App\Services\CreateChild;
use App\Services\DestroyChild;
use App\Services\UpdateChild;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @group Contacts
 *
 * @subgroup Children
 */
class ChildController extends Controller
{
    /**
     * Create a child.
     *
     * Creates a new child for the given contact.
     * A child has currently two information: gender and name. Only the gender
     * is required, the name is optional. A contact can have multiple children.
     *
     * Once created, the child will be returned in the response.
     *
     * @urlParam vault required The id of the vault. Example: 1
     * @urlParam contact required The id of the contact. Example: 1
     *
     * @bodyParam gender string required The gender of the child. Only three values are accepted for this field: 'boy', 'girl', 'other'. Any other value will be rejected. Example: boy
     * @bodyParam name string The name of the child. Max 255 characters. Example: Michael
     * @bodyParam age int The age of the child. Example: 10
     * @bodyParam grade_level string The grade level of the child. Example: 10th
     * @bodyParam school string The school of the child. Example: Saint Junior High School
     *
     * @response 201 {
     *  "id": 4,
     *  "object": "child",
     *  "contact": {
     *      "id": 1,
     *      "name": "Dwight Schrute",
     *  },
     *  "gender": "boy",
     *  "name": "Michael",
     *  "age": 10,
     *  "grade_level": "10th",
     *  "school": "Saint Junior High School",
     *  "created_at": 1514764800,
     *  "updated_at": 1514764800,
     * }
     *
     * @responseField id Unique identifier for the object.
     * @responseField object The object type. Always "child".
     * @responseField contact The contact object who represents the parent.
     * @responseField gender The gender of the child.
     * @responseField name The name of the child.
     * @responseField age The age of the child.
     * @responseField grade_level The grade level of the child.
     * @responseField school The school of the child.
     * @responseField created_at The date the object was created. Represented as a Unix timestamp.
     * @responseField updated_at The date the object was last updated. Represented as a Unix timestamp.
     */
    public function create(Request $request)
    {
        $contact = $request->attributes->get('contact');

        $validated = $request->validate([
            'gender' => 'required|string|in:boy,girl,other',
            'name' => 'nullable|string|max:255',
            'age' => 'nullable|integer',
            'grade_level' => 'nullable|string|max:255',
            'school' => 'nullable|string|max:255',
        ]);

        $child = (new CreateChild(
            user: Auth::user(),
            contact: $contact,
            name: $validated['name'],
            gender: $validated['gender'],
            age: $validated['age'],
            gradeLevel: $validated['grade_level'],
            school: $validated['school'],
        ))->execute();

        return new ChildResource($child);
    }

    /**
     * Update a child.
     *
     * Updates an existing child.
     *
     * Once updated, the child will be returned in the response.
     *
     * @urlParam vault required The id of the vault. Example: 1
     * @urlParam contact required The id of the contact. Example: 1
     * @urlParam child required The id of the child. Example: 1
     *
     * @bodyParam gender string required The gender of the child. Only three values are accepted for this field: 'boy', 'girl', 'other'. Any other value will be rejected. Example: boy
     * @bodyParam name string The name of the child. Max 255 characters. Example: Michael
     * @bodyParam age int The age of the child. Example: 10
     * @bodyParam grade_level string The grade level of the child. Example: 10th
     * @bodyParam school string The school of the child. Example: Saint Junior High School
     *
     * @response 200 {
     *  "id": 4,
     *  "object": "child",
     *  "contact": {
     *      "id": 1,
     *      "name": "Dwight Schrute",
     *  },
     *  "gender": "boy",
     *  "name": "Michael",
     *  "age": 10,
     *  "grade_level": "10th",
     *  "school": "Saint Junior High School",
     *  "created_at": 1514764800,
     *  "updated_at": 1514764800,
     * }
     *
     * @responseField id Unique identifier for the object.
     * @responseField object The object type. Always "child".
     * @responseField contact The contact object who represents the parent.
     * @responseField gender The gender of the child.
     * @responseField name The name of the child.
     * @responseField age The age of the child.
     * @responseField grade_level The grade level of the child.
     * @responseField school The school of the child.
     * @responseField created_at The date the object was created. Represented as a Unix timestamp.
     * @responseField updated_at The date the object was last updated. Represented as a Unix timestamp.
     */
    public function update(Request $request)
    {
        $contact = $request->attributes->get('contact');
        $child = $request->route()->parameter('child');

        $validated = $request->validate([
            'gender' => 'required|string|in:boy,girl,other',
            'name' => 'nullable|string|max:255',
            'age' => 'nullable|integer',
            'grade_level' => 'nullable|string|max:255',
            'school' => 'nullable|string|max:255',
        ]);

        try {
            $child = Child::where('contact_id', $contact->id)
                ->findOrFail($child);
        } catch (ModelNotFoundException) {
            abort(401);
        }

        $child = (new UpdateChild(
            user: Auth::user(),
            child: $child,
            gender: $validated['gender'],
            name: $validated['name'],
            age: $validated['age'],
            gradeLevel: $validated['grade_level'],
            school: $validated['school'],
        ))->execute();

        return new ChildResource($child);
    }

    /**
     * Delete a child.
     *
     * @urlParam vault required The id of the vault. Example: 1
     * @urlParam contact required The id of the contact. Example: 1
     * @urlParam child required The id of the child. Example: 1
     *
     * @response 200 {
     *  "status": "success"
     * }
     */
    public function destroy(Request $request): JsonResponse
    {
        $contact = $request->attributes->get('contact');
        $child = $request->route()->parameter('child');

        try {
            $child = Child::where('contact_id', $contact->id)
                ->findOrFail($child);
        } catch (ModelNotFoundException) {
            abort(401);
        }

        (new DestroyChild(
            user: Auth::user(),
            child: $child,
        ))->execute();

        return response()->json([
            'status' => 'success',
        ], 200);
    }

    /**
     * Retrieve a child.
     *
     * The age is approximate, it is calculated based on the age originally
     * defined and the current year. For example, if the age entered is 10 and
     * the age was entered 5 years ago, the age returned will be 15.
     *
     * @urlParam vault required The id of the vault. Example: 1
     * @urlParam contact required The id of the contact. Example: 1
     * @urlParam child required The id of the child. Example: 1
     *
     * @response 200 {
     *   "id": 1,
     *   "object": "child",
     *   "contact": {
     *      "id": 1,
     *      "name": "Dwight Schrute",
     *   },
     *   "gender": "boy",
     *   "name": "John Doe",
     *   "age": 10,
     *   "grade_level": "10th",
     *   "school": "Saint Junior High School",
     *   "created_at": 1514764800,
     *   "updated_at": 1514764800
     * }
     *
     * @responseField id Unique identifier for the object.
     * @responseField object The object type. Always "child".
     * @responseField contact The contact object who represents the parent.
     * @responseField gender The gender of the child.
     * @responseField name The name of the child.
     * @responseField age The age of the child.
     * @responseField grade_level The grade level of the child.
     * @responseField school The school of the child.
     * @responseField created_at The date the object was created. Represented as a Unix timestamp.
     * @responseField updated_at The date the object was last updated. Represented as a Unix timestamp.
     */
    public function show(Request $request)
    {
        $contact = $request->attributes->get('contact');
        $child = $request->route()->parameter('child');

        try {
            $child = Child::where('contact_id', $contact->id)
                ->findOrFail($child);
        } catch (ModelNotFoundException) {
            abort(401);
        }

        return new ChildResource($child);
    }

    /**
     * List all children.
     *
     * This API call returns a paginated collection of children.
     *
     * @response 200 {"data": [{
     *  "id": 4,
     *  "object": "child",
     *  "contact": {
     *      "id": 1,
     *      "name": "Dwight Schrute",
     *  },
     *  "gender": "boy",
     *  "name": "Michael",
     *  "age": 10,
     *  "grade_level": "10th",
     *  "school": "Saint Junior High School",
     *  "created_at": 1514764800,
     *  "updated_at": 1514764800,
     * }, {
     *  "id": 5,
     *  "object": "child",
     *  "contact": {
     *      "id": 1,
     *      "name": "Dwight Schrute",
     *  },
     *  "gender": "girl",
     *  "name": "Dwight",
     *  "age": 10,
     *  "grade_level": "10th",
     *  "school": "Saint Junior High School",
     *  "created_at": 1514764800,
     *  "updated_at": 1514764800,
     * }],
     * "links": {
     *   "first": "http://peopleos.test/api/vaults/1/contacts/1/children?page=1",
     *   "last": "http://peopleos.test/api/vaults/1/contacts/1/children?page=1",
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
     *    "path": "http://peopleos.test/api/vaults/1/contacts/1/children",
     *    "per_page": 15,
     *    "to": 1,
     *    "total": 1
     *  }
     *
     * @responseField id Unique identifier for the object.
     * @responseField object The object type. Always "child".
     * @responseField contact The contact object who represents the parent.
     * @responseField gender The gender of the child.
     * @responseField name The name of the child.
     * @responseField age The age of the child.
     * @responseField grade_level The grade level of the child.
     * @responseField school The school of the child.
     * @responseField created_at The date the object was created. Represented as a Unix timestamp.
     * @responseField updated_at The date the object was last updated. Represented as a Unix timestamp.
     */
    public function index(Request $request)
    {
        $contact = $request->attributes->get('contact');

        $children = $contact->children()
            ->with('contact')
            ->paginate();

        return new ChildCollection($children);
    }
}
