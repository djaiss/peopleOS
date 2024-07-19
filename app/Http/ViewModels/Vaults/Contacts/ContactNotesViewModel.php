<?php

namespace App\Http\ViewModels\Vaults\Contacts;

use App\Models\Contact;
use App\Models\Note;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

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
            ->map(fn (Note $note) => self::note($note));

        return $notes;
    }

    /**
     * Get the detail of a single note.
     */
    public static function note(Note $note): array
    {
        return [
            'id' => $note->id,
            'body' => Str::of($note->body)->markdown([
                'html_input' => 'strip',
            ]),
            'body_raw' => $note->body,
            'created_at' => $note->created_at->format('F d, Y (l)'),
            'created_at_full_timestamp' => $note->created_at->format('Y-m-d H:i:s'),
            'user' => [
                'id' => $note->user_id,
                'name' => $note->user->first_name,
            ],
        ];
    }
}
