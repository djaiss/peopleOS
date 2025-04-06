<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Administration;

use App\Http\Controllers\Controller;
use App\Services\PruneAccount;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AdministrationPruneAccountController extends Controller
{
    /**
     * Prune the account.
     *
     * Prunes the account by deleting all persons and related data.
     */
    public function update(): Response
    {
        (new PruneAccount(
            user: Auth::user(),
            account: Auth::user()->account,
        ))->execute();

        return response()->noContent();
    }
}
