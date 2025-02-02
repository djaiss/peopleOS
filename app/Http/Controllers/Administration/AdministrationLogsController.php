<?php

declare(strict_types=1);

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdministrationLogsController extends Controller
{
    public function index(): View
    {
        $logs = Log::where('user_id', Auth::user()->id)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->cursorPaginate(10);

        return view('administration.logs.index', [
            'logs' => $logs,
        ]);
    }
}
