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
        $children = $contact->children()
            ->get()
            ->map(fn (Child $child) => self::child($child));

        return $children;
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
            'age' => $child->age,
            'grade_level' => $child->grade_level,
            'school' => $child->school,
        ];
    }
}
