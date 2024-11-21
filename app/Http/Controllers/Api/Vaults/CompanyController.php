<?php

namespace App\Http\Controllers\Api\Vaults;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Vault;
use App\Services\CreateCompany;
use App\Services\DestroyCompany;
use App\Services\UpdateCompany;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @group Companies
 */
class CompanyController extends Controller
{
    /**
     * Create a company.
     *
     * @urlParam vault required The id of the vault. Example: 1
     *
     * @bodyParam name string required The name of the company. Max 255 characters. Example: Dunder Mifflin
     *
     * @response 201 {
     *  "id": 1,
     *  "object": "company",
     *  "name": "Dunder Mifflin",
     * }
     */
    public function create(Request $request): JsonResponse
    {
        $vault = $request->attributes->get('vault');

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $company = (new CreateCompany(
            user: Auth::user(),
            vault: $vault,
            name: $validated['name'],
        ))->execute();

        return response()->json([
            'id' => $company->id,
            'object' => 'company',
            'name' => $company->name,
        ], 201);
    }

    /**
     * Update a company.
     *
     * @urlParam vault required The id of the vault. Example: 1
     * @urlParam company required The id of the company. Example: 1
     *
     * @bodyParam name string required The name of the company. Max 255 characters. Example: Dunder Mifflin
     *
     * @response 200 {
     *  "id": 1,
     *  "object": "company",
     *  "name": "Dunder Mifflin",
     * }
     */
    public function update(Request $request): JsonResponse
    {
        $vault = $request->attributes->get('vault');
        $company = $request->route()->parameter('company');

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        try {
            $company = Company::where('vault_id', $vault->id)
                ->findOrFail($company);
        } catch (ModelNotFoundException) {
            abort(401);
        }

        $company = (new UpdateCompany(
            user: Auth::user(),
            company: $company,
            name: $validated['name'],
        ))->execute();

        return response()->json([
            'id' => $company->id,
            'object' => 'company',
            'name' => $company->name,
        ], 200);
    }

    /**
     * Delete a company.
     *
     * @urlParam vault required The id of the vault. Example: 1
     * @urlParam company required The id of the company. Example: 1
     *
     * @response 200 {
     *  "status": "success"
     * }
     */
    public function destroy(Request $request): JsonResponse
    {
        $vault = $request->attributes->get('vault');
        $company = $request->route()->parameter('company');

        try {
            $company = Company::where('vault_id', $vault->id)
                ->findOrFail($company);
        } catch (ModelNotFoundException) {
            abort(401);
        }

        (new DestroyCompany(
            user: Auth::user(),
            company: $company,
        ))->execute();

        return response()->json([
            'status' => 'success',
        ], 200);
    }

    /**
     * List all companies.
     *
     * This will list all the companies, sorted alphabetically.
     *
     * @urlParam vault required The id of the vault. Example: 1
     *
     * @response 200 [{
     *  "id": 4,
     *  "object": "company",
     *  "name": "Dunder Mifflin",
     * }, {
     *  "id": 5,
     *  "object": "company",
     *  "name": "Wayne Enterprises",
     * }]
     */
    public function index(Request $request): JsonResponse
    {
        $vault = $request->attributes->get('vault');

        $companies = $vault->companies()
            ->get()
            ->map(fn (Company $company) => [
                'id' => $company->id,
                'object' => 'company',
                'name' => $company->name,
            ])
            ->sortBy('name')
            ->values();

        return response()->json($companies, 200);
    }
}
