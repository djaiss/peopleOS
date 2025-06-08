<?php

declare(strict_types=1);

namespace App\Http\Controllers\Persons;

use App\Http\Controllers\Controller;
use App\Models\LoveRelationship;
use App\Models\Person;
use App\Services\CreateChild;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PersonChildrenController extends Controller
{
    public function new(Request $request): View
    {
        $person = $request->attributes->get('person');

        $potentialParents = collect($person
            ->loveRelationships()
            ->with('relatedPerson')
            ->where('is_current', true)
            ->get()
            ->map(fn(LoveRelationship $relationship): array => [
                'id' => $relationship->relatedPerson->id,
                'name' => $relationship->relatedPerson->name,
            ]));

        return view('persons.family.partials.children.new', [
            'person' => $person,
            'potentialParents' => $potentialParents,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $person = $request->attributes->get('person');

        $validated = $request->validate([
            'first_name' => 'nullable|string|min:3|max:255',
            'last_name' => 'nullable|string|min:3|max:255',
            'second_parent_id' => 'nullable|exists:persons,id',
        ]);

        $secondParentId = $validated['second_parent_id'] ?? null;
        $secondParent = null;

        if ($secondParentId && $secondParentId !== '0') {
            $secondParent = Person::find($secondParentId);
        }

        (new CreateChild(
            user: Auth::user(),
            parent: $person,
            firstName: $validated['first_name'],
            lastName: $validated['last_name'],
            secondParent: $secondParent,
        ))->execute();

        return redirect()->route('person.family.index', $person)
            ->with('status', trans('Changes saved'));
    }
}
