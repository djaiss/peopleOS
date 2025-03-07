<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Administration;

use App\Http\Controllers\Controller;
use App\Http\Resources\LogCollection;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdministrationLogsController extends Controller
{
    public function index(Request $request): LogCollection
    {
        $request->attributes->get('person');

        $logs = Log::where('user_id', Auth::user()->id)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return new LogCollection($logs);
    }
}
