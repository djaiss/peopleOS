<?php

namespace App\Http\Controllers\Vaults\Contacts;

use App\Http\Controllers\Controller;
use App\Http\ViewModels\Vaults\Contacts\ContactViewModel;
use App\Services\UpdateBackgroundInformation;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactBackgroundInformationController extends Controller
{
    public function update(Request $request): View
    {
        $contact = $request->attributes->get('contact');

        $validated = $request->validate([
            'information' => 'required|string|max:1000',
        ]);

        (new UpdateBackgroundInformation(
            user: auth()->user(),
            contact: $contact,
            information: $validated['information'],
        ))->execute();

        $vault = $request->attributes->get('vault');
        $contact = ContactViewModel::show($contact);

        return view('vaults.contacts.partials.background_information', [
            'vault' => $vault,
            'contact' => $contact,
        ]);
    }
}
