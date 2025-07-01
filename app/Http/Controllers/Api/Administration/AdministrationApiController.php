<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Administration;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use App\Services\CreateApiKey;
use App\Services\DestroyApiKey;
use App\Traits\ApiResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class AdministrationApiController extends Controller
{
    use ApiResponses;

    public function index(): AnonymousResourceCollection
    {
        $apiKeys = Auth::user()->tokens;

        return ApiResource::collection($apiKeys);
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

        return (new ApiResource($apiKey))
            ->additional(['token' => $token])
            ->response()
            ->setStatusCode(201);
    }

    public function show(Request $request): JsonResponse
    {
        $id = (int) $request->route()->parameter('id');

        $apiKey = Auth::user()->tokens()->find($id);

        if (! $apiKey) {
            return $this->error('API key not found', 404);
        }

        return (new ApiResource($apiKey))->response()->setStatusCode(200);
    }

    public function destroy(Request $request): Response|JsonResponse
    {
        $id = (int) $request->route()->parameter('id');

        if ($id === 0) {
            return $this->error('API key not found', 404);
        }

        $apiKey = Auth::user()->tokens()->find($id);

        if (! $apiKey) {
            return $this->error('API key not found', 404);
        }

        (new DestroyApiKey(
            user: Auth::user(),
            tokenId: $id,
        ))->execute();

        return response()->noContent(204);
    }
}
