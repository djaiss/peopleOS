<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\GetDashboardInformation;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $viewData = (new GetDashboardInformation(
            user: Auth::user(),
        ))->execute();

        return view('dashboard.index', [
            'user' => Auth::user(),
            'viewData' => $viewData,
        ]);
    }
}
