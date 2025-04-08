<?php

declare(strict_types=1);

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Models\Account;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdministrationAutoDeleteAccountController extends Controller
{
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'auto_delete_account' => 'required|in:yes,no',
        ]);

        $account = Account::find(Auth::user()->account_id);

        $account->auto_delete_account = $validated['auto_delete_account'] === 'yes';
        $account->save();

        return redirect()->route('administration.security.index')
            ->with('status', trans('Changes saved'));
    }
}
