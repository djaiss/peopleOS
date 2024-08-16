<?php

namespace App\Http\ViewModels\Vaults\Contacts;

use App\Models\Child;
use App\Models\Contact;
use Illuminate\Support\Collection;

class ContactChildrenViewModel
{
    /**
     * Get all the children of a given contact.
     */
    public static function index(Contact $contact): Collection
    {
        $notes = $contact->notes()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(fn (Child $child) => self::child($child));

        return $notes;
    }

    /**
     * Get the detail of a single child.
     */
    public static function child(Child $child): array
    {
        return [
            'id' => $child->id,
            'name' => $child->name,
        ];
    }
}
