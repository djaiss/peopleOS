<?php

namespace App\Http\Controllers\Api\Vaults;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Vault;
use App\Services\UpdateJobInformation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @group Contacts
 */
class ContactJobInformationController extends Controller
{
    /**
     * Update a contact's job information.
     *
     * A contact can have one job, linked to a company. You don't need to
     * manually create the company, it will be created if it doesn't exist. This
     * check is done based on the company name.
     *
     * If you want a more granular control over the company itself, you can
     * use the dedicated company endpoints.
     *
     * @urlParam vault required The id of the vault. Example: 1
     * @urlParam contact required The id of the contact. Example: 1
     *
     * @bodyParam job_title string required The job title of the contact. Max 255 characters. Example: CEO
     * @bodyParam company_name string required The name of the company. Max 255 characters. Example: Dunder Mifflin
     *
     * @response 200 {
     *  "id": 4,
     *  "object": "contact",
     *  "name": "Michael Scott",
     *  "job_title": "CEO",
     *  "company": {
     *     "id": 1,
     *     "name": "Dunder Mifflin"
     *  }
     * }
     */
    public function update(Request $request): JsonResponse
    {
        $vault = $request->attributes->get('vault');
        $contact = $request->attributes->get('contact');

        $validated = $request->validate([
            'job_title' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
        ]);

        $company = (new UpdateJobInformation(
            user: auth()->user(),
            contact: $contact,
            companyName: $validated['company_name'],
            jobTitle: $validated['job_title'],
        ))->execute();

        return response()->json([
            'id' => $contact->id,
            'object' => 'contact',
            'name' => $contact->name,
            'job_title' => $contact->job_title,
            'company' => [
                'id' => $company->id,
                'name' => $company->name,
            ],
        ], 200);
    }
}
