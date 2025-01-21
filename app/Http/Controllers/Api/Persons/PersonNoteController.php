<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Persons;

use App\Http\Controllers\Controller;
use App\Http\Resources\NoteCollection;
use App\Http\Resources\NoteResource;
use App\Models\Note;
use App\Models\Person;
use App\Services\CreateNote;
use App\Services\DestroyNote;
use App\Services\UpdateNote;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

/**
 * @group Notes
 */
class PersonNoteController extends Controller
{
    /**
     * Create a note.
     *
     * A note is a piece of information that you want to keep about a person.
     *
     * @urlParam person required The id of the person. Example: 1
     *
     * @bodyParam content string required The content of the note. Max 255 characters. Example: Ross is a good friend of mine.
     *
     * @response 201 {
     *  "id": 4,
     *  "object": "note",
     *  "content": "Ross is a good friend of mine.",
     *  "created_at": 1514764800,
     *  "updated_at": 1514764800,
     * }
     *
     * @responseField id Unique identifier for the object.
     * @responseField object The object type. Always "note".
     * @responseField content The content of the note.
     * @responseField created_at The date the object was created. Represented as a Unix timestamp.
     * @responseField updated_at The date the object was last updated. Represented as a Unix timestamp.
     */
    public function create(Request $request): NoteResource
    {
        $person = $request->attributes->get('person');

        $validated = $request->validate([
            'content' => 'required|string|max:255',
        ]);

        $note = (new CreateNote(
            user: Auth::user(),
            person: $person,
            content: $validated['content'],
        ))->execute();

        return new NoteResource($note);
    }

    /**
     * Update a note.
     *
     * Updates an existing note.
     *
     * Once updated, the note will be returned in the response.
     *
     * @urlParam person required The id of the person. Example: 1
     *
     * @bodyParam content string required The content of the note. Max 255 characters. Example: Ross is a good friend of mine.
     *
     * @response 200 {
     *  "id": 4,
     *  "object": "note",
     *  "content": "Ross is a good friend of mine.",
     *  "created_at": 1514764800,
     *  "updated_at": 1514764800,
     * }
     *
     * @responseField id Unique identifier for the object.
     * @responseField object The object type. Always "note".
     * @responseField content The content of the note.
     * @responseField created_at The date the object was created. Represented as a Unix timestamp.
     * @responseField updated_at The date the object was last updated. Represented as a Unix timestamp.
     */
    public function update(Request $request): NoteResource
    {
        $note = $request->attributes->get('note');

        $validated = $request->validate([
            'content' => 'required|string|max:255',
        ]);

        $note = (new UpdateNote(
            user: Auth::user(),
            note: $note,
            content: $validated['content'],
        ))->execute();

        return new NoteResource($note);
    }

    /**
     * Delete a note.
     *
     * @urlParam person required The id of the person. Example: 1
     * @urlParam note required The id of the note. Example: 1
     *
     * @response 204
     */
    public function destroy(Request $request): Response
    {
        $note = $request->attributes->get('note');

        try {
            (new DestroyNote(
                user: Auth::user(),
                note: $note,
            ))->execute();
        } catch (Exception) {
            return response()->noContent(404);
        }

        return response()->noContent();
    }

    /**
     * Retrieve a note.
     *
     * @urlParam person required The id of the person. Example: 1
     * @urlParam note required The id of the note. Example: 1
     *
     * @response 200 {
     *   "id": 1,
     *   "object": "note",
     *   "content": "Ross is a good friend of mine.",
     *   "created_at": 1514764800,
     *   "updated_at": 1514764800,
     * }
     *
     * @responseField id Unique identifier for the object.
     * @responseField object The object type. Always "note".
     * @responseField content The content of the note.
     * @responseField created_at The date the object was created. Represented as a Unix timestamp.
     * @responseField updated_at The date the object was last updated. Represented as a Unix timestamp.
     */
    public function show(Request $request): NoteResource
    {
        $note = $request->attributes->get('note');

        return new NoteResource($note);
    }

    /**
     * List all notes.
     *
     * This API call returns a paginated collection of notes that contains
     * 15 items per page.
     *
     * @urlParam person required The id of the person. Example: 1
     *
     * @response 200 {"data": [{
     *  "id": 4,
     *  "object": "note",
     *  "content": "Ross is a good friend of mine.",
     *  "created_at": 1514764800,
     *  "updated_at": 1514764800,
     * }, {
     *  "id": 5,
     *  "object": "note",
     *  "content": "Monica is a good friend of mine.",
     *  "created_at": 1514764800,
     *  "updated_at": 1514764800
     * },
     * "links": {
     *   "first": "http://peopleos.test/api/persons/1/notes?page=1",
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
     *        "url": "http://peopleos.test/api/persons/1/notes?page=1",
     *        "label": "1",
     *        "active": true
     *      },
     *      {
     *        "url": null,
     *        "label": "Next &raquo;",
     *        "active": false
     *      }
     *    ],
     *    "path": "http://peopleos.test/api/persons/1/notes",
     *    "per_page": 15,
     *    "to": 1,
     *    "total": 1
     *  }
     *
     * @responseField id Unique identifier for the object.
     * @responseField object The object type. Always "note".
     * @responseField content The content of the note.
     * @responseField created_at The date the object was created. Represented as a Unix timestamp.
     * @responseField updated_at The date the object was last updated. Represented as a Unix timestamp.
     */
    public function index(Request $request): NoteCollection
    {
        $person = $request->attributes->get('person');

        $notes = Note::where('person_id', $person->id)
            ->paginate();

        return new NoteCollection($notes);
    }
}
