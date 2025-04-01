<?php

declare(strict_types=1);

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Services\GetPersonnalizationContent;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdministrationPersonalizationController extends Controller
{
    public function index(): View
    {
        $viewData = (new GetPersonnalizationContent(
            user: Auth::user(),
        ))->execute();

        return view('administration.personalization.index', $viewData);
    }
}
