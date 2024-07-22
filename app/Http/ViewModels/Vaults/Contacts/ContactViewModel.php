<?php

namespace App\Http\ViewModels\Vaults\Contacts;

use App\Models\Company;
use App\Models\Contact;
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
                    'url' => [
                        'show' => route('vaults.contacts.show', [
                            'vault' => $vault->id,
                            'slug' => $contact->slug,
                        ]),
                    ],
                ];
            })
            ->sortBy('name')
            ->values();

        return $contacts;
    }

    public static function show(Contact $contact): array
    {
        return [
            'id' => $contact->id,
            'name' => $contact->name,
            'avatar' => $contact->avatar,
            'slug' => $contact->slug,
            'background_information' => $contact->background_information,
            'job_title' => $contact->job_title,
            'company' => [
                'name' => $contact->company?->name,
                'url' => '',
            ],
            'existing_companies' => self::companies($contact->vault) ?? collect(),
        ];
    }

    /**
     * List all the companies in the vault. This is used to populate the
     * dropdown in the edit job information form.
     */
    public static function companies(Vault $vault): Collection
    {
        return $vault->companies()
            ->get()
            ->map(fn (Company $company) => [
                'id' => $company->id,
                'name' => $company->name,
            ])
            ->sortBy('name')
            ->values();
    }
}
