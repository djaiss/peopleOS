<?php

declare(strict_types=1);

namespace App\Http\Controllers\Instance;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Services\GiveFreeAccount;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InstanceFreeAccountController extends Controller
{
    public function update(Request $request, Account $account): RedirectResponse
    {
        (new GiveFreeAccount(
            user: Auth::user(),
            account: $account,
        ))->execute();

        return redirect()->route('instance.show', [
            'account' => $account,
        ])->with('status', trans('The account is now free'));
    }
}
