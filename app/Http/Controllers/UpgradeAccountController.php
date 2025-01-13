<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UpgradeAccountController extends Controller
{
    public function index(): View
    {
        return view('upgrade.index', [
            'user' => Auth::user(),
        ]);
    }
}
