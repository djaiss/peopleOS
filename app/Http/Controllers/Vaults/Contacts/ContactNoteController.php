<?php

namespace App\Http\Controllers\Vaults\Contacts;

use App\Cache\ContactListCache;
use App\Http\Controllers\Controller;
use App\Http\ViewModels\Vaults\Contacts\ContactNotesViewModel;
use App\Http\ViewModels\Vaults\Contacts\ContactViewModel;
use App\Services\CreateContact;
use App\Services\CreateNote;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactNoteController extends Controller
{
    public function store(Request $request): string
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

        return view('vaults.contacts.show', [
            'vault' => $vault,
            'notes' => ContactNotesViewModel::index($contact),
        ])->fragment('notes-list');
    }
}
