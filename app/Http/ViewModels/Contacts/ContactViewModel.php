<?php

namespace App\Http\ViewModels\Contacts;

use App\Models\Contact;
use App\Models\User;
use App\Models\Vault;
use Illuminate\Support\Collection;

class ContactViewModel
{
    public static function index(Vault $vault): Collection
    {
        $contacts = $vault->contacts()
            ->get()
            ->map(function (Contact $contact) use ($vault): array {
                return [
                'id' => $contact->id,
                'name' => $contact->name,
                'avatar' => $contact->avatar,
                'url' => [
                    'show' => route('contact.show', [
                        'vault' => $vault->id,
                        'contact' => $contact->id,
                    ]),
                ],
                ];
            });

        return $contacts;
    }
}
