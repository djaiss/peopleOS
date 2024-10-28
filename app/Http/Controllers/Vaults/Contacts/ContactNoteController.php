<?php

namespace App\Http\Controllers\Vaults\Contacts;

use App\Cache\ContactNotesCache;
use App\Http\Controllers\Controller;
use App\Http\ViewModels\Vaults\Contacts\ContactNotesViewModel;
use App\Http\ViewModels\Vaults\Contacts\ContactViewModel;
use App\Services\CreateNote;
use App\Services\DestroyNote;
use App\Services\UpdateNote;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactNoteController extends Controller
{
    public function store(Request $request): View
    {
        $contact = $request->attributes->get('contact');

        $validated = $request->validate([
            'body' => 'required|string|max:1000',
        ]);

        (new CreateNote(
            user: auth()->user(),
            contact: $contact,
            body: $validated['body'],
        ))->execute();

        $vault = $request->attributes->get('vault');
        $notes = ContactNotesViewModel::index($contact);
        $contact = ContactViewModel::show($contact);
        return view('vaults.contacts.partials.notes', [
            'vault' => $vault,
            'contact' => $contact,
            'notes' => $notes,
        ]);
    }

    public function update(Request $request): View
    {
        $contact = $request->attributes->get('contact');
        $note = $request->route()->parameter('note');

        try {
            $note = $contact->notes()->findOrFail($note);
        } catch (ModelNotFoundException) {
            abort(404);
        }

        $validated = $request->validate([
            'body' => 'required|string|max:1000',
        ]);

        $note = (new UpdateNote(
            user: auth()->user(),
            note: $note,
            body: $validated['body'],
        ))->execute();

        ContactNotesCache::make(
            contact: $contact,
        )->refresh();

        $vault = $request->attributes->get('vault');
        $contact = ContactViewModel::show($contact);

        return view('vaults.contacts.partials.note', [
            'vault' => $vault,
            'contact' => $contact,
            'note' => ContactNotesViewModel::note($note),
        ]);
    }

    public function destroy(Request $request): void
    {
        $contact = $request->attributes->get('contact');
        $note = $request->route()->parameter('note');

        try {
            $note = $contact->notes()->findOrFail($note);
        } catch (ModelNotFoundException) {
            abort(404);
        }

        (new DestroyNote(
            user: auth()->user(),
            note: $note,
        ))->execute();

        ContactNotesCache::make(
            contact: $contact,
        )->refresh();
    }
}
