<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Person;
use App\Services\StopSendingReminder;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\View\View;

class StopReminderController extends Controller
{
    public function show(Request $request): View|RedirectResponse
    {
        $personIdHash = (string) $request->route()->parameter('hash');
        $specialDateId = (int) $request->route()->parameter('id');

        if (! $request->hasValidSignature()) {
            abort(401);
        }

        try {
            $decrypted = Crypt::decryptString($personIdHash);
        } catch (DecryptException) {
            return redirect()->back()->withErrors(__('Decryption failed.'));
        }

        $person = Person::findOrFail($decrypted);
        $specialDate = $person->specialDates()->findOrFail($specialDateId);

        (new StopSendingReminder(
            specialDate: $specialDate,
        ))->execute();

        return view('persons.stop-reminder', [
            'name' => $person->name,
            'occasion' => $specialDate->name,
        ]);
    }
}
