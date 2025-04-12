<?php

declare(strict_types=1);

namespace App\Http\Controllers\Persons;

use App\Http\Controllers\Controller;
use App\Services\CreateLifeEvent;
use App\Services\DestroyLifeEvent;
use App\Services\GetLifeEventsListing;
use App\Services\UpdateLifeEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PersonLifeEventController extends Controller
{
    public function index(Request $request): View
    {
        $person = $request->attributes->get('person');

        $viewData = (new GetLifeEventsListing(
            user: Auth::user(),
            person: $person,
        ))->execute();

        return view('persons.life-events.index', $viewData);
    }

    public function new(Request $request): View
    {
        $person = $request->attributes->get('person');

        return view('persons.life-events.partials.add', [
            'person' => $person,
        ]);
    }

    public function create(Request $request)
    {
        $person = $request->attributes->get('person');

        $validated = $request->validate([
            'description' => 'required|string|min:3|max:255',
            'happened_at' => 'required|date',
            'comment' => 'nullable|string|min:3|max:255',
            'icon' => 'nullable|string|min:3|max:255',
            'bg_color' => 'nullable|string|min:3|max:255',
            'text_color' => 'nullable|string|min:3|max:255',
        ]);

        $reminderSet = $request->input('should_be_reminded') === 'reminded';

        (new CreateLifeEvent(
            user: Auth::user(),
            person: $person,
            description: $validated['description'],
            happenedAt: $validated['happened_at'],
            comment: $validated['comment'] ?? null,
            icon: $validated['icon'] ?? null,
            bgColor: $validated['bg_color'] ?? null,
            textColor: $validated['text_color'] ?? null,
            shouldBeReminded: $reminderSet,
        ))->execute();

        return redirect()->route('person.life-event.index', $person->slug)
            ->with('status', trans('The life event has been created'));
    }

    public function edit(Request $request): View
    {
        $person = $request->attributes->get('person');
        $lifeEvent = $request->attributes->get('lifeEvent');

        return view('persons.life-events.partials.edit', [
            'person' => $person,
            'lifeEvent' => $lifeEvent,
        ]);
    }

    public function update(Request $request)
    {
        $person = $request->attributes->get('person');
        $lifeEvent = $request->attributes->get('lifeEvent');

        $validated = $request->validate([
            'description' => 'required|string|min:3|max:255',
            'happened_at' => 'required|date',
            'comment' => 'nullable|string|min:3|max:255',
            'icon' => 'nullable|string|min:3|max:255',
            'bg_color' => 'nullable|string|min:3|max:255',
            'text_color' => 'nullable|string|min:3|max:255',
        ]);

        $reminderSet = $request->input('should_be_reminded') === 'reminded';

        (new UpdateLifeEvent(
            user: Auth::user(),
            lifeEvent: $lifeEvent,
            description: $validated['description'],
            happenedAt: $validated['happened_at'],
            comment: $validated['comment'] ?? null,
            icon: $validated['icon'] ?? null,
            bgColor: $validated['bg_color'] ?? null,
            textColor: $validated['text_color'] ?? null,
            shouldBeReminded: $reminderSet,
        ))->execute();

        return redirect()->route('person.life-event.index', $person->slug)
            ->with('status', trans('Changes saved'));
    }

    public function destroy(Request $request)
    {
        $person = $request->attributes->get('person');
        $lifeEvent = $request->attributes->get('lifeEvent');

        (new DestroyLifeEvent(
            user: Auth::user(),
            lifeEvent: $lifeEvent,
        ))->execute();

        return redirect()->route('person.life-event.index', $person->slug)
            ->with('status', trans('The life event has been deleted'));
    }
}
