<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Jobs\IncrementPageView;
use App\Models\MarketingPage;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMarketingPage
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $url = $request->fullUrl();

        $page = MarketingPage::where('url', $url)->firstOrCreate([
            'url' => $url,
        ]);

        IncrementPageView::dispatch($page)->onQueue('low');

        $request->attributes->add(['marketingPage' => $page]);

        return $next($request);
    }
}
