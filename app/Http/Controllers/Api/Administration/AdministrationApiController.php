<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Administration;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiCollection;
use App\Services\CreateApiKey;
use App\Services\DestroyApiKey;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class AdministrationApiController extends Controller
{
    public function index(): ApiCollection
    {
        $apiKeys = Auth::user()->tokens
            ->map(fn(PersonalAccessToken $token): array => [
                'id' => $token->id,
                'name' => $token->name,
                'last_used_at' => $token->last_used_at ? $token->last_used_at->diffForHumans() : trans('Never'),
                'created_at' => $token->created_at->timestamp,
                'updated_at' => $token->updated_at?->timestamp,
            ]);

        return new ApiCollection($apiKeys);
    }

    public function create(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
        ]);

        $token = (new CreateApiKey(
            user: Auth::user(),
            label: $validated['label'],
        ))->execute();

        $apiKey = Auth::user()->tokens()->latest()->first();

        $response = [
            'id' => $apiKey->id,
            'object' => 'api_key',
            'token' => $token,
            'name' => $apiKey->name,
            'last_used_at' => $apiKey->last_used_at,
            'created_at' => $apiKey->created_at->timestamp,
            'updated_at' => $apiKey->updated_at?->timestamp,
        ];

        return response()->json($response);
    }

    public function destroy(Request $request): JsonResponse
    {
        $id = (int) $request->route()->parameter('id');

        if ($id === 0) {
            return response()->json(['error' => 'API key not found'], 404);
        }

        $apiKey = Auth::user()->tokens()->find($id);

        if (! $apiKey) {
            return response()->json(['error' => 'API key not found'], 404);
        }

        (new DestroyApiKey(
            user: Auth::user(),
            tokenId: $id,
        ))->execute();

        return response()->json(['message' => 'API key deleted']);
    }
}
