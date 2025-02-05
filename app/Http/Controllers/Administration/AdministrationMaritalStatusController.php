<?php

declare(strict_types=1);

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Models\MaritalStatus;
use App\Services\CreateMaritalStatus;
use App\Services\DestroyMaritalStatus;
use App\Services\UpdateMaritalStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdministrationMaritalStatusController extends Controller
{
    public function new(): View
    {
        return view('administration.personalization.partials.marital-status-new');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:255',
        ]);

        (new CreateMaritalStatus(
            user: Auth::user(),
            name: $validated['name'],
        ))->execute();

        return redirect()->route('administration.personalization.index')
            ->with('status', __('Marital status created'));
    }

    public function edit(Request $request, MaritalStatus $maritalStatus): View
    {
        if ($maritalStatus->account_id !== Auth::user()->account_id) {
            abort(404);
        }

        return view('administration.personalization.partials.marital-status-edit', [
            'maritalStatus' => $maritalStatus,
        ]);
    }

    public function update(Request $request, MaritalStatus $maritalStatus): RedirectResponse
    {
        if ($maritalStatus->account_id !== Auth::user()->account_id) {
            abort(404);
        }

        $validated = $request->validate([
            'name' => 'required|string|min:3|max:255',
        ]);

        (new UpdateMaritalStatus(
            user: Auth::user(),
            maritalStatus: $maritalStatus,
            name: $validated['name'],
            position: $maritalStatus->position,
        ))->execute();

        return redirect()->route('administration.personalization.index')
            ->with('status', __('Marital status updated'));
    }

    public function destroy(Request $request, MaritalStatus $maritalStatus): RedirectResponse
    {
        if ($maritalStatus->account_id !== Auth::user()->account_id) {
            abort(404);
        }

        (new DestroyMaritalStatus(
            user: Auth::user(),
            maritalStatus: $maritalStatus,
        ))->execute();

        return redirect()->route('administration.personalization.index')
            ->with('status', __('Marital status deleted'));
    }
}
