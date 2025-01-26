<?php

declare(strict_types=1);

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Services\PruneAccount;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class AdministrationPruneAccountController extends Controller
{
    public function update(): RedirectResponse
    {
        (new PruneAccount(
            user: Auth::user(),
            account: Auth::user()->account,
        ))->execute();

        return redirect()->route('administration.account.index')
            ->success(trans('The account has been pruned'));
    }
}
