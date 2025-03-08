<?php

declare(strict_types=1);

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

/**
 * This controller is used to handle the marketing documentation pages.
 * It should be the only controller that does not follow the naming convention
 * for methods in a controller.
 */
class MarketingDocsController extends Controller
{
    public function index(): View
    {
        return view('marketing.docs.index');
    }

    public function introduction(): View
    {
        return view('marketing.docs.api.introduction');
    }

    public function authentication(): View
    {
        return view('marketing.docs.api.authentication');
    }

    public function errors(): View
    {
        return view('marketing.docs.api.errors');
    }

    public function profile(): View
    {
        return view('marketing.docs.api.profile');
    }

    public function logs(): View
    {
        return view('marketing.docs.api.logs');
    }

    public function apiManagement(): View
    {
        return view('marketing.docs.api.api-management');
    }
}
