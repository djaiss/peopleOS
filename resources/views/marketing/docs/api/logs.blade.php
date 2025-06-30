<?php
/*
 * @var \App\Models\MarketingPage $marketingPage
 * @var string $viewName
 */
?>

<x-marketing-docs-layout :marketing-page="$marketingPage" :view-name="$viewName">
  <h1 class="mb-6 text-2xl font-bold">Logs</h1>

  <div class="mb-8 rounded-lg border p-4">
    <p class="mb-2 text-xs">Table of contents</p>

    <ul>
      <li>
        <a href="#get-the-logs-of-the-current-user" class="text-blue-500 hover:underline">Get the logs of the current user</a>
      </li>
      <li>
        <a href="#get-a-log" class="text-blue-500 hover:underline">Get a specific log</a>
      </li>
    </ul>
  </div>

  <div class="mb-10 grid grid-cols-1 gap-6 border-b border-gray-200 pb-10 sm:grid-cols-2">
    <div>
      <p class="mb-2">This endpoint gets the logs of the current user. This is useful to understand what the user has done in the account.</p>
    </div>
    <div>
      <x-marketing.code title="Endpoints">
        <div class="flex flex-col gap-y-2">
          <a href="#get-the-information-about-the-logged-user">
            <span class="text-blue-700">GET</span>
            /api/administration/logs
          </a>
        </div>
      </x-marketing.code>
    </div>
  </div>

  <!-- GET /api/administration/logs -->
  <div class="mb-10 grid grid-cols-1 gap-6 border-b border-gray-200 pb-10 sm:grid-cols-2">
    <div>
      <h3 id="get-the-logs-of-the-current-user" class="mb-2 text-lg font-bold">Get the logs of the current user</h3>
      <p class="mb-2">This endpoint gets the logs of the current user. This is useful to understand what the user has done in the account.</p>
      <p class="mb-10">This call is paginated, and the default page size is 10. This can not be changed.</p>

      <!-- url parameters -->
      <div x-cloak x-data="{ open: false }" class="mb-8">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="mb-2 flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">URL parameters</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition class="mt-2">
          <p class="text-gray-500">This endpoint does not have any parameters.</p>
        </div>
      </div>

      <!-- query parameters -->
      <div x-cloak x-data="{ open: false }" class="mb-8">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="mb-2 flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">Query parameters</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition class="mt-2">
          <x-marketing.attribute name="page" type="integer" description="The page number to retrieve. The first page is 1. If you don't provide this parameter, the first page will be returned." />
        </div>
      </div>

      <!-- response attributes -->
      <div x-cloak x-data="{ open: false }">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">Response attributes</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition>
          <x-marketing.attribute name="type" type="string" description="The type of the resource." />
          <x-marketing.attribute name="id" type="string" description="The ID of the log." />
          <x-marketing.attribute name="attributes" type="object" description="The attributes of the log." />
          <x-marketing.attribute name="attributes.name" type="string" description="The name of the Person the action was performed on." />
          <x-marketing.attribute name="attributes.action" type="string" description="The action that was performed. There are many actions." />
          <x-marketing.attribute name="attributes.description" type="string" description="The description of the action." />
          <x-marketing.attribute name="attributes.created_at" type="integer" description="The date and time the object was created, in Unix timestamp format." />
          <x-marketing.attribute name="attributes.updated_at" type="integer" description="The date and time the object was last updated, in Unix timestamp format." />
          <x-marketing.attribute name="links" type="object" description="The links to access the log." />
        </div>
      </div>
    </div>
    <div>
      <x-marketing.code title="/api/administration/logs" verb="GET" verbClass="text-blue-700">
        <div>{</div>
        <div class="pl-4">"data": [</div>
        <div class="pl-8">{</div>
        <div class="pl-12">
          "type":
          <span class="text-lime-700">"log"</span>
          ,
        </div>
        <div class="pl-12">
          "id":
          <span class="text-rose-800">"663"</span>
          ,
        </div>
        <div class="pl-12">"attributes": {</div>
        <div class="pl-16">
          "name":
          <span class="text-lime-700">"Dwight Schrute"</span>
          ,
        </div>
        <div class="pl-16">
          "action":
          <span class="text-lime-700">"timezone_update"</span>
          ,
        </div>
        <div class="pl-16">
          "description":
          <span class="text-lime-700">"Updated their timezone"</span>
          ,
        </div>
        <div class="pl-16">
          "created_at":
          <span class="text-rose-800">1751305720</span>
          ,
        </div>
        <div class="pl-16">
          "updated_at":
          <span class="text-rose-800">1751305720</span>
        </div>
        <div class="pl-12">},</div>
        <div class="pl-12">"links": {</div>
        <div class="pl-16">
          "self":
          <span class="text-lime-700">"{{ config('app.url') }}/api/administration/logs/663"</span>
        </div>
        <div class="pl-12">}</div>
        <div class="pl-8">},</div>
        <div class="pl-8">{</div>
        <div class="pl-12">...</div>
        <div class="pl-8">}</div>
        <div class="pl-4">],</div>
        <div class="pl-4">"links": {</div>
        <div class="pl-8">
          "first":
          <span class="text-lime-700">"{{ config('app.url') }}/api/administration/logs?page=1"</span>
          ,
        </div>
        <div class="pl-8">
          "last":
          <span class="text-lime-700">"{{ config('app.url') }}/api/administration/logs?page=66"</span>
          ,
        </div>
        <div class="pl-8">
          "prev":
          <span class="text-gray-500">null</span>
          ,
        </div>
        <div class="pl-8">
          "next":
          <span class="text-lime-700">"{{ config('app.url') }}/api/administration/logs?page=2"</span>
        </div>
        <div class="pl-4">},</div>
        <div class="pl-4">"meta": {</div>
        <div class="pl-8">
          "current_page":
          <span class="text-rose-800">1</span>
          ,
        </div>
        <div class="pl-8">
          "from":
          <span class="text-rose-800">1</span>
          ,
        </div>
        <div class="pl-8">
          "last_page":
          <span class="text-rose-800">66</span>
          ,
        </div>
        <div class="pl-8">"links": [</div>
        <div class="pl-12">{</div>
        <div class="pl-16">
          "url":
          <span class="text-gray-500">null</span>
          ,
        </div>
        <div class="pl-16">
          "label":
          <span class="text-lime-700">"&laquo; Previous"</span>
          ,
        </div>
        <div class="pl-16">
          "active":
          <span class="text-gray-500">false</span>
        </div>
        <div class="pl-12">},</div>
        <div class="pl-12">{</div>
        <div class="pl-16">
          "url":
          <span class="text-lime-700">"{{ config('app.url') }}/api/administration/logs?page=1"</span>
          ,
        </div>
        <div class="pl-16">
          "label":
          <span class="text-lime-700">"1"</span>
          ,
        </div>
        <div class="pl-16">
          "active":
          <span class="text-gray-500">true</span>
        </div>
        <div class="pl-12">},</div>
        <div class="pl-12">{</div>
        <div class="pl-16">...</div>
        <div class="pl-12">},</div>
        <div class="pl-12">{</div>
        <div class="pl-16">
          "url":
          <span class="text-gray-500">{{ config('app.url') }}/api/administration/logs?page=1</span>
          ,
        </div>
        <div class="pl-16">
          "label":
          <span class="text-lime-700">"Next &raquo;"</span>
          ,
        </div>
        <div class="pl-16">
          "active":
          <span class="text-gray-500">false</span>
        </div>
        <div class="pl-12">}</div>
        <div class="pl-8">],</div>
        <div class="pl-8">
          "path":
          <span class="text-lime-700">"{{ config('app.url') }}/api/administration/logs"</span>
          ,
        </div>
        <div class="pl-8">
          "per_page":
          <span class="text-rose-800">10</span>
          ,
        </div>
        <div class="pl-8">
          "to":
          <span class="text-rose-800">10</span>
          ,
        </div>
        <div class="pl-8">
          "total":
          <span class="text-rose-800">660</span>
        </div>
        <div class="pl-4">}</div>
        <div>}</div>
      </x-marketing.code>
    </div>
  </div>

  <!-- GET /api/administration/logs/{log} -->
  <div class="mb-10 grid grid-cols-1 gap-6 border-b border-gray-200 pb-10 sm:grid-cols-2">
    <div>
      <h3 id="get-a-log" class="mb-2 text-lg font-bold">Get a specific log</h3>
      <p class="mb-10">This endpoint gets a specific log.</p>

      <!-- url parameters -->
      <div x-cloak x-data="{ open: false }" class="mb-8">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="mb-2 flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">URL parameters</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition class="mt-2">
          <x-marketing.attribute required name="log" type="integer" description="The ID of the log to get." />
        </div>
      </div>

      <!-- query parameters -->
      <div x-cloak x-data="{ open: false }" class="mb-8">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="mb-2 flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">Query parameters</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition class="mt-2">
          <p class="text-gray-500">No query parameters are available for this endpoint.</p>
        </div>
      </div>

      <!-- response attributes -->
      <div x-cloak x-data="{ open: false }">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">Response attributes</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition>
          <x-marketing.attribute name="type" type="string" description="The type of the resource." />
          <x-marketing.attribute name="id" type="string" description="The ID of the log." />
          <x-marketing.attribute name="attributes" type="object" description="The attributes of the log." />
          <x-marketing.attribute name="attributes.name" type="string" description="The name of the Person the action was performed on." />
          <x-marketing.attribute name="attributes.action" type="string" description="The action that was performed. There are many actions." />
          <x-marketing.attribute name="attributes.description" type="string" description="The description of the action." />
          <x-marketing.attribute name="attributes.created_at" type="integer" description="The date and time the object was created, in Unix timestamp format." />
          <x-marketing.attribute name="attributes.updated_at" type="integer" description="The date and time the object was last updated, in Unix timestamp format." />
          <x-marketing.attribute name="links" type="object" description="The links to access the log." />
        </div>
      </div>
    </div>
    <div>
      <x-marketing.code title="/api/administration/logs/{log}" verb="GET" verbClass="text-blue-700">
        <div>{</div>
        <div class="pl-4">"data": {</div>
        <div class="pl-8">
          "type":
          <span class="text-lime-700">"log"</span>
          ,
        </div>
        <div class="pl-8">
          "id":
          <span class="text-rose-800">"663"</span>
          ,
        </div>
        <div class="pl-8">"attributes": {</div>
        <div class="pl-12">
          "name":
          <span class="text-lime-700">"Dwight Schrute"</span>
          ,
        </div>
        <div class="pl-12">
          "action":
          <span class="text-lime-700">"timezone_update"</span>
          ,
        </div>
        <div class="pl-12">
          "description":
          <span class="text-lime-700">"Updated their timezone"</span>
          ,
        </div>
        <div class="pl-12">
          "created_at":
          <span class="text-rose-800">1751305720</span>
          ,
        </div>
        <div class="pl-12">
          "updated_at":
          <span class="text-rose-800">1751305720</span>
        </div>
        <div class="pl-8">},</div>
        <div class="pl-8">"links": {</div>
        <div class="pl-12">
          "self":
          <span class="text-lime-700">"{{ config('app.url') }}/api/administration/logs/663"</span>
        </div>
        <div class="pl-8">}</div>
        <div class="pl-4">}</div>
        <div>}</div>
      </x-marketing.code>
    </div>
  </div>

  <div>
    <x-marketing-page-widget :marketing-page="$marketingPage" :view-name="$viewName" />
  </div>
</x-marketing-docs-layout>
