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
        ]);
    }

    public function introduction(Request $request): View
    {
        $marketingPage = $request->attributes->get('marketingPage');

        return view('marketing.docs.api.introduction', [
            'marketingPage' => $marketingPage,
        ]);
    }

    public function authentication(Request $request): View
    {
        $marketingPage = $request->attributes->get('marketingPage');

        return view('marketing.docs.api.authentication', [
            'marketingPage' => $marketingPage,
        ]);
    }

    public function errors(Request $request): View
    {
        $marketingPage = $request->attributes->get('marketingPage');

        return view('marketing.docs.api.errors', [
            'marketingPage' => $marketingPage,
        ]);
    }

    public function profile(Request $request): View
    {
        $marketingPage = $request->attributes->get('marketingPage');

        return view('marketing.docs.api.profile', [
            'marketingPage' => $marketingPage,
        ]);
    }

    public function logs(Request $request): View
    {
        $marketingPage = $request->attributes->get('marketingPage');

        return view('marketing.docs.api.logs', [
            'marketingPage' => $marketingPage,
        ]);
    }

    public function apiManagement(Request $request): View
    {
        $marketingPage = $request->attributes->get('marketingPage');

        return view('marketing.docs.api.api-management', [
            'marketingPage' => $marketingPage,
        ]);
    }

    public function genders(Request $request): View
    {
        $marketingPage = $request->attributes->get('marketingPage');

        return view('marketing.docs.api.genders', [
            'marketingPage' => $marketingPage,
        ]);
    }

    public function taskCategories(Request $request): View
    {
        $marketingPage = $request->attributes->get('marketingPage');

        return view('marketing.docs.api.task-categories', [
            'marketingPage' => $marketingPage,
        ]);
    }

    public function gifts(Request $request): View
    {
        $marketingPage = $request->attributes->get('marketingPage');

        return view('marketing.docs.api.gifts', [
            'marketingPage' => $marketingPage,
        ]);
    }

    public function tasks(Request $request): View
    {
        $marketingPage = $request->attributes->get('marketingPage');

        return view('marketing.docs.api.tasks', [
            'marketingPage' => $marketingPage,
        ]);
    }

    public function journals(Request $request): View
    {
        $marketingPage = $request->attributes->get('marketingPage');

        return view('marketing.docs.api.journals', [
            'marketingPage' => $marketingPage,
        ]);
    }

    public function entries(Request $request): View
    {
        $marketingPage = $request->attributes->get('marketingPage');

        return view('marketing.docs.api.entries', [
            'marketingPage' => $marketingPage,
        ]);
    }

    public function updateAge(Request $request): View
    {
        $marketingPage = $request->attributes->get('marketingPage');

        return view('marketing.docs.api.update-age', [
            'marketingPage' => $marketingPage,
        ]);
    }
}
