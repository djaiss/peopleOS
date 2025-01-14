<?php

declare(strict_types=1);

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class AdministrationOfficeController extends Controller
{
    public function index(): View
    {
        return view('administration.offices.index');
    }
}
