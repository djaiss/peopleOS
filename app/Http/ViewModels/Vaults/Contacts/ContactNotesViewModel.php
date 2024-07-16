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
            ->orderBy('created_at')
            ->get()
            ->map(function (Note $note): array {
                return [
                    'id' => $note->id,
                    'body' => $note->body,
                    'user' => [
                        'id' => $note->user_id,
                        'name' => $note->user->name,
                    ],
                ];
            });

        return $notes;
    }
}
