<?php

declare(strict_types=1);

namespace App\Http\Controllers\Persons;

use App\Cache\PeopleListCache;
use App\Enums\GiftStatus;
use App\Http\Controllers\Controller;
use App\Models\Gift;
use App\Services\CreateGift;
use App\Services\DestroyGift;
use App\Services\UpdateGift;
use App\Services\UpdatePersonGiftTab;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PersonGiftController extends Controller
{
    public function index(Request $request): View
    {
        $person = $request->attributes->get('person');

        $persons = PeopleListCache::make(
            accountId: Auth::user()->account_id,
        )->value();

        $gifts = Gift::where('person_id', $person->id)
            ->where('status', $person->gift_tab_shown)
            ->orderBy('gifted_at', 'desc')
            ->get();

        // count the number of gifts for each status
        $ideaGiftsCount = Gift::where('person_id', $person->id)
            ->where('status', GiftStatus::IDEA->value)
            ->count();
        $receivedGiftsCount = Gift::where('person_id', $person->id)
            ->where('status', GiftStatus::RECEIVED->value)
            ->count();
        $offeredGiftsCount = Gift::where('person_id', $person->id)
            ->where('status', GiftStatus::GIVEN->value)
            ->count();

        return view('persons.gifts.index', [
            'persons' => $persons,
            'person' => $person,
            'gifts' => $gifts,
            'ideaGiftsCount' => $ideaGiftsCount,
            'receivedGiftsCount' => $receivedGiftsCount,
            'offeredGiftsCount' => $offeredGiftsCount,
        ]);
    }

    public function new(Request $request): View
    {
        $person = $request->attributes->get('person');

        return view('persons.gifts.partials.gift-add', [
            'person' => $person,
        ]);
    }

    public function create(Request $request)
    {
        $person = $request->attributes->get('person');

        $validated = $request->validate([
            'status' => 'required|string|min:3|max:255',
            'name' => 'required|string|min:3|max:255',
            'occasion' => 'nullable|string|min:3|max:255',
            'url' => 'nullable|string|min:3|max:255',
            'gifted_at' => 'nullable|date',
        ]);

        $validated['gifted_at'] = $request->input('date') === 'known' && $validated['gifted_at']
            ? Carbon::parse($validated['gifted_at'])->format('Y-m-d')
            : null;

        (new CreateGift(
            user: Auth::user(),
            person: $person,
            status: $validated['status'],
            name: $validated['name'],
            occasion: $validated['occasion'] ?? null,
            url: $validated['url'] ?? null,
            giftedAt: $validated['gifted_at'] ?? null,
        ))->execute();

        (new UpdatePersonGiftTab(
            user: Auth::user(),
            person: $person,
            status: $validated['status'],
        ))->execute();

        return redirect()->route('persons.gifts.index', $person->slug)
            ->with('status', trans('The gift has been created'));
    }

    public function edit(Request $request): View
    {
        $person = $request->attributes->get('person');
        $gift = $request->attributes->get('gift');

        return view('persons.gifts.partials.gift-edit', [
            'person' => $person,
            'gift' => $gift,
        ]);
    }

    public function update(Request $request)
    {
        $person = $request->attributes->get('person');
        $gift = $request->attributes->get('gift');

        $validated = $request->validate([
            'status' => 'required|string|min:3|max:255',
            'name' => 'required|string|min:3|max:255',
            'occasion' => 'nullable|string|min:3|max:255',
            'url' => 'nullable|string|min:3|max:255',
            'gifted_at' => 'nullable|date',
        ]);

        $validated['gifted_at'] = $request->input('date') === 'known' && $validated['gifted_at']
            ? Carbon::parse($validated['gifted_at'])->format('Y-m-d')
            : null;

        (new UpdateGift(
            user: Auth::user(),
            person: $person,
            gift: $gift,
            status: $validated['status'],
            name: $validated['name'],
            occasion: $validated['occasion'] ?? null,
            url: $validated['url'] ?? null,
            giftedAt: $validated['gifted_at'] ?? null,
        ))->execute();

        (new UpdatePersonGiftTab(
            user: Auth::user(),
            person: $person,
            status: $validated['status'],
        ))->execute();

        return redirect()->route('persons.gifts.index', $person->slug)
            ->with('status', trans('The gift has been updated'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        $person = $request->attributes->get('person');
        $gift = $request->attributes->get('gift');

        (new DestroyGift(
            user: Auth::user(),
            gift: $gift,
        ))->execute();

        return redirect()->route('persons.gifts.index', $person->slug)
            ->with('status', __('Gift deleted'));
    }
}
