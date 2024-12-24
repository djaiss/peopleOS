<?php

namespace App\Http\ViewModels\Vaults\Contacts;

use App\Models\Child;
use App\Models\Contact;
use App\Models\Partner;
use Illuminate\Support\Collection;

class ContactPartnerViewModel
{
    /**
     * Get all the partners of a given contact.
     */
    public static function index(Contact $contact): Collection
    {
        $partners = $contact->partners()
            ->with('maritalStatus')
            ->get()
            ->map(fn (Partner $partner) => self::partner($partner));

        return $partners;
    }

    /**
     * Get the detail of a single child.
     */
    public static function partner(Partner $partner): array
    {
        return [
            'id' => $partner->id,
            'name' => $partner->name,
            'marital_status' => [
                'id' => $partner->maritalStatus->id,
                'label' => $partner->maritalStatus->getLabel(),
            ],
            'occupation' => $partner->occupation,
            'number_of_years_together' => $partner->number_of_years_together,
        ];
    }
}
