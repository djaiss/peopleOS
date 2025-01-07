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
            ->take(3)
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

        $user = Auth::user();

        return view('administration.index', [
            'user' => [
                'id' => $user->id,
                'profile_photo_url' => $user->profile_photo_url,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'nickname' => $user?->nickname,
                'email' => $user->email,
                'name' => $user->name,
                'permission' => $user->permission,
            ],
            'logs' => $logs,
            'has_more_logs' => Log::where('user_id', $user->id)->count() > 3,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'nickname' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore(Auth::user()->id)],
        ]);

        (new UpdateUserInformation(
            user: Auth::user(),
            email: $validated['email'],
            firstName: $validated['first_name'],
            lastName: $validated['last_name'],
            nickname: $validated['nickname'],
        ))->execute();

        return redirect()->route('administration.index')
            ->success(trans('Changes saved'));
    }
}
