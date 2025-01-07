<?php

declare(strict_types=1);

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Services\UpdateAccountInformation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdministrationAccountController extends Controller
{
    public function index(): View
    {
        $account = Auth::user()->account;

        return view('administration.account.index', [
            'account' => [
                'id' => $account->id,
                'name' => $account->name,
                'avatar' => $account->avatar,
            ],
            'user' => [
                'permission' => Auth::user()->permission,
            ],
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        (new UpdateAccountInformation(
            user: Auth::user(),
            name: $validated['name'],
        ))->execute();

        return redirect()->route('administration.account.index')
            ->success(trans('Changes saved'));
    }
}
