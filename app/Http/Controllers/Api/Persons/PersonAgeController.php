<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Persons;

use App\Http\Controllers\Controller;
use App\Models\Person;
use App\Models\User;
use App\Services\UpdateAgeOfAPerson;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\PersonResource;
use Illuminate\Support\Facades\Auth;

class PersonAgeController extends Controller
{
    public function update(Request $request): JsonResponse
    {
        $person = $request->attributes->get('person');

        $data = $request->validate([
            'age_type' => 'required|string|in:exact,estimated,bracket',
            'estimated_age' => 'nullable|integer',
            'age_bracket' => 'nullable|string',
            'age_year' => 'nullable|integer',
            'age_month' => 'nullable|integer',
            'age_day' => 'nullable|integer',
            'add_yearly_reminder' => 'required|boolean',
        ]);

        $person = (new UpdateAgeOfAPerson(
            user: Auth::user(),
            person: $person,
            ageType: $data['age_type'],
            estimatedAge: $data['estimated_age'] ?? null,
            ageBracket: $data['age_bracket'] ?? null,
            ageYear: $data['age_year'] ?? null,
            ageMonth: $data['age_month'] ?? null,
            ageDay: $data['age_day'] ?? null,
            addYearlyReminder: $data['add_yearly_reminder'],
        ))->execute();

        return response()->json([
            'data' => new PersonResource($person->refresh()),
        ], 200);
    }
}
