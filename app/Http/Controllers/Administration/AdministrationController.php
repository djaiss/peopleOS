<?php

declare(strict_types=1);

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Models\Log;
use App\Models\User;
use App\Services\UpdateUserInformation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdministrationController extends Controller
{
    public function index(): View
    {
        $logs = Log::where('user_id', Auth::user()->id)
            ->with('user')
            ->take(5)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(fn (Log $log): array => [
                'user' => [
                    'name' => $log->name,
                ],
                'action' => $log->action,
                'description' => $log->description,
                'created_at' => $log->created_at->diffForHumans(),
            ]);

        $has_more_logs = Log::where('user_id', Auth::user()->id)->count() > 5;

        return view('administration.index', [
            'logs' => $logs,
            'has_more_logs' => $has_more_logs,
            'user' => Auth::user(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'nickname' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore(Auth::user()->id)],
            'born_at' => ['nullable', 'date'],
        ]);

        (new UpdateUserInformation(
            user: Auth::user(),
            email: $validated['email'],
            firstName: $validated['first_name'],
            lastName: $validated['last_name'],
            nickname: $validated['nickname'],
            bornAt: $validated['born_at'],
        ))->execute();

        return redirect()->route('administration.index')
            ->with('status', trans('Changes saved'));
    }
}
