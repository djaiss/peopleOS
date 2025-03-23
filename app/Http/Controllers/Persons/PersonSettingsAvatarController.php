<?php

declare(strict_types=1);

namespace App\Http\Controllers\Persons;

use App\Http\Controllers\Controller;
use App\Services\UpdatePersonAvatar;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PersonSettingsAvatarController extends Controller
{
    public function update(Request $request): RedirectResponse
    {
        $person = $request->attributes->get('person');

        $validated = $request->validate([
            'photo' => 'required|image|max:2000',
        ]);

        (new UpdatePersonAvatar(
            user: Auth::user(),
            person: $person,
            photo: $validated['photo'],
        ))->execute();

        return redirect()->route('person.settings.index', ['slug' => $person->slug])
            ->with('status', trans('The avatar has been updated'));
    }
}
