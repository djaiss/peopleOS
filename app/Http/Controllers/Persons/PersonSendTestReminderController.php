<?php

declare(strict_types=1);

namespace App\Http\Controllers\Persons;

use App\Http\Controllers\Controller;
use App\Jobs\SendReminder;
use App\Models\SpecialDate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PersonSendTestReminderController extends Controller
{
    public function create(Request $request, string $slug, int $specialDateId): RedirectResponse
    {
        $person = $request->attributes->get('person');
        $specialDate = SpecialDate::where('person_id', $person->id)
            ->where('id', $specialDateId)
            ->firstOrFail();

        SendReminder::dispatch($specialDate)->onQueue('high');

        return redirect()->route('person.reminder.index', $person->slug)
            ->with('status', __('Mail sent'));
    }
}
