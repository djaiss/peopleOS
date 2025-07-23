<?php

declare(strict_types=1);

namespace App\Services;

use GuzzleHttp\Client;

/**
 * Service to fetch the number of GitHub stars for the peopleOS project.
 *
 * This service calls the GitHub API and returns the stargazers count.
 */
class FetchStars
{
    private int $stars;

    /**
     * Execute the service and return the number of stars.
     *
     * @return int The number of GitHub stars
     */
    public function execute(): int
    {
        $this->fetch();
        return $this->stars;
    }

    /**
     * Fetch the number of stars from the GitHub API.
     *
     * @return void
     */
    private function fetch(): void
    {
        $client = new Client();
        $owner = 'djaiss';
        $repo = 'peopleos';
        $token = env('GITHUB_TOKEN');

        $response = $client->request('GET', "https://api.github.com/repos/{$owner}/{$repo}", [
            'headers' => [
                'Authorization' => "token {$token}",
                'Accept' => 'application/vnd.github.v3+json',
            ],
        ]);

        $data = json_decode($response->getBody()->getContents(), true);
        $this->stars = $data['stargazers_count'] ?? 0;
    }
}
