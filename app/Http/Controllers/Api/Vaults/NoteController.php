<?php

namespace App\Http\Controllers\Api\Vaults;

use App\Http\Controllers\Controller;
use App\Http\Resources\NoteCollection;
use App\Http\Resources\NoteResource;
use App\Models\Note;
use App\Services\CreateNote;
use App\Services\DestroyNote;
use App\Services\UpdateNote;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @group Notes
 *
 * Notes are a way to add additional information to a contact. You can have as
 * many notes as you want for a contact. We support markdown formatting, so it's
 * up to the client to render it properly, as the body might contain markdown in
 * the response.
 */
class NoteController extends Controller
{
    /**
     * Create a note.
     *
     * @urlParam vault required The id of the vault. Example: 1
     * @urlParam contact required The id of the contact. Example: 1
     *
     * @bodyParam body string required The body of the note. Example: This is a note.
     *
     * @response 201 {
     *  "id": 1,
     *  "object": "note",
     *  "contact": {
     *      "id": 1,
     *      "name": "Dwight Schrute",
     *  },
     *  "body": "This is a note.",
     *  "created_at": 1718982400,
     *  "updated_at": 1718982400,
     * }
     *
     * @responseField id Unique identifier for the object.
     * @responseField object The object type. Always "note".
     * @responseField contact The contact object.
     * @responseField body The body of the note.
     * @responseField created_at The date the object was created. Represented as a Unix timestamp.
     * @responseField updated_at The date the object was last updated. Represented as a Unix timestamp.
     */
    public function create(Request $request)
    {
        $contact = $request->attributes->get('contact');

        $validated = $request->validate([
            'body' => 'required|string|max:65535',
        ]);

        $note = (new CreateNote(
            user: Auth::user(),
            contact: $contact,
            body: $validated['body'],
        ))->execute();

        return new NoteResource($note);
    }

    /**
     * Update a note.
     *
     * @urlParam vault required The id of the vault. Example: 1
     * @urlParam contact required The id of the contact. Example: 1
     * @urlParam note required The id of the note. Example: 1
     *
     * @bodyParam body string required The body of the note. Example: This is a note.
     *
     * @response 200 {
     *  "id": 1,
     *  "object": "note",
     *  "contact": {
     *      "id": 1,
     *      "name": "Dwight Schrute",
     *  },
     *  "body": "This is a note.",
     *  "created_at": 1718982400,
     *  "updated_at": 1718982400,
     * }
     *
     * @responseField id Unique identifier for the object.
     * @responseField object The object type. Always "note".
     * @responseField contact The contact object.
     * @responseField body The body of the note.
     * @responseField created_at The date the object was created. Represented as a Unix timestamp.
     * @responseField updated_at The date the object was last updated. Represented as a Unix timestamp.
     */
    public function update(Request $request)
    {
        $contact = $request->attributes->get('contact');
        $note = $request->route()->parameter('note');

        $validated = $request->validate([
            'body' => 'required|string|max:65535',
        ]);

        try {
            $note = Note::where('contact_id', $contact->id)
                ->findOrFail($note);
        } catch (ModelNotFoundException) {
            abort(401);
        }

        $note = (new UpdateNote(
            user: Auth::user(),
            note: $note,
            body: $validated['body'],
        ))->execute();

        return new NoteResource($note);
    }

    /**
     * Delete a note.
     *
     * @urlParam vault required The id of the vault. Example: 1
     * @urlParam contact required The id of the contact. Example: 1
     * @urlParam note required The id of the note. Example: 1
     *
     * @response 200 {
     *  "status": "success"
     * }
     */
    public function destroy(Request $request)
    {
        $contact = $request->attributes->get('contact');
        $note = $request->route()->parameter('note');

        try {
            $note = Note::where('contact_id', $contact->id)
                ->findOrFail($note);
        } catch (ModelNotFoundException) {
            abort(401);
        }

        (new DestroyNote(
            user: Auth::user(),
            note: $note,
        ))->execute();

        return response()->json([
            'status' => 'success',
        ], 200);
    }

    /**
     * Retrieve a note.
     *
     * @urlParam vault required The id of the vault. Example: 1
     * @urlParam contact required The id of the contact. Example: 1
     * @urlParam note required The id of the note. Example: 1
     *
     * @response 200 {
     *   "id": 1,
     *   "object": "note",
     *   "contact": {
     *      "id": 1,
     *      "name": "Dwight Schrute",
     *   },
     *   "body": "This is a note.",
     *   "created_at": 1514764800,
     *   "updated_at": 1514764800
     * }
     *
     * @responseField id Unique identifier for the object.
     * @responseField object The object type. Always "note".
     * @responseField body The body of the note.
     * @responseField created_at The date the object was created. Represented as a Unix timestamp.
     * @responseField updated_at The date the object was last updated. Represented as a Unix timestamp.
     */
    public function show(Request $request)
    {
        $contact = $request->attributes->get('contact');
        $note = $request->route()->parameter('note');

        try {
            $note = Note::where('contact_id', $contact->id)
                ->findOrFail($note);
        } catch (ModelNotFoundException) {
            abort(401);
        }

        return new NoteResource($note);
    }

    /**
     * List all notes.
     *
     * This will list all the notes.
     *
     * @urlParam vault required The id of the vault. Example: 1
     * @urlParam contact required The id of the contact. Example: 1
     *
     * @response 200 [{
     *  "id": 4,
     *  "object": "note",
     *  "contact": {
     *      "id": 1,
     *      "name": "Dwight Schrute",
     *  },
     *  "body": "This is a note.",
     *  "created_at": 1718982400,
     * }, {
     *  "id": 5,
     *  "object": "note",
     *  "contact": {
     *      "id": 1,
     *      "name": "Dwight Schrute",
     *  },
     *  "body": "This is another note.",
     *  "created_at": 1718982400,
     *  "updated_at": 1718982400,
     * }]
     *
     * @responseField id Unique identifier for the object.
     * @responseField object The object type. Always "note".
     * @responseField contact The contact object.
     * @responseField body The body of the note.
     * @responseField created_at The date the object was created. Represented as a Unix timestamp.
     * @responseField updated_at The date the object was last updated. Represented as a Unix timestamp.
     */
    public function index(Request $request)
    {
        $contact = $request->attributes->get('contact');

        $notes = $contact->notes()
            ->with('contact')
            ->paginate();

        return new NoteCollection($notes);
    }
}
