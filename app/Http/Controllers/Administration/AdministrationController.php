<?php

declare(strict_types=1);

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\GetAdministrationData;
use App\Services\UpdateUserInformation;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdministrationController extends Controller
{
    public function index(): View
    {
        $viewData = (new GetAdministrationData(
            user: Auth::user(),
        ))->execute();

        return view('administration.index', $viewData);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'nickname' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore(Auth::user()->id)],
            'born_at' => ['nullable', 'date'],
        ]);

        if ($validated['born_at'] !== null) {
            $validated['born_at'] = Carbon::createFromFormat('m/d/Y', $validated['born_at'])->format('Y-m-d');
        }

        (new UpdateUserInformation(
            user: Auth::user(),
            email: $validated['email'],
            firstName: $validated['first_name'],
            lastName: $validated['last_name'],
            nickname: $validated['nickname'],
            bornAt: $validated['born_at'],
        ))->execute();

        return redirect()->route('administration.index')
            ->with('status', trans('Changes saved'));
    }
}
