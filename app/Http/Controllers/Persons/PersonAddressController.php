<?php

declare(strict_types=1);

namespace App\Http\Controllers\Persons;

use App\Http\Controllers\Controller;
use App\Services\CreateAddress;
use App\Services\DestroyAddress;
use App\Services\GetAddressesListing;
use App\Services\UpdateAddress;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PersonAddressController extends Controller
{
    public function index(Request $request): View
    {
        $person = $request->attributes->get('person');

        $viewData = (new GetAddressesListing(
            user: Auth::user(),
            person: $person,
        ))->execute();

        return view('persons.addresses.index', $viewData);
    }

    public function new(Request $request): View
    {
        $person = $request->attributes->get('person');

        return view('persons.addresses.partials.address-add', [
            'person' => $person,
        ]);
    }

    public function create(Request $request): RedirectResponse
    {
        $person = $request->attributes->get('person');

        $validated = $request->validate([
            'address_line_1' => 'nullable|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        (new CreateAddress(
            user: Auth::user(),
            person: $person,
            addressLine1: $validated['address_line_1'] ?? null,
            addressLine2: $validated['address_line_2'] ?? null,
            city: $validated['city'] ?? null,
            state: $validated['state'] ?? null,
            postalCode: $validated['postal_code'] ?? null,
            country: $validated['country'] ?? null,
            isActive: $validated['is_active'] ?? true,
        ))->execute();

        return redirect()->route('person.address.index', $person->slug)
            ->with('status', __('Address created'));
    }

    public function edit(Request $request): View
    {
        $person = $request->attributes->get('person');
        $address = $request->attributes->get('address');

        return view('persons.addresses.partials.address-edit', [
            'person' => $person,
            'address' => $address,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $person = $request->attributes->get('person');
        $address = $request->attributes->get('address');

        $validated = $request->validate([
            'address_line_1' => 'nullable|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        (new UpdateAddress(
            user: Auth::user(),
            address: $address,
            addressLine1: $validated['address_line_1'] ?? null,
            addressLine2: $validated['address_line_2'] ?? null,
            city: $validated['city'] ?? null,
            state: $validated['state'] ?? null,
            postalCode: $validated['postal_code'] ?? null,
            country: $validated['country'] ?? null,
            isActive: $validated['is_active'] ?? null,
        ))->execute();

        return redirect()->route('person.address.index', $person->slug)
            ->with('status', __('Address updated'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        $person = $request->attributes->get('person');
        $address = $request->attributes->get('address');

        (new DestroyAddress(
            user: Auth::user(),
            address: $address,
        ))->execute();

        return redirect()->route('person.address.index', $person->slug)
            ->with('status', __('Address deleted'));
    }
}
