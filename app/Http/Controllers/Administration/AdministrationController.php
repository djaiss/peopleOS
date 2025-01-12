<?php

declare(strict_types=1);

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdministrationController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();

        return view('administration.index', [
            'user' => [
                'id' => $user->id,
                'permission' => $user->permission,
            ],
        ]);
    }
}
