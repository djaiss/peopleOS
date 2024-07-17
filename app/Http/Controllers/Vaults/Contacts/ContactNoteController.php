<?php

namespace App\Http\Controllers\Vaults\Contacts;

use App\Cache\ContactNoteCache;
use App\Http\Controllers\Controller;
use App\Services\CreateNote;
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
}
