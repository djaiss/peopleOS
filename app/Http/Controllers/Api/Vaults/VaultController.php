<?php

namespace App\Http\Controllers\Api\Vaults;

use App\Http\Controllers\Controller;
use App\Models\Vault;
use App\Services\CreateVault;
use App\Services\DestroyVault;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @group Vaults
 */
class VaultController extends Controller
{
    /**
     * Create a vault
     *
     * @bodyParam name string required The name of the vault. Max 255 characters. Example: New vault
     * @bodyParam description string The description of the vault. Max 255 characters. Example: This is a new vault
     *
     * @response 201 {
     *  "id": 4,
     *  "object": "vault",
     *  "name": "New vault",
     *  "description": "This is a new vault"
     * }
     */
    public function create(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        $vault = (new CreateVault(
            user: auth()->user(),
            name: $validated['name'],
            description: $validated['description'],
        ))->execute();

        return response()->json([
            'id' => $vault->id,
            'object' => 'vault',
            'name' => $vault->name,
            'description' => $vault->description,
        ], 201);
    }

    /**
     * Delete a vault
     *
     * @urlParam vault required The id of the vault. Example: 1
     *
     * @response 200 {
     *  "status": "success"
     * }
     */
    public function destroy(Request $request, int $vaultId): JsonResponse
    {
        $vault = auth()->user()->vaults()
            ->wherePivot('permission', '<=', Vault::PERMISSION_MANAGE)
            ->findOrFail($vaultId);

        (new DestroyVault(
            user: auth()->user(),
            vault: $vault,
        ))->execute();

        return response()->json([
            'status' => 'success',
        ], 200);
    }

    /**
     * List all vaults
     *
     * This will list all the vaults, sorted
     * alphabetically.
     *
     * @response 200 [{
     *  "id": 4,
     *  "object": "vault",
     *  "name": "New vault",
     *  "description": "This is a new vault"
     * }, {
     *  "id": 5,
     *  "object": "vault",
     *  "name": "Old vault",
     *  "description": "This is an old vault"
     * }]
     */
    public function index(): JsonResponse
    {
        $vaults = auth()->user()->vaults()
            ->get()
            ->map(fn (Vault $vault) => [
                'id' => $vault->id,
                'object' => 'vault',
                'name' => $vault->name,
                'description' => $vault->description,
            ])
            ->sortBy('name');

        return response()->json($vaults, 200);
    }
}
