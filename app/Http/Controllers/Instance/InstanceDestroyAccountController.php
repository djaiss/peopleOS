<?php

declare(strict_types=1);

namespace App\Http\Controllers\Instance;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Services\DestroyAccountAsInstanceAdministrator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InstanceDestroyAccountController extends Controller
{
    public function destroy(Request $request, Account $account): RedirectResponse
    {
        (new DestroyAccountAsInstanceAdministrator(
            user: Auth::user(),
            account: $account,
        ))->execute();

        return redirect()->route('instance.index')
            ->with('success', trans('The account has been deleted'));
    }
}
