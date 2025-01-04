<?php

declare(strict_types=1);

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UpdateUserInformation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdministrationController extends Controller
{
    public function index(): View
    {
        return view('administration.index', [
            'user' => Auth::user(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore(Auth::user()->id)],
        ]);

        (new UpdateUserInformation(
            user: Auth::user(),
            email: $validated['email'],
            firstName: $validated['first_name'],
            lastName: $validated['last_name'],
        ))->execute();

        return redirect()->route('administration.index')
            ->success(trans('Changes saved'));
    }
}
