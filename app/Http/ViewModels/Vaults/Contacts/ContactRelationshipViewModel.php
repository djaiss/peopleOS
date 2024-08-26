<?php

namespace App\Http\ViewModels\Vaults\Contacts;

use App\Models\Child;
use App\Models\Contact;

class ContactRelationshipViewModel
{
    /**
     * Get all the children of a given contact.
     */
    public static function index(Contact $contact): array
    {
        $children = $contact->children()
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(fn (Child $child) => self::child($child));

        return [
            'children' => $children,
        ];
    }

    /**
     * Get the detail of a single child.
     */
    public static function child(Child $child): array
    {
        return [
            'id' => $child->id,
            'name' => $child->name,
            'gender' => $child->gender,
        ];
    }
}
