<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Persons;

use App\Http\Controllers\Controller;
use App\Http\Resources\NoteCollection;
use App\Http\Resources\NoteResource;
use App\Models\Note;
use App\Services\CreateNote;
use App\Services\DestroyNote;
use App\Services\UpdateNote;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class PersonNoteController extends Controller
{
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

    public function show(Request $request): NoteResource
    {
        $note = $request->attributes->get('note');

        return new NoteResource($note);
    }

    public function index(Request $request): NoteCollection
    {
        $person = $request->attributes->get('person');

        $notes = Note::where('person_id', $person->id)
            ->paginate();

        return new NoteCollection($notes);
    }
}
