<?php

declare(strict_types=1);

namespace App\Http\Controllers\Persons;

use App\Http\Controllers\Controller;
use App\Services\ToggleTask;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PersonTaskToggleController extends Controller
{
    public function update(Request $request): RedirectResponse
    {
        $person = $request->attributes->get('person');
        $task = $request->attributes->get('task');

        (new ToggleTask(
            user: Auth::user(),
            task: $task,
        ))->execute();

        return redirect()->route('person.reminder.index', $person->slug)
            ->with('status', trans('Changes saved'));
    }
}
