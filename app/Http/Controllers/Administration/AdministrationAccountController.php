<?php

declare(strict_types=1);

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Services\DestroyAccount;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdministrationAccountController extends Controller
{
    public function index(): View
    {
        return view('administration.account.index');
    }

    public function destroy(Request $request): RedirectResponse
    {
        (new DestroyAccount(
            user: Auth::user(),
            reason: $request->input('feedback'),
        ))->execute();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
