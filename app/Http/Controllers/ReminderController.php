<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\GetDashboardInformation;
use App\Services\GetRemindersDashboard;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ReminderController extends Controller
{
    public function index(): View
    {
        $viewData = (new GetRemindersDashboard(
            user: Auth::user(),
        ))->execute();

        return view('reminders.index', [
            'user' => Auth::user(),
            'reminders' => $viewData,
        ]);
    }
}
