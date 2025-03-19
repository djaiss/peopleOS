<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Persons;

use App\Http\Controllers\Controller;
use App\Http\Resources\GiftCollection;
use App\Http\Resources\GiftResource;
use App\Services\CreateGift;
use App\Services\DestroyGift;
use App\Services\UpdateGift;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class PersonGiftController extends Controller
{
    public function index(Request $request): JsonResource
    {
        $person = $request->attributes->get('person');

        $gifts = $person->gifts()
            ->orderBy('created_at', 'desc')
            ->get();

        return new GiftCollection($gifts);
    }

    public function create(Request $request): JsonResource
    {
        $person = $request->attributes->get('person');

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'occasion' => ['nullable', 'string'],
            'url' => ['nullable', 'url', 'max:255'],
            'status' => ['required', 'string', 'in:idea,given,offered'],
            'date' => ['nullable', 'date'],
        ]);

        $gift = (new CreateGift(
            user: $request->user(),
            person: $person,
            name: $data['name'] ?? null,
            occasion: $data['occasion'] ?? null,
            status: $data['status'],
            url: $data['url'] ?? null,
            giftedAt: $data['date'] ?? null,
        ))->execute();

        return new GiftResource($gift);
    }

    public function show(Request $request): JsonResource
    {
        $gift = $request->attributes->get('gift');

        return new GiftResource($gift);
    }

    public function update(Request $request): JsonResource
    {
        $person = $request->attributes->get('person');
        $gift = $request->attributes->get('gift');

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'occasion' => ['nullable', 'string'],
            'url' => ['nullable', 'url', 'max:255'],
            'status' => ['required', 'string', 'in:idea,given,offered'],
            'date' => ['nullable', 'date'],
        ]);

        $gift = (new UpdateGift(
            user: Auth::user(),
            person: $person,
            gift: $gift,
            name: $data['name'],
            occasion: $data['occasion'] ?? null,
            url: $data['url'] ?? null,
            status: $data['status'],
            giftedAt: $data['date'] ?? null,
        ))->execute();

        return new GiftResource($gift);
    }

    public function destroy(Request $request): Response
    {
        $gift = $request->attributes->get('gift');

        (new DestroyGift(
            user: Auth::user(),
            gift: $gift,
        ))->execute();

        return response()->noContent();
    }
}
