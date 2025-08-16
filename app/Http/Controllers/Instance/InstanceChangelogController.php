<?php

declare(strict_types=1);

namespace App\Http\Controllers\Instance;

use App\Enums\UserWaitlistStatus;
use App\Http\Controllers\Controller;
use App\Models\UserWaitlist;
use App\Services\ApproveUserWaitlist;
use App\Services\RejectUserFromWaitlist;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class InstanceChangelogController extends Controller
{
    public function index(): View
    {

        return view('instance.changelogs.index');
    }
}
