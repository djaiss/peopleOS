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

      <!-- parameters -->
      <div x-cloak x-data="{ open: false }" class="mb-10">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="mb-2 flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">Parameters</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition class="mt-2">
          <x-marketing.attribute name="page" type="integer" description="The page number to retrieve. The first page is 1." />
        </div>
      </div>

      <!-- response attributes -->
      <div x-cloak x-data="{ open: false }">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">Response attributes</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition>
          <x-marketing.attribute name="id" type="integer" description="The ID of the log." />
          <x-marketing.attribute name="object" type="string" description="The object type. Always 'log'." />
          <x-marketing.attribute name="name" type="string" description="The name of the Person the action was performed on." />
          <x-marketing.attribute name="action" type="string" description="The action that was performed. There are many actions." />
          <x-marketing.attribute name="description" type="string" description="The description of the action." />
          <x-marketing.attribute name="created_at" type="integer" description="The date and time the object was created, in Unix timestamp format." />
          <x-marketing.attribute name="updated_at" type="integer" description="The date and time the object was last updated, in Unix timestamp format." />
        </div>
      </div>
    </div>
    <div>
      <x-marketing.code title="/api/administration/logs" verb="GET" verbClass="text-blue-700">
        <div>{</div>
        <div class="pl-4">
          "id":
          <span class="text-rose-800">4</span>
          ,
        </div>
        <div class="pl-4">
          "object":
          <span class="text-lime-700">"log"</span>
          ,
        </div>
        <div class="pl-4">
          "name":
          <span class="text-lime-700">"Ross Geller"</span>
          ,
        </div>
        <div class="pl-4">
          "action":
          <span class="text-lime-700">"login"</span>
          ,
        </div>
        <div class="pl-4">
          "description":
          <span class="text-lime-700">"User logged in"</span>
          ,
        </div>
        <div class="pl-4">
          "created_at":
          <span class="text-rose-800">1715145600</span>
          ,
        </div>
        <div class="pl-4">
          "updated_at":
          <span class="text-rose-800">1715145600</span>
          ,
        </div>
        <div>}</div>
      </x-marketing.code>
    </div>
  </div>

  <div>
    <x-marketing-page-widget :marketing-page="$marketingPage" />
  </div>
</x-marketing-docs-layout>
