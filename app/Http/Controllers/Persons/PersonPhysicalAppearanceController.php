<?php

declare(strict_types=1);

namespace App\Http\Controllers\Persons;

use App\Http\Controllers\Controller;
use App\Services\UpdatePersonPhysicalAppearance;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PersonPhysicalAppearanceController extends Controller
{
    public function edit(Request $request): View
    {
        $person = $request->attributes->get('person');

        return view('persons.overview.partials.edit-physical-appearance', [
            'person' => $person,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $person = $request->attributes->get('person');

        $validated = $request->validate([
            'height' => ['nullable', 'string'],
            'weight' => ['nullable', 'string'],
            'build' => ['nullable', 'string'],
            'skin_tone' => ['nullable', 'string'],
            'face_shape' => ['nullable', 'string'],
            'eye_color' => ['nullable', 'string'],
            'eye_shape' => ['nullable', 'string'],
            'hair_color' => ['nullable', 'string'],
            'hair_type' => ['nullable', 'string'],
            'hair_length' => ['nullable', 'string'],
            'facial_hair' => ['nullable', 'string'],
            'scars' => ['nullable', 'string'],
            'tatoos' => ['nullable', 'string'],
            'piercings' => ['nullable', 'string'],
            'distinctive_marks' => ['nullable', 'string'],
            'glasses' => ['nullable', 'string'],
            'dress_style' => ['nullable', 'string'],
            'voice' => ['nullable', 'string'],
        ]);

        (new UpdatePersonPhysicalAppearance(
            user: Auth::user(),
            person: $person,
            height: $validated['height'] ?? null,
            weight: $validated['weight'] ?? null,
            build: $validated['build'] ?? null,
            skin_tone: $validated['skin_tone'] ?? null,
            face_shape: $validated['face_shape'] ?? null,
            eye_color: $validated['eye_color'] ?? null,
            eye_shape: $validated['eye_shape'] ?? null,
            hair_color: $validated['hair_color'] ?? null,
            hair_type: $validated['hair_type'] ?? null,
            hair_length: $validated['hair_length'] ?? null,
            facial_hair: $validated['facial_hair'] ?? null,
            scars: $validated['scars'] ?? null,
            tatoos: $validated['tatoos'] ?? null,
            piercings: $validated['piercings'] ?? null,
            distinctive_marks: $validated['distinctive_marks'] ?? null,
            glasses: $validated['glasses'] ?? null,
            dress_style: $validated['dress_style'] ?? null,
            voice: $validated['voice'] ?? null,
        ))->execute();

        return redirect()->route('person.show', $person->slug)
            ->with('status', trans('Changes saved'));
    }
}
