<?php
/*
 * @var \App\Models\MarketingPage $marketingPage
 * @var string $viewName
 */
?>

<x-marketing-docs-layout :marketing-page="$marketingPage" :view-name="$viewName">
  <h1 class="mb-6 text-2xl font-bold">Authentication</h1>

  <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
    <div>
      <p class="mb-2">The PeopleOS API uses API keys to authenticate requests. You can view and manage your API keys in your administration panel.</p>
      <p class="mb-2">Your API keys carry many privileges, so be sure to keep them secure! Do not share your secret API keys in publicly accessible areas such as GitHub, client-side code, and so forth.</p>
      <p class="mb-2">On our instance, all API requests must be made over HTTPS. Calls made over plain HTTP will fail. API requests without authentication will also fail. On your instance, it will be up to you.</p>
      <p class="mb-2">You must use the API key in the Authorization header. The value must be Bearer followed by a space and then the API key.</p>
      <p class="mb-10">On our instance, the API calls are rate limited to 60 requests per minute. On your instance, you can change that settings in the api.php configuration file.</p>
    </div>
    <div>
      <p class="mb-2">
        <x-marketing.code>curl -X GET "{{ config('app.url') }}/api/persons" \ -H "Authorization: Bearer YOUR_API_KEY"</x-marketing.code>
      </p>
    </div>
  </div>

  <div>
    <x-marketing-page-widget :marketing-page="$marketingPage" />
  </div>
</x-marketing-docs-layout>
