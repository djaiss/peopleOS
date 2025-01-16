<?php

declare(strict_types=1);

namespace App\Http\Controllers\Instance;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class InstanceController extends Controller
{
    public function index(): View
    {
        return view('instance.index');
    }

    public function show(): View
    {
        return view('instance.show');
    }
}
