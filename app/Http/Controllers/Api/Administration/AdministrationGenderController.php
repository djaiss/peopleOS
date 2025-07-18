<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Administration;

use App\Http\Controllers\Controller;
use App\Http\Resources\GenderResource;
use App\Models\Gender;
use App\Services\CreateGender;
use App\Services\DestroyGender;
use App\Services\UpdateGender;
use App\Traits\ApiResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AdministrationGenderController extends Controller
{
    use ApiResponses;

    public function index(): JsonResource
    {
        $genders = Gender::where('account_id', Auth::user()->account_id)
            ->orderBy('position', 'asc')
            ->get();

        return GenderResource::collection($genders);
    }

    public function create(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $gender = (new CreateGender(
            user: $request->user(),
            name: $data['name'],
        ))->execute();

        return (new GenderResource($gender))->response()->setStatusCode(201);
    }

    public function show(Gender $gender): JsonResource|JsonResponse
    {
        if ($gender->account_id !== Auth::user()->account_id) {
            return $this->error('Gender not found', 404);
        }

        return new GenderResource($gender);
    }

    public function update(Request $request, Gender $gender): JsonResource
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'position' => ['required', 'integer'],
        ]);

        $gender = (new UpdateGender(
            user: $request->user(),
            gender: $gender,
            name: $data['name'],
            position: (int) $data['position'],
        ))->execute();

        return new GenderResource($gender);
    }

    public function destroy(Request $request, Gender $gender): Response
    {
        (new DestroyGender(
            user: $request->user(),
            gender: $gender,
        ))->execute();

        return response()->noContent(204);
    }
}
