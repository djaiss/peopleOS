<?php
/*
 * @var \App\Models\MarketingPage $marketingPage
 * @var string $viewName
 */
?>

{{-- @llms-title: HTTP status codes --}}
{{-- @llms-description: Learn about HTTP status codes --}}
{{-- @llms-route: /docs/api/errors --}}
<x-marketing-docs-layout :marketing-page="$marketingPage" :view-name="$viewName">
  <h1 class="mb-6 text-2xl font-bold">HTTP status codes</h1>

  <div class="mb-10 grid grid-cols-1 gap-6 sm:grid-cols-2">
    <div>
      <p class="mb-2">PeopleOS uses conventional HTTP response codes to indicate the success or failure of an API request.</p>
      <p class="mb-2">
        In general: codes in the
        <span class="rounded-md border border-gray-200 bg-gray-50 px-1 py-0 font-mono">2xx</span>
        range indicate success. Codes in the
        <span class="rounded-md border border-gray-200 bg-gray-50 px-1 py-0 font-mono">4xx</span>
        range indicate an error that failed given the information provided. Codes in the
        <span class="rounded-md border border-gray-200 bg-gray-50 px-1 py-0 font-mono">5xx</span>
        range indicate an error with the servers, but that should not happen often.
      </p>
    </div>
    <div>
      <x-marketing.code title="HTTP Status Code Summary">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-[75px_1fr]">
          <div class="rounded-md bg-gray-50 px-3 py-2 font-mono">200</div>
          <div class="flex flex-col">
            <span class="font-semibold">OK</span>
            <span class="text-gray-600">Everything worked as expected.</span>
          </div>

          <div class="rounded-md bg-gray-50 px-3 py-2 font-mono">201</div>
          <div class="flex flex-col">
            <span class="font-semibold">Created</span>
            <span class="text-gray-600">The request was successful and a new resource was created.</span>
          </div>

          <div class="rounded-md bg-gray-50 px-3 py-2 font-mono">204</div>
          <div class="flex flex-col">
            <span class="font-semibold">No Content</span>
            <span class="text-gray-600">The request was successful and the response contains no content.</span>
          </div>

          <div class="rounded-md bg-gray-50 px-3 py-2 font-mono">400</div>
          <div class="flex flex-col">
            <span class="font-semibold">Bad Request</span>
            <span class="text-gray-600">The request was unacceptable, often due to missing a required parameter.</span>
          </div>

          <div class="rounded-md bg-gray-50 px-3 py-2 font-mono">401</div>
          <div class="flex flex-col">
            <span class="font-semibold">Unauthorized</span>
            <span class="text-gray-600">No valid API key provided.</span>
          </div>

          <div class="rounded-md bg-gray-50 px-3 py-2 font-mono">402</div>
          <div class="flex flex-col">
            <span class="font-semibold">Request Failed</span>
            <span class="text-gray-600">The parameters were valid but the request failed.</span>
          </div>

          <div class="rounded-md bg-gray-50 px-3 py-2 font-mono">403</div>
          <div class="flex flex-col">
            <span class="font-semibold">Forbidden</span>
            <span class="text-gray-600">The API key doesn't have permissions to perform the request.</span>
          </div>

          <div class="rounded-md bg-gray-50 px-3 py-2 font-mono">404</div>
          <div class="flex flex-col">
            <span class="font-semibold">Not Found</span>
            <span class="text-gray-600">The requested resource doesn't exist.</span>
          </div>

          <div class="rounded-md bg-gray-50 px-3 py-2 font-mono">409</div>
          <div class="flex flex-col">
            <span class="font-semibold">Conflict</span>
            <span class="text-gray-600">The request conflicts with another request (perhaps due to using the same idempotent key).</span>
          </div>

          <div class="rounded-md bg-gray-50 px-3 py-2 font-mono">429</div>
          <div class="flex flex-col">
            <span class="font-semibold">Too Many Requests</span>
            <span class="text-gray-600">Too many requests hit the API too quickly. We recommend an exponential backoff of your requests.</span>
          </div>

          <div class="rounded-md bg-gray-50 px-3 py-2 font-mono">500, 502, 503, 504</div>
          <div class="flex flex-col">
            <span class="font-semibold">Server Errors</span>
            <span class="text-gray-600">Something went wrong on PeopleOS's end.</span>
          </div>
        </div>
      </x-marketing.code>
    </div>
  </div>

  <div>
    <x-marketing-page-widget :marketing-page="$marketingPage" :view-name="$viewName" />
  </div>
</x-marketing-docs-layout>
