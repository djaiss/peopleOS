<?php
/*
 * @var \App\Models\MarketingPage $marketingPage
 */
?>

<x-marketing-docs-layout :marketing-page="$marketingPage">
  <h1 class="mb-6 text-2xl font-bold">Entries</h1>

  <div class="mb-8 rounded-lg border p-4">
    <p class="mb-2 text-xs">Table of contents</p>

    <ul>
      <li>
        <a href="#entry-object" class="text-blue-500 hover:underline">The Entry object</a>
      </li>
      <li>
        <a href="#get-entry-by-date" class="text-blue-500 hover:underline">Get entry by date</a>
      </li>
    </ul>
  </div>

  <div class="mb-10 grid grid-cols-1 gap-6 border-b border-gray-200 pb-10 sm:grid-cols-2">
    <div>
      <p class="mb-2">This endpoint lets you manage entries in your journals.</p>
      <p class="mb-2">Entries are daily records in your journals. Each entry is associated with a specific date and journal.</p>
      <p class="mb-2">When you request an entry for a specific date, it will either create a new one or return an existing one.</p>
      <p class="mb-10">Once an entry is created, it can not be deleted.</p>
    </div>
    <div>
      <x-marketing.code title="Endpoints">
        <div class="flex flex-col gap-y-2">
          <a href="#get-entry-by-date">
            <span class="text-blue-700">GET</span>
            /api/journals/{journal_id}/entries/{year}/{month}/{day}
          </a>
        </div>
      </x-marketing.code>
    </div>
  </div>

  <!-- Entry object -->
  <div class="mb-10 grid grid-cols-1 gap-6 border-b border-gray-200 pb-10 sm:grid-cols-2">
    <div>
      <h3 id="entry-object" class="mb-2 text-lg font-bold">The Entry object</h3>
      <p class="mb-10">This object represents an entry in your journal.</p>

      <!-- response attributes -->
      <div x-cloak x-data="{ open: false }">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">Attributes</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition>
          <x-marketing.attribute name="id" type="integer" description="The ID of the entry." />
          <x-marketing.attribute name="object" type="string" description="The object type. Always 'entry'." />
          <x-marketing.attribute name="journal_id" type="integer" description="The ID of the journal this entry belongs to." />
          <x-marketing.attribute name="day" type="integer" description="The day of the month (1-31)." />
          <x-marketing.attribute name="month" type="integer" description="The month (1-12)." />
          <x-marketing.attribute name="year" type="integer" description="The year." />
          <x-marketing.attribute name="created_at" type="integer" description="The date and time the object was created, in Unix timestamp format." />
          <x-marketing.attribute name="updated_at" type="integer" description="The date and time the object was last updated, in Unix timestamp format." />
        </div>
      </div>
    </div>
    <div>
      <x-marketing.code title="Example" verbClass="text-blue-700">
        <div>{</div>
        <div class="pl-4">"data": {</div>
        @include('marketing.docs.api.partials.entry-response')
        <div class="pl-4">}</div>
        <div>}</div>
      </x-marketing.code>
    </div>
  </div>

  <!-- GET /api/journals/{journal_id}/entries/{year}/{month}/{day} -->
  <div class="mb-10 grid grid-cols-1 gap-6 border-b border-gray-200 pb-10 sm:grid-cols-2">
    <div>
      <h3 id="get-entry-by-date" class="mb-2 text-lg font-bold">Get entry by date</h3>
      <p class="mb-10">This endpoint retrieves or creates an entry for a specific date. If an entry already exists for the given date, it will be returned. Otherwise, a new entry will be created.</p>

      <!-- url parameters -->
      <div x-cloak x-data="{ open: false }" class="mb-8">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="mb-2 flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">URL parameters</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition class="mt-2">
          <x-marketing.attribute required name="journal_id" type="integer" description="The ID of the journal the entry belongs to." />
          <x-marketing.attribute required name="year" type="integer" description="The year of the entry." />
          <x-marketing.attribute required name="month" type="integer" description="The month of the entry (1-12)." />
          <x-marketing.attribute required name="day" type="integer" description="The day of the entry (1-31)." />
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
          <x-marketing.attribute name="data" type="object" description="The requested or newly created entry object." />
        </div>
      </div>
    </div>
    <div>
      <x-marketing.code title="/api/journals/{journal_id}/entries/{year}/{month}/{day}" verb="GET" verbClass="text-blue-700">
        <div>{</div>
        <div class="pl-4">"data": {</div>
        @include('marketing.docs.api.partials.entry-response')
        <div class="pl-4">}</div>
        <div>}</div>
      </x-marketing.code>
    </div>
  </div>

  <div>
    <x-marketing-page-widget :marketing-page="$marketingPage" />
  </div>
</x-marketing-docs-layout>
