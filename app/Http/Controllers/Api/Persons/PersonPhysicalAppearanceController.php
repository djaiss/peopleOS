<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Persons;

use App\Http\Controllers\Controller;
use App\Http\Resources\PersonResource;
use App\Services\UpdatePersonPhysicalAppearance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PersonPhysicalAppearanceController extends Controller
{
    public function update(Request $request): PersonResource
    {
        $person = $request->attributes->get('person');

        $validated = $request->validate([
            'height' => 'nullable|string|max:255',
            'weight' => 'nullable|string|max:255',
            'build' => 'nullable|string|max:255',
            'skin_tone' => 'nullable|string|max:255',
            'face_shape' => 'nullable|string|max:255',
            'eye_color' => 'nullable|string|max:255',
            'eye_shape' => 'nullable|string|max:255',
            'hair_color' => 'nullable|string|max:255',
            'hair_type' => 'nullable|string|max:255',
            'hair_length' => 'nullable|string|max:255',
            'facial_hair' => 'nullable|string|max:255',
            'scars' => 'nullable|string|max:255',
            'tatoos' => 'nullable|string|max:255',
            'piercings' => 'nullable|string|max:255',
            'distinctive_marks' => 'nullable|string|max:255',
            'glasses' => 'nullable|string|max:255',
            'dress_style' => 'nullable|string|max:255',
            'voice' => 'nullable|string|max:255',
        ]);

        $person = (new UpdatePersonPhysicalAppearance(
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

        return new PersonResource($person);
    }
}
