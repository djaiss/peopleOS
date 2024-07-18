<?php

namespace App\Http\Controllers\Vaults\Contacts;

use App\Cache\ContactNoteCache;
use App\Http\Controllers\Controller;
use App\Http\ViewModels\Vaults\Contacts\ContactNotesViewModel;
use App\Services\CreateNote;
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

        $notes = ContactNoteCache::make(
            contact: $contact,
        )->refresh();

        return view('vaults.contacts.partials.notes', [
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

        ContactNoteCache::make(
            contact: $contact,
        )->refresh();

        return view('vaults.contacts.partials.note', [
            'note' => ContactNotesViewModel::note($note),
        ]);
    }
}
