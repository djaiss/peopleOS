<?php

declare(strict_types=1);

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Str;

class FetchMergedPRs
{
    private $pullRequests;

    public function __construct() {}

    public function execute(): mixed
    {
        $this->fetch();
        $this->format();

        return $this->pullRequests;
    }

    private function fetch(): void
    {
        $client = new Client();
        $owner = 'djaiss';
        $repo = 'peopleos';
        $token = env('GITHUB_TOKEN');

        $response = $client->request('GET', "https://api.github.com/repos/$owner/$repo/pulls", [
            'headers' => [
                'Authorization' => "token $token",
                'Accept' => 'application/vnd.github.v3+json',
            ],
            'query' => [
                'state' => 'closed',
                'sort' => 'updated',
                'direction' => 'desc',
                'per_page' => 10, // Adjust the number of PRs you want to fetch
            ],
        ]);

        $this->pullRequests = json_decode($response->getBody()->getContents(), true);
    }

    private function format(): void
    {
        $this->pullRequests = array_map(function ($pr) {
            return [
                'title' => $pr['title'],
                'number' => $pr['number'],
                'body' => str_replace(
                    ["'", "\n", "\r", "é", "è", "à", "ù"],
                    ["\\'", "\\n", "", "e", "e", "a", "u"],
                    Str::markdown($pr['body'] ?? 'No description provided.')
                ),
                'merged_at' => $pr['merged_at'] ? now()->parse($pr['merged_at'])->diffForHumans() : null,
                'url' => "https://github.com/djaiss/peopleOS/pull/{$pr['number']}",
            ];
        }, $this->pullRequests);
    }
}
