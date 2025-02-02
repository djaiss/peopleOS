<?php

declare(strict_types=1);

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Services\UpdateProfilePicture;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdministrationAvatarController extends Controller
{
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'photo' => 'required|image|max:2000',
        ]);

        (new UpdateProfilePicture(
            user: Auth::user(),
            photo: $validated['photo'],
        ))->execute();

        return redirect()->route('administration.index')
            ->with('status', trans('The avatar has been updated'));
    }
}
