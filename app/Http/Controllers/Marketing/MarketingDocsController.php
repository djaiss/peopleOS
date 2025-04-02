<?php

declare(strict_types=1);

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * This controller is used to handle the marketing documentation pages.
 * It should be the only controller that does not follow the naming convention
 * for methods in a controller.
 */
class MarketingDocsController extends Controller
{
    public function index(Request $request): View
    {
        $marketingPage = $request->attributes->get('marketingPage');

        return view('marketing.docs.index', [
            'pageviews' => number_format($marketingPage->pageviews ?? 0),
        ]);
    }

    public function introduction(Request $request): View
    {
        $marketingPage = $request->attributes->get('marketingPage');

        return view('marketing.docs.api.introduction', [
            'pageviews' => number_format($marketingPage->pageviews ?? 0),
        ]);
    }

    public function authentication(Request $request): View
    {
        $marketingPage = $request->attributes->get('marketingPage');

        return view('marketing.docs.api.authentication', [
            'pageviews' => number_format($marketingPage->pageviews ?? 0),
        ]);
    }

    public function errors(Request $request): View
    {
        $marketingPage = $request->attributes->get('marketingPage');

        return view('marketing.docs.api.errors', [
            'pageviews' => number_format($marketingPage->pageviews ?? 0),
        ]);
    }

    public function profile(Request $request): View
    {
        $marketingPage = $request->attributes->get('marketingPage');

        return view('marketing.docs.api.profile', [
            'pageviews' => number_format($marketingPage->pageviews ?? 0),
        ]);
    }

    public function logs(Request $request): View
    {
        $marketingPage = $request->attributes->get('marketingPage');

        return view('marketing.docs.api.logs', [
            'pageviews' => number_format($marketingPage->pageviews ?? 0),
        ]);
    }

    public function apiManagement(Request $request): View
    {
        $marketingPage = $request->attributes->get('marketingPage');

        return view('marketing.docs.api.api-management', [
            'pageviews' => number_format($marketingPage->pageviews ?? 0),
        ]);
    }

    public function genders(Request $request): View
    {
        $marketingPage = $request->attributes->get('marketingPage');

        return view('marketing.docs.api.genders', [
            'pageviews' => number_format($marketingPage->pageviews ?? 0),
        ]);
    }

    public function taskCategories(Request $request): View
    {
        $marketingPage = $request->attributes->get('marketingPage');

        return view('marketing.docs.api.task-categories', [
            'pageviews' => number_format($marketingPage->pageviews ?? 0),
        ]);
    }

    public function gifts(Request $request): View
    {
        $marketingPage = $request->attributes->get('marketingPage');

        return view('marketing.docs.api.gifts', [
            'pageviews' => number_format($marketingPage->pageviews ?? 0),
        ]);
    }

    public function tasks(Request $request): View
    {
        $marketingPage = $request->attributes->get('marketingPage');

        return view('marketing.docs.api.tasks', [
            'pageviews' => number_format($marketingPage->pageviews ?? 0),
        ]);
    }

    public function journals(Request $request): View
    {
        $marketingPage = $request->attributes->get('marketingPage');

        return view('marketing.docs.api.journals', [
            'pageviews' => number_format($marketingPage->pageviews ?? 0),
        ]);
    }

    public function entries(Request $request): View
    {
        $marketingPage = $request->attributes->get('marketingPage');

        return view('marketing.docs.api.entries', [
            'pageviews' => number_format($marketingPage->pageviews ?? 0),
        ]);
    }

    public function updateAge(Request $request): View
    {
        $marketingPage = $request->attributes->get('marketingPage');

        return view('marketing.docs.api.update-age', [
            'pageviews' => number_format($marketingPage->pageviews ?? 0),
        ]);
    }
}
