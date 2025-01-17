<?php

declare(strict_types=1);

namespace App\Http\Controllers\Instance;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class InstanceController extends Controller
{
    public function index(): View
    {
        // get the number of total accounts
        $totalAccounts = Account::count();

        $accounts = Account::query()
            ->with(['users' => function ($query) {
                $query->orderBy('created_at', 'asc')
                    ->limit(1);
            }])
            ->withCount('persons')
            ->get()
            ->map(function ($account) {
                $firstUser = $account->users->first();

                return [
                    'id' => $firstUser?->id,
                    'name' => $firstUser ? trim($firstUser->first_name . ' ' . $firstUser->last_name) : '',
                    'email' => $firstUser?->email,
                    'is_instance_admin' => $firstUser?->is_instance_admin,
                    'persons_count' => $account->persons_count
                ];
            });

        return view('instance.index', [
            'accounts' => $accounts,
            'totalAccounts' => $totalAccounts,
        ]);
    }

    public function show(): View
    {
        return view('instance.show');
    }
}
