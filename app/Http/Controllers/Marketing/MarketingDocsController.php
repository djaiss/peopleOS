<?php

declare(strict_types=1);

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * This controller is used to handle the marketing documentation pages.
 * It should be one of the only controllers that does not follow the naming convention
 * for methods in a controller.
 */
class MarketingDocsController extends Controller
{
    public function index(Request $request): View
    {
        $marketingPage = $request->attributes->get('marketingPage');

        return view('marketing.docs.index', [
            'marketingPage' => $marketingPage,
            'viewName' => 'marketing.docs.index',
        ]);
    }

    public function introduction(Request $request): View
    {
        $marketingPage = $request->attributes->get('marketingPage');

        return view('marketing.docs.api.introduction', [
            'marketingPage' => $marketingPage,
            'viewName' => 'marketing.docs.api.introduction',
        ]);
    }

    public function authentication(Request $request): View
    {
        $marketingPage = $request->attributes->get('marketingPage');

        return view('marketing.docs.api.authentication', [
            'marketingPage' => $marketingPage,
            'viewName' => 'marketing.docs.api.authentication',
        ]);
    }

    public function errors(Request $request): View
    {
        $marketingPage = $request->attributes->get('marketingPage');

        return view('marketing.docs.api.errors', [
            'marketingPage' => $marketingPage,
            'viewName' => 'marketing.docs.api.errors',
        ]);
    }

    public function profile(Request $request): View
    {
        $marketingPage = $request->attributes->get('marketingPage');

        return view('marketing.docs.api.profile', [
            'marketingPage' => $marketingPage,
            'viewName' => 'marketing.docs.api.profile',
        ]);
    }

    public function logs(Request $request): View
    {
        $marketingPage = $request->attributes->get('marketingPage');

        return view('marketing.docs.api.logs', [
            'marketingPage' => $marketingPage,
            'viewName' => 'marketing.docs.api.logs',
        ]);
    }

    public function apiManagement(Request $request): View
    {
        $marketingPage = $request->attributes->get('marketingPage');

        return view('marketing.docs.api.api-management', [
            'marketingPage' => $marketingPage,
            'viewName' => 'marketing.docs.api.api-management',
        ]);
    }

    public function genders(Request $request): View
    {
        $marketingPage = $request->attributes->get('marketingPage');

        return view('marketing.docs.api.genders', [
            'marketingPage' => $marketingPage,
            'viewName' => 'marketing.docs.api.genders',
        ]);
    }

    public function taskCategories(Request $request): View
    {
        $marketingPage = $request->attributes->get('marketingPage');

        return view('marketing.docs.api.task-categories', [
            'marketingPage' => $marketingPage,
            'viewName' => 'marketing.docs.api.task-categories',
        ]);
    }

    public function gifts(Request $request): View
    {
        $marketingPage = $request->attributes->get('marketingPage');

        return view('marketing.docs.api.gifts', [
            'marketingPage' => $marketingPage,
            'viewName' => 'marketing.docs.api.gifts',
        ]);
    }

    public function tasks(Request $request): View
    {
        $marketingPage = $request->attributes->get('marketingPage');

        return view('marketing.docs.api.tasks', [
            'marketingPage' => $marketingPage,
            'viewName' => 'marketing.docs.api.tasks',
        ]);
    }

    public function journals(Request $request): View
    {
        $marketingPage = $request->attributes->get('marketingPage');

        return view('marketing.docs.api.journals', [
            'marketingPage' => $marketingPage,
            'viewName' => 'marketing.docs.api.journals',
        ]);
    }

    public function entries(Request $request): View
    {
        $marketingPage = $request->attributes->get('marketingPage');

        return view('marketing.docs.api.entries', [
            'marketingPage' => $marketingPage,
            'viewName' => 'marketing.docs.api.entries',
        ]);
    }

    public function updateAge(Request $request): View
    {
        $marketingPage = $request->attributes->get('marketingPage');

        return view('marketing.docs.api.update-age', [
            'marketingPage' => $marketingPage,
            'viewName' => 'marketing.docs.api.update-age',
        ]);
    }
}
