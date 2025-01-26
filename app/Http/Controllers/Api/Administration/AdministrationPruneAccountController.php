<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Administration;

use App\Http\Controllers\Controller;
use App\Services\PruneAccount;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * @group Administration
 *
 * @subgroup Prune account
 */
class AdministrationPruneAccountController extends Controller
{
    /**
     * Prune the account.
     *
     * Prunes the account by deleting all persons and related data.
     *
     * @response 204
     */
    public function update(Request $request): Response
    {
        (new PruneAccount(
            user: $request->user(),
            account: $request->user()->account,
        ))->execute();

        return response()->noContent();
    }
}
