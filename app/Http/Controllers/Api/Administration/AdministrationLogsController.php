<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Administration;

use App\Http\Controllers\Controller;
use App\Http\Resources\LogResource;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AdministrationLogsController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $logs = Log::where('user_id', Auth::user()->id)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return LogResource::collection($logs);
    }

    public function show(Log $log): LogResource
    {
        $log->loadMissing('user');
        return new LogResource($log);
    }
}
