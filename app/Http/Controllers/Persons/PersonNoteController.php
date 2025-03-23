<?php

declare(strict_types=1);

namespace App\Http\Controllers\Persons;

use App\Cache\PeopleListCache;
use App\Http\Controllers\Controller;
use App\Models\Note;
use App\Services\CreateNote;
use App\Services\DestroyNote;
use App\Services\UpdateNote;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PersonNoteController extends Controller
{
    public function index(Request $request): View
    {
        $person = $request->attributes->get('person');

        $persons = PeopleListCache::make(
            accountId: Auth::user()->account_id,
        )->value();

        $notes = Note::where('person_id', $person->id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(fn (Note $note): array => [
                'id' => $note->id,
                'content' => $note->content,
                'created_at' => $note->created_at->format('M j, Y'),
                'is_new' => false,
            ]);

        return view('persons.notes.index', [
            'notes' => $notes,
            'persons' => $persons,
            'person' => $person,
        ]);
    }

    public function create(Request $request): RedirectResponse
    {
        $person = $request->attributes->get('person');

        $validated = $request->validate([
            'content' => 'required|string|min:3|max:20000',
        ]);

        (new CreateNote(
            user: Auth::user(),
            person: $person,
            content: $validated['content'],
        ))->execute();

        return redirect()->route('person.note.index', $person->slug)
            ->with('status', __('Note created'));
    }

    public function edit(Request $request): View
    {
        $person = $request->attributes->get('person');
        $note = $request->attributes->get('note');

        return view('persons.notes.partials.edit', [
            'person' => $person,
            'note' => $note,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $person = $request->attributes->get('person');
        $note = $request->attributes->get('note');

        $validated = $request->validate([
            'content' => 'required|string|min:3|max:20000',
        ]);

        (new UpdateNote(
            user: Auth::user(),
            note: $note,
            content: $validated['content'],
        ))->execute();

        return redirect()->route('person.note.index', $person->slug)
            ->with('status', __('Note updated'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        $person = $request->attributes->get('person');
        $note = $request->attributes->get('note');

        (new DestroyNote(
            user: Auth::user(),
            note: $note,
        ))->execute();

        return redirect()->route('person.note.index', $person->slug)
            ->with('status', __('Note deleted'));
    }
}
