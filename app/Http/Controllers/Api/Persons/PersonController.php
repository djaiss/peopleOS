<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Persons;

use App\Http\Controllers\Controller;
use App\Http\Resources\PersonCollection;
use App\Http\Resources\PersonResource;
use App\Models\Gender;
use App\Models\Person;
use App\Services\CreatePerson;
use App\Services\DestroyPerson;
use App\Services\UpdatePerson;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use RuntimeException;

/**
 * @group People
 */
class PersonController extends Controller
{
    /**
     * Create a person.
     *
     * Once created, the person will be returned in the response, as well as
     * the display name of the person. This name's format depends on the user
     * settings.
     *
     * @bodyParam gender_id integer The gender object associated with the person. This object must be a valid Gender object. Example: 1
     * @bodyParam first_name string required The first name of the person. Max 255 characters. Example: Ross
     * @bodyParam last_name string The last name of the person. Max 255 characters. Example: Geller
     * @bodyParam middle_name string The middle name of the person. Max 255 characters. Example: Gary
     * @bodyParam nickname string The nickname of the person. Max 255 characters. Example: Bear
     * @bodyParam maiden_name string The maiden name of the person, important in some cultures, where a woman’s surname changes after marriage. Max 255 characters. Example: Johnson
     * @bodyParam prefix string The prefix of the person. Max 255 characters. Example: Mr.
     * @bodyParam suffix string The suffix of the person. Max 255 characters. Example: Jr.
     * @bodyParam can_be_deleted boolean Whether the person can be deleted. 0 for false, 1 for true. Example: 1
     *
     * @response 201 {
     *  "id": 4,
     *  "object": "person",
     *  "name": "Ross Geller",
     *  "first_name": "Ross",
     *  "last_name": "Geller",
     *  "middle_name": "Gary",
     *  "nickname": "Bear",
     *  "maiden_name": "Johnson",
     *  "prefix": "Mr.",
     *  "suffix": "Jr.",
     *  "can_be_deleted": 1,
     *  "created_at": 1514764800,
     *  "updated_at": 1514764800,
     * }
     *
     * @responseField id Unique identifier for the object.
     * @responseField object The object type. Always "person".
     * @responseField name The display name of the person.
     * @responseField first_name The first name of the person.
     * @responseField last_name The last name of the person.
     * @responseField middle_name The middle name of the person.
     * @responseField nickname The nickname of the person.
     * @responseField maiden_name The maiden name of the person.
     * @responseField prefix The prefix of the person.
     * @responseField suffix The suffix of the person.
     * @responseField can_be_deleted Whether the person can be deleted.
     * @responseField created_at The date the object was created. Represented as a Unix timestamp.
     * @responseField updated_at The date the object was last updated. Represented as a Unix timestamp.
     */
    public function create(Request $request): PersonResource
    {
        $validated = $request->validate([
            'gender_id' => 'nullable|exists:genders,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'nickname' => 'nullable|string|max:255',
            'maiden_name' => 'nullable|string|max:255',
            'prefix' => 'nullable|string|max:255',
            'suffix' => 'nullable|string|max:255',
            'can_be_deleted' => 'boolean',
        ]);

        $person = (new CreatePerson(
            user: Auth::user(),
            gender: $validated['gender_id'] ? Gender::find($validated['gender_id']) : null,
            firstName: $validated['first_name'],
            lastName: $validated['last_name'],
            middleName: $validated['middle_name'],
            nickname: $validated['nickname'],
            maidenName: $validated['maiden_name'],
            prefix: $validated['prefix'],
            suffix: $validated['suffix'],
            canBeDeleted: $validated['can_be_deleted'],
        ))->execute();

        return new PersonResource($person);
    }

    /**
     * Update a person.
     *
     * Updates an existing person.
     *
     * Once updated, the person will be returned in the response, as well as
     * the display name of the person. This name's format depends on the user
     * settings.
     *
     * @urlParam person required The id of the person. Example: 1
     *
     * @bodyParam gender_id integer The gender associated with the person. This object must be a valid Gender object. Example: 1
     * @bodyParam first_name string required The first name of the person. Max 255 characters. Example: Michael
     * @bodyParam last_name string The last name of the person. Max 255 characters. Example: Scott
     * @bodyParam middle_name string The middle name of the person. Max 255 characters. Example: Gary
     * @bodyParam nickname string The nickname of the person. Max 255 characters. Example: Mike
     * @bodyParam maiden_name string The maiden name of the person, important in some cultures, where a woman’s surname changes after marriage. Max 255 characters. Example: Johnson
     * @bodyParam prefix string The prefix of the person. Max 255 characters. Example: Mr.
     * @bodyParam suffix string The suffix of the person. Max 255 characters. Example: Jr.
     * @bodyParam can_be_deleted boolean Whether the person can be deleted. 0 for false, 1 for true. Example: 1
     *
     * @response 200 {
     *  "id": 4,
     *  "object": "person",
     *  "name": "Ross Geller",
     *  "first_name": "Ross",
     *  "last_name": "Geller",
     *  "middle_name": "Gary",
     *  "nickname": "Bear",
     *  "maiden_name": "Johnson",
     *  "prefix": "Mr.",
     *  "suffix": "Jr.",
     *  "can_be_deleted": 1,
     *  "created_at": 1514764800,
     *  "updated_at": 1514764800,
     * }
     *
     * @responseField id Unique identifier for the object.
     * @responseField object The object type. Always "person".
     * @responseField name The display name of the person.
     * @responseField first_name The first name of the person.
     * @responseField last_name The last name of the person.
     * @responseField middle_name The middle name of the person.
     * @responseField nickname The nickname of the person.
     * @responseField maiden_name The maiden name of the person.
     * @responseField prefix The prefix of the person.
     * @responseField suffix The suffix of the person.
     * @responseField can_be_deleted Whether the person can be deleted.
     * @responseField created_at The date the object was created. Represented as a Unix timestamp.
     * @responseField updated_at The date the object was last updated. Represented as a Unix timestamp.
     */
    public function update(Request $request): PersonResource
    {
        $person = $request->attributes->get('person');

        $validated = $request->validate([
            'gender_id' => 'nullable|exists:genders,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'nickname' => 'nullable|string|max:255',
            'maiden_name' => 'nullable|string|max:255',
            'patronymic_name' => 'nullable|string|max:255',
            'tribal_name' => 'nullable|string|max:255',
            'prefix' => 'nullable|string|max:255',
            'suffix' => 'nullable|string|max:255',
            'can_be_deleted' => 'boolean',
        ]);

        $person = (new UpdatePerson(
            user: Auth::user(),
            person: $person,
            gender: $validated['gender_id'] ? Gender::find($validated['gender_id']) : null,
            firstName: $validated['first_name'],
            lastName: $validated['last_name'],
            middleName: $validated['middle_name'],
            nickname: $validated['nickname'],
            maidenName: $validated['maiden_name'],
            prefix: $validated['prefix'],
            suffix: $validated['suffix'],
            canBeDeleted: $validated['can_be_deleted'],
        ))->execute();

        return new PersonResource($person);
    }

    /**
     * Delete a person.
     *
     * @urlParam person required The id of the person. Example: 1
     *
     * @response 204
     */
    public function destroy(Request $request): Response
    {
        $person = $request->attributes->get('person');

        try {
            (new DestroyPerson(
                user: Auth::user(),
                person: $person,
            ))->execute();
        } catch (ModelNotFoundException) {
            return response()->noContent(404);
        } catch (RuntimeException) {
            return response()->noContent(403);
        }

        return response()->noContent();
    }

    /**
     * Retrieve a person.
     *
     * @urlParam person required The id of the person. Example: 1
     *
     * @response 200 {
     *   "id": 1,
     *   "object": "person",
     *   "name": "Ross Geller",
     *   "first_name": "Ross",
     *   "last_name": "Geller",
     *   "middle_name": "Gary",
     *   "nickname": "Bear",
     *   "maiden_name": "Johnson",
     *   "prefix": "Mr.",
     *   "suffix": "Jr.",
     *   "can_be_deleted": true,
     *   "created_at": 1514764800,
     *   "updated_at": 1514764800
     * }
     *
     * @responseField id Unique identifier for the contact.
     * @responseField object The object type. Always "person".
     * @responseField name The full name of the person.
     * @responseField first_name The first name of the person.
     * @responseField last_name The last name of the person.
     * @responseField middle_name The middle name of the person.
     * @responseField nickname The nickname of the person.
     * @responseField maiden_name The maiden name of the person.
     * @responseField prefix The prefix of the person.
     * @responseField suffix The suffix of the person.
     * @responseField can_be_deleted Whether the person can be deleted.
     * @responseField created_at The date the person was created. Represented as a Unix timestamp.
     * @responseField updated_at The date the person was last updated. Represented as a Unix timestamp.
     */
    public function show(Request $request): PersonResource
    {
        $person = $request->attributes->get('person');

        return new PersonResource($person);
    }

    /**
     * List all persons.
     *
     * This API call returns a paginated collection of persons that contains
     * 15 items per page.
     *
     * @response 200 {"data": [{
     *  "id": 4,
     *  "object": "person",
     *  "name": "Ross Geller",
     *  "first_name": "Ross",
     *  "last_name": "Geller",
     *  "middle_name": "Gary",
     *  "nickname": "Bear",
     *  "maiden_name": "Johnson",
     *  "prefix": "Mr.",
     *  "suffix": "Jr.",
     *  "can_be_deleted": true,
     *  "created_at": 1514764800,
     *  "updated_at": 1514764800
     * }, {
     *  "id": 5,
     *  "object": "person",
     *  "name": "Monica Geller",
     *  "first_name": "Monica",
     *  "last_name": "Geller",
     *  "middle_name": "Geller",
     *  "nickname": "Mon",
     *  "maiden_name": "Geller",
     *  "prefix": "Ms.",
     *  "suffix": "Sr.",
     *  "can_be_deleted": true,
     *  "created_at": 1514764800,
     *  "updated_at": 1514764800
     * },
     * "links": {
     *   "first": "http://peopleos.test/api/persons?page=1",
     *   "last": "http://peopleos.test/api/persons?page=1",
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
     *        "url": "http://peopleos.test/api/persons?page=1",
     *        "label": "1",
     *        "active": true
     *      },
     *      {
     *        "url": null,
     *        "label": "Next &raquo;",
     *        "active": false
     *      }
     *    ],
     *    "path": "http://peopleos.test/api/persons",
     *    "per_page": 15,
     *    "to": 1,
     *    "total": 1
     *  }
     *
     * @responseField id Unique identifier for the object.
     * @responseField object The object type. Always "person".
     * @responseField name The display name of the person.
     * @responseField first_name The first name of the person.
     * @responseField last_name The last name of the person.
     * @responseField middle_name The middle name of the person.
     * @responseField nickname The nickname of the person.
     * @responseField maiden_name The maiden name of the person.
     * @responseField prefix The prefix of the person.
     * @responseField suffix The suffix of the person.
     * @responseField can_be_deleted Whether the person can be deleted.
     * @responseField created_at The date the object was created. Represented as a Unix timestamp.
     * @responseField updated_at The date the object was last updated. Represented as a Unix timestamp.
     */
    public function index(Request $request): PersonCollection
    {
        $persons = Person::where('account_id', Auth::user()->account_id)
            ->with('gender')
            ->paginate();

        return new PersonCollection($persons);
    }
}
