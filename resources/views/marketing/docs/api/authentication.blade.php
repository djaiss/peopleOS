<?php
/*
 * @var \App\Models\MarketingPage $marketingPage
 * @var string $viewName
 */
?>

<x-marketing-docs-layout :marketing-page="$marketingPage" :view-name="$viewName">
  <h1 class="mb-6 text-2xl font-bold">Authentication</h1>

  <div class="mb-10 grid grid-cols-1 gap-6 border-b border-gray-200 pb-10 sm:grid-cols-2">
    <div>
      <p class="mb-2">The PeopleOS API uses API keys to authenticate requests. You can view and manage your API keys in your administration panel.</p>
      <p class="mb-2">Your API keys carry many privileges, so be sure to keep them secure! Do not share your secret API keys in publicly accessible areas such as GitHub, client-side code, and so forth.</p>
      <p class="mb-2">On our instance, all API requests must be made over HTTPS. Calls made over plain HTTP will fail. API requests without authentication will also fail. On your instance, it will be up to you.</p>
      <p class="mb-2">You must use the API key in the Authorization header. The value must be Bearer followed by a space and then the API key.</p>
      <p class="mb-2">
        On our instance, the API calls are rate limited to 60 requests per minute. On your instance, you can change that settings in the
        <a href="https://github.com/djaiss/peopleOS/blob/main/routes/api.php" target="_blank" class="text-blue-500 hover:underline">api.php</a>
        configuration file.
      </p>
      <p class="mb-2">There are two ways to get an API key:</p>
      <ul class="list-disc pl-5">
        <li>
          <p class="mb-2">You can create an API key in the settings section of your account.</p>
        </li>
        <li>
          <p class="mb-2">You can use the login API route, described below, to login with your email and password. This will give you an API key that you can use to authenticate your requests.</p>
        </li>
      </ul>
    </div>
    <div>
      <p class="mb-2">
        <x-marketing.code>curl -X GET "{{ config('app.url') }}/api/persons" \ -H "Authorization: Bearer YOUR_API_KEY"</x-marketing.code>
      </p>
    </div>
  </div>

  <!-- GET /api/login -->
  <div class="mb-10 grid grid-cols-1 gap-6 border-b border-gray-200 pb-10 sm:grid-cols-2">
    <div>
      <h3 id="login" class="mb-2 text-lg font-bold">Login</h3>
      <p class="mb-10">This endpoint logs in a user and returns an API key.</p>

      <!-- query parameters -->
      <div x-cloak x-data="{ open: false }" class="mb-8">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="mb-2 flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">Query parameters</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition class="mt-2">
          <x-marketing.attribute required name="email" type="string" description="The email of the user. Maximum 255 characters." />
          <x-marketing.attribute required name="password" type="string" description="The password of the user. Maximum 255 characters." />
        </div>
      </div>

      <!-- response attributes -->
      <div x-cloak x-data="{ open: false }">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">Response attributes</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition>
          <x-marketing.attribute name="message" type="string" description="The message of the response." />
          <x-marketing.attribute name="status" type="integer" description="The status code of the response." />
          <x-marketing.attribute name="data" type="object" description="The data of the response." />
          <x-marketing.attribute name="token" type="string" description="The API key of the user." />
        </div>
      </div>
    </div>
    <div>
      <x-marketing.code title="/api/me" verb="GET" verbClass="text-blue-700">
        <div>{</div>
        <div class="pl-4">
          "message":
          <span class="text-rose-800">"Authenticated"</span>
          ,
        </div>
        <div class="pl-4">
          "status":
          <span class="text-lime-700">200</span>
          ,
        </div>
        <div class="pl-4">"data": {</div>
        <div class="pl-8">
          "token":
          <span class="text-lime-700">"1|1234567890"</span>
          ,
        </div>
        <div class="pl-4">}</div>
        <div>}</div>
      </x-marketing.code>
    </div>
  </div>

  <div>
    <x-marketing-page-widget :marketing-page="$marketingPage" :view-name="$viewName" />
  </div>
</x-marketing-docs-layout>
