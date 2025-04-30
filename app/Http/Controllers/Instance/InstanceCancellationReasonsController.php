<?php

declare(strict_types=1);

namespace App\Http\Controllers\Instance;

use App\Http\Controllers\Controller;
use App\Models\AccountDeletionReason;
use Illuminate\View\View;

class InstanceCancellationReasonsController extends Controller
{
    public function index(): View
    {
        $cancellationReasons = AccountDeletionReason::orderBy('created_at', 'desc')
            ->get();

        return view('instance.cancellation-reasons.index', [
            'cancellationReasons' => $cancellationReasons,
        ]);
    }
}
