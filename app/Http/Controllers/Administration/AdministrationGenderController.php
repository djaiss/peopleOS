<?php

declare(strict_types=1);

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Models\Gender;
use App\Services\CreateGender;
use App\Services\DestroyGender;
use App\Services\UpdateGender;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdministrationGenderController extends Controller
{
    public function new(): View
    {
        return view('administration.personalization.partials.gender-new');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:255',
        ]);

        (new CreateGender(
            user: Auth::user(),
            name: $validated['name'],
        ))->execute();

        return redirect()->route('administration.personalization.index')
            ->with('status', __('Gender created'));
    }

    public function edit(Request $request, Gender $gender): View
    {
        if ($gender->account_id !== Auth::user()->account_id) {
            abort(404);
        }

        return view('administration.personalization.partials.gender-edit', [
            'gender' => $gender,
        ]);
    }

    public function update(Request $request, Gender $gender): RedirectResponse
    {
        if ($gender->account_id !== Auth::user()->account_id) {
            abort(404);
        }

        $validated = $request->validate([
            'name' => 'required|string|min:3|max:255',
        ]);

        (new UpdateGender(
            user: Auth::user(),
            gender: $gender,
            name: $validated['name'],
            position: $gender->position,
        ))->execute();

        return redirect()->route('administration.personalization.index')
            ->with('status', __('Gender updated'));
    }

    public function destroy(Request $request, Gender $gender): RedirectResponse
    {
        if ($gender->account_id !== Auth::user()->account_id) {
            abort(404);
        }

        (new DestroyGender(
            user: Auth::user(),
            gender: $gender,
        ))->execute();

        return redirect()->route('administration.personalization.index')
            ->with('status', __('Gender deleted'));
    }
}
