<?php

namespace App\Http\Controllers\Vaults\Contacts;

use App\Cache\ContactInformationCache;
use App\Http\Controllers\Controller;
use App\Http\ViewModels\Vaults\Contacts\ContactViewModel;
use App\Services\UpdateBackgroundInformation;
use App\Services\UpdateJobInformation;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactJobInformationController extends Controller
{
    public function update(Request $request): View
    {
        $contact = $request->attributes->get('contact');

        $validated = $request->validate([
            'job_title' => 'required|string|max:1000',
            'company_name' => 'required|string|max:1000',
        ]);

        (new UpdateJobInformation(
            user: auth()->user(),
            contact: $contact,
            companyName: $validated['company_name'],
            jobTitle: $validated['job_title'],
        ))->execute();

        $vault = $request->attributes->get('vault');

        $contact = ContactInformationCache::make(
            user: auth()->user(),
            contact: $contact,
        )->refresh();

        return view('vaults.contacts.partials.job_information', [
            'vault' => $vault,
            'contact' => $contact,
            'companies' => $contact['existing_companies'],
        ]);
    }
}
