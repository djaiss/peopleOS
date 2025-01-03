<?php

namespace App\Http\Controllers\Api\Vaults;

use App\Http\Controllers\Controller;
use App\Http\Resources\VaultCollection;
use App\Http\Resources\VaultResource;
use App\Models\Vault;
use App\Services\CreateVault;
use App\Services\DestroyVault;
use App\Services\UpdateVault;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @group Vaults
 *
 * Vaults are used to store contacts and all the related data. You can create
 * as many vaults as you need.
 */
class VaultController extends Controller
{
    /**
     * Create a vault.
     *
     * A vault is a place where you can store contacts and all the related data.
     * When you create a vault, a contact representing you will be created
     * automatically. You will not be able to delete this contact–only another
     * manager of the vault can do so.
     *
     * @bodyParam name string required The name of the vault. Max 255 characters. Example: New vault
     * @bodyParam description string The description of the vault. Max 255 characters. Example: This is a new vault
     *
     * @response 201 {
     *  "id": 4,
     *  "object": "vault",
     *  "name": "New vault",
     *  "description": "This is a new vault"
     *  "created_at": 1514764800,
     *  "updated_at": 1514764800
     * }
     *
     * @responseField id Unique identifier for the object.
     * @responseField label The name of the vault.
     * @responseField description The description of the vault.
     * @responseField created_at The date the object was created. Represented as a Unix timestamp.
     * @responseField updated_at The date the object was last updated. Represented as a Unix timestamp.
     */
    public function create(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        $vault = (new CreateVault(
            user: Auth::user(),
            name: $validated['name'],
            description: $validated['description'],
        ))->execute();

        return new VaultResource($vault);
    }

    /**
     * Update a vault.
     *
     * @urlParam vault required The id of the vault. Example: 1
     *
     * @bodyParam name string required The name of the vault. Max 255 characters. Example: New vault
     * @bodyParam description string The description of the vault. Max 255 characters. Example: This is a new vault
     *
     * @response 200 {
     *  "id": 4,
     *  "object": "vault",
     *  "name": "New vault",
     *  "description": "This is a new vault"
     *  "created_at": 1514764800,
     *  "updated_at": 1514764800
     * }
     *
     * @responseField id Unique identifier for the object.
     * @responseField label The name of the vault.
     * @responseField description The description of the vault.
     * @responseField created_at The date the object was created. Represented as a Unix timestamp.
     * @responseField updated_at The date the object was last updated. Represented as a Unix timestamp.
     */
    public function update(Request $request)
    {
        $vault = $request->attributes->get('vault');

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        $vault = (new UpdateVault(
            user: Auth::user(),
            vault: $vault,
            name: $validated['name'],
            description: $validated['description'],
        ))->execute();

        return new VaultResource($vault);
    }

    /**
     * Delete a vault.
     *
     * @urlParam vault required The id of the vault. Example: 1
     *
     * @response 200 {
     *  "status": "success"
     * }
     */
    public function destroy(Request $request): JsonResponse
    {
        $vault = $request->attributes->get('vault');

        (new DestroyVault(
            user: Auth::user(),
            vault: $vault,
        ))->execute();

        return response()->json([
            'status' => 'success',
        ], 200);
    }

    /**
     * Retrieve a vault.
     *
     * @urlParam vault required The id of the vault. Example: 1
     *
     * @response 200 {
     *  "id": 4,
     *  "object": "vault",
     *  "name": "New vault",
     *  "description": "This is a new vault"
     *  "created_at": 1514764800,
     *  "updated_at": 1514764800
     * }
     *
     * @responseField id Unique identifier for the object.
     * @responseField label The name of the vault.
     * @responseField description The description of the vault.
     * @responseField created_at The date the object was created. Represented as a Unix timestamp.
     * @responseField updated_at The date the object was last updated. Represented as a Unix timestamp.
     */
    public function show(Request $request)
    {
        $vault = $request->attributes->get('vault');

        return new VaultResource($vault);
    }

    /**
     * List all vaults.
     *
     * This will list all the vaults, sorted alphabetically, that the user has
     * access to. This API call returns a paginated collection of genders that
     * contains 15 items per page. This will not return the vaults that the user
     * does not have access to.
     *
     * @response 200 {"data": [{
     *  "id": 4,
     *  "object": "vault",
     *  "name": "New vault",
     *  "description": "This is a new vault"
     *  "created_at": 1514764800,
     *  "updated_at": 1514764800
     * }, {
     *  "id": 5,
     *  "object": "vault",
     *  "name": "Old vault",
     *  "description": "This is an old vault"
     *  "created_at": 1514764800,
     *  "updated_at": 1514764800
     * }],
     * "links": {
     *   "first": "http://peopleos.test/api/genders?page=1",
     *   "last": "http://peopleos.test/api/genders?page=1",
     *   "prev": null,
     *   "next": null
     *  },
     *  "meta": {
     *    "current_page": 1,
     *    "from": 1,
     *    "last_page": 1,
     *    "links": [
     *      {
     *        "url": null,
     *        "label": "&laquo; Previous",
     *        "active": false
     *      },
     *      {
     *        "url": "http://peopleos.test/api/genders?page=1",
     *        "label": "1",
     *        "active": true
     *      },
     *      {
     *        "url": null,
     *        "label": "Next &raquo;",
     *        "active": false
     *      }
     *    ],
     *    "path": "http://peopleos.test/api/genders",
     *    "per_page": 15,
     *    "to": 1,
     *    "total": 1
     *  }
     *
     * @responseField id Unique identifier for the object.
     * @responseField label The name of the vault.
     * @responseField description The description of the vault.
     * @responseField created_at The date the object was created. Represented as a Unix timestamp.
     * @responseField updated_at The date the object was last updated. Represented as a Unix timestamp.
     */
    public function index()
    {
        $vaults = Auth::user()->vaults()
            ->paginate();

        return new VaultCollection($vaults);
    }
}
