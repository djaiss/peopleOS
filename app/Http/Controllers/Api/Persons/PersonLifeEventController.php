<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Persons;

use App\Http\Controllers\Controller;
use App\Http\Resources\LifeEventResource;
use App\Services\CreateLifeEvent;
use App\Services\UpdateLifeEvent;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class PersonLifeEventController extends Controller
{
    public function index(Request $request): JsonResource
    {
        $person = $request->attributes->get('person');

        $lifeEvents = $person->lifeEvents()
            ->orderBy('created_at', 'desc')
            ->get();

        return LifeEventResource::collection($lifeEvents);
    }

    public function create(Request $request): JsonResource
    {
        $person = $request->attributes->get('person');

        $data = $request->validate([
            'description' => ['required', 'string'],
            'happened_at' => ['required', 'date'],
            'comment' => ['nullable', 'string'],
            'icon' => ['nullable', 'string'],
            'bg_color' => ['nullable', 'string'],
            'text_color' => ['nullable', 'string'],
            'should_be_reminded' => ['boolean'],
        ]);

        $lifeEvent = (new CreateLifeEvent(
            user: Auth::user(),
            person: $person,
            description: $data['description'],
            happenedAt: $data['happened_at'],
            comment: $data['comment'] ?? null,
            icon: $data['icon'] ?? null,
            bgColor: $data['bg_color'] ?? null,
            textColor: $data['text_color'] ?? null,
            shouldBeReminded: $data['should_be_reminded'] ?? false,
        ))->execute();

        return new LifeEventResource($lifeEvent);
    }

    public function show(Request $request): JsonResource
    {
        $lifeEvent = $request->attributes->get('lifeEvent');

        return new LifeEventResource($lifeEvent);
    }

    public function update(Request $request): JsonResource
    {
        $lifeEvent = $request->attributes->get('lifeEvent');

        $data = $request->validate([
            'description' => ['required', 'string'],
            'happened_at' => ['required', 'date'],
            'comment' => ['nullable', 'string'],
            'icon' => ['nullable', 'string'],
            'bg_color' => ['nullable', 'string'],
            'text_color' => ['nullable', 'string'],
            'should_be_reminded' => ['boolean'],
        ]);

        $lifeEvent = (new UpdateLifeEvent(
            user: Auth::user(),
            lifeEvent: $lifeEvent,
            description: $data['description'],
            happenedAt: $data['happened_at'],
            comment: $data['comment'] ?? null,
            icon: $data['icon'] ?? null,
            bgColor: $data['bg_color'] ?? null,
            textColor: $data['text_color'] ?? null,
            shouldBeReminded: $data['should_be_reminded'] ?? false,
        ))->execute();

        return new LifeEventResource($lifeEvent);
    }

    public function destroy(Request $request): Response
    {
        $lifeEvent = $request->attributes->get('lifeEvent');

        $lifeEvent->delete();

        return response()->noContent();
    }
}
