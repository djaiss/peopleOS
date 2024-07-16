<?php

namespace App\Http\ViewModels\Vaults\Contacts;

use App\Models\Contact;
use App\Models\Note;
use Illuminate\Support\Collection;

class ContactNotesViewModel
{
    /**
     * Get all the notes of a given contact.
     */
    public static function index(Contact $contact): Collection
    {
        $notes = $contact->notes()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(fn (Note $note) => [
                'id' => $note->id,
                'body' => $note->body,
                'created_at' => $note->created_at->diffForHumans(),
                'user' => [
                    'id' => $note->user_id,
                    'name' => $note->user->first_name,
                ],
            ]);

        return $notes;
    }
}
