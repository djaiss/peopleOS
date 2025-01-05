<?php

declare(strict_types=1);

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdministrationSecurityController extends Controller
{
    public function index(): View
    {
        return view('administration.security.index', [
            'user' => [
                'id' => Auth::user()->id,
            ],
        ]);
    }
}
