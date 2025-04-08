<?php

declare(strict_types=1);

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Models\Account;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdministrationCreateTaskOnReminderController extends Controller
{
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'create_task_on_reminder' => 'required|in:yes,no',
        ]);

        $account = Account::find(Auth::user()->account_id);

        $account->create_task_on_reminder = $validated['create_task_on_reminder'] === 'yes';
        $account->save();

        return redirect()->route('administration.personalization.index')
            ->with('status', trans('Changes saved'));
    }
}
