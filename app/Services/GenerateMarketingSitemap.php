<?php

declare(strict_types=1);

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

/**
 * This service generates a sitemap for all marketing routes.
 */
class GenerateMarketingSitemap
{
    public function execute(): void
    {
        $sitemap = Sitemap::create();

        $marketingRoutes = $this->getMarketingRoutes();

        foreach ($marketingRoutes as $route) {
            $url = Url::create($route['url'])
                ->setLastModificationDate($route['lastModified']);

            // Set homepage to daily frequency and priority 1
            if ($route['routeName'] === 'marketing.index') {
                $url->setChangeFrequency('daily')->setPriority(1.0);
            } else {
                $url->setChangeFrequency('weekly')->setPriority(0.8);
            }

            $sitemap->add($url);
        }

        $sitemap->writeToFile(public_path('sitemap.xml'));
    }

    /**
     * Get all marketing routes with their URLs and last modification dates.
     *
     * @return array<int, array<string, mixed>>
     */
    private function getMarketingRoutes(): array
    {
        $routes = [];
        $marketingTimestamps = config('marketing-timestamps.pages', []);

        // Get all routes that use the marketing middleware
        $routeCollection = Route::getRoutes();
        $baseUrl = 'https://peopleos.cloud';

        foreach ($routeCollection as $route) {
            $middleware = $route->middleware();

            // Check if route uses marketing middleware
            if (in_array('marketing', $middleware) && in_array('marketing.page', $middleware)) {
                $routeName = $route->getName();

                if ($routeName) {
                    $url = $baseUrl . '/' . mb_ltrim((string) $route->uri(), '/');

                    // Get last modification date from config or use current date
                    $lastModified = $marketingTimestamps[$routeName] ?? now()->toDateTimeString();

                    $routes[] = [
                        'url' => $url,
                        'lastModified' => Carbon::parse($lastModified),
                        'routeName' => $routeName,
                    ];
                }
            }
        }

        return $routes;
    }
}
