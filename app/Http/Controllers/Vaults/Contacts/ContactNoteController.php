<?php

namespace App\Http\Controllers\Vaults\Contacts;

use App\Http\Controllers\Controller;
use App\Http\ViewModels\Vaults\Contacts\ContactNotesViewModel;
use App\Services\CreateNote;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactNoteController extends Controller
{
    public function store(Request $request): View
    {
        $vault = $request->attributes->get('vault');
        $contact = $request->attributes->get('contact');

        $validated = $request->validate([
            'body' => 'required|string|max:1000',
        ]);

        (new CreateNote(
            user: auth()->user(),
            contact: $contact,
            body: $validated['body'],
        ))->execute();

        return view('vaults.contacts.partials.notes', [
            'notes' => ContactNotesViewModel::index($contact),
        ]);
    }
}
