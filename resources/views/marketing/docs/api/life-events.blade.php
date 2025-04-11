<?php
/*
 * @var \App\Models\MarketingPage $marketingPage
 * @var string $viewName
 */
?>

<x-marketing-docs-layout :marketing-page="$marketingPage" :view-name="$viewName">
  <h1 class="mb-6 text-2xl font-bold">Life Events</h1>

  <div class="mb-8 rounded-lg border p-4">
    <p class="mb-2 text-xs">Table of contents</p>

    <ul>
      <li>
        <a href="#life-event-object" class="text-blue-500 hover:underline">The Life Event object</a>
      </li>
      <li>
        <a href="#get-the-list-of-life-events" class="text-blue-500 hover:underline">Get the list of life events for a person</a>
      </li>
      <li>
        <a href="#get-a-specific-life-event" class="text-blue-500 hover:underline">Get a specific life event</a>
      </li>
      <li>
        <a href="#create-a-new-life-event" class="text-blue-500 hover:underline">Create a new life event</a>
      </li>
      <li>
        <a href="#update-a-life-event" class="text-blue-500 hover:underline">Update a life event</a>
      </li>
      <li>
        <a href="#delete-a-life-event" class="text-blue-500 hover:underline">Delete a life event</a>
      </li>
    </ul>
  </div>

  <div class="mb-10 grid grid-cols-1 gap-6 border-b border-gray-200 pb-10 sm:grid-cols-2">
    <div>
      <p class="mb-2">This endpoint lets you manage life events for contacts in your account.</p>
      <p class="mb-2">Life events help you track important moments in a person's life, such as birthdays, anniversaries, or other significant occasions.</p>
      <p class="mb-10">Each life event can be customized with an icon, colors, and reminder settings.</p>
    </div>
    <div>
      <x-marketing.code title="Endpoints">
        <div class="flex flex-col gap-y-2">
          <a href="#get-the-list-of-life-events">
            <span class="text-blue-700">GET</span>
            /api/persons/{person_id}/life-events
          </a>
          <a href="#get-a-specific-life-event">
            <span class="text-blue-700">GET</span>
            /api/persons/{person_id}/life-events/{id}
          </a>
          <a href="#create-a-new-life-event">
            <span class="text-green-700">POST</span>
            /api/persons/{person_id}/life-events
          </a>
          <a href="#update-a-life-event">
            <span class="text-yellow-700">PUT</span>
            /api/persons/{person_id}/life-events/{id}
          </a>
          <a href="#delete-a-life-event">
            <span class="text-red-700">DELETE</span>
            /api/persons/{person_id}/life-events/{id}
          </a>
        </div>
      </x-marketing.code>
    </div>
  </div>

  <!-- Life Event object -->
  <div class="mb-10 grid grid-cols-1 gap-6 border-b border-gray-200 pb-10 sm:grid-cols-2">
    <div>
      <h3 id="life-event-object" class="mb-2 text-lg font-bold">The Life Event object</h3>
      <p class="mb-10">This object represents a life event attached to a person in your account.</p>

      <!-- response attributes -->
      <div x-cloak x-data="{ open: false }">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">Attributes</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition>
          <x-marketing.attribute name="id" type="integer" description="The ID of the life event." />
          <x-marketing.attribute name="object" type="string" description="The object type. Always 'life_event'." />
          <x-marketing.attribute name="description" type="string" description="The description of the life event." />
          <x-marketing.attribute name="happened_at" type="string" description="The date when the life event occurred, in ISO 8601 format." />
          <x-marketing.attribute name="comment" type="string|null" description="Additional comments about the life event." />
          <x-marketing.attribute name="icon" type="string|null" description="The icon associated with the life event." />
          <x-marketing.attribute name="bg_color" type="string|null" description="The background color for the life event." />
          <x-marketing.attribute name="text_color" type="string|null" description="The text color for the life event." />
          <x-marketing.attribute name="should_be_reminded" type="boolean" description="Whether the life event should trigger reminders." />
          <x-marketing.attribute name="person_id" type="integer" description="The ID of the person this life event is attached to." />
          <x-marketing.attribute name="created_at" type="integer" description="The date and time the object was created, in Unix timestamp format." />
          <x-marketing.attribute name="updated_at" type="integer" description="The date and time the object was last updated, in Unix timestamp format." />
        </div>
      </div>
    </div>
    <div>
      <x-marketing.code title="Example" verbClass="text-blue-700">
        <div>{</div>
        @include('marketing.docs.api.partials.life-event-response')
        <div>}</div>
      </x-marketing.code>
    </div>
  </div>

  <!-- GET /api/persons/{person_id}/life-events -->
  <div class="mb-10 grid grid-cols-1 gap-6 border-b border-gray-200 pb-10 sm:grid-cols-2">
    <div>
      <h3 id="get-the-list-of-life-events" class="mb-2 text-lg font-bold">Get the list of life events for a person</h3>
      <p class="mb-10">This endpoint retrieves all life events associated with a specific person, ordered by creation date in descending order.</p>

      <!-- url parameters -->
      <div x-cloak x-data="{ open: false }" class="mb-8">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="mb-2 flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">URL parameters</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition class="mt-2">
          <x-marketing.attribute required name="person_id" type="integer" description="The ID of the person whose life events you want to retrieve." />
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
          <x-marketing.attribute name="data" type="array" description="An array of life event objects." />
        </div>
      </div>
    </div>
    <div>
      <x-marketing.code title="/api/persons/{person_id}/life-events" verb="GET" verbClass="text-blue-700">
        <div>{</div>
        <div class="pl-4">"data": [</div>
        <div class="pl-8">{</div>
        @include('marketing.docs.api.partials.life-event-response')
        <div class="pl-8">}</div>
        <div class="pl-4">]</div>
        <div>}</div>
      </x-marketing.code>
    </div>
  </div>

  <!-- GET /api/persons/{person_id}/life-events/{id} -->
  <div class="mb-10 grid grid-cols-1 gap-6 border-b border-gray-200 pb-10 sm:grid-cols-2">
    <div>
      <h3 id="get-a-specific-life-event" class="mb-2 text-lg font-bold">Get a specific life event</h3>
      <p class="mb-10">This endpoint retrieves a specific life event by its ID.</p>

      <!-- url parameters -->
      <div x-cloak x-data="{ open: false }" class="mb-8">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="mb-2 flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">URL parameters</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition class="mt-2">
          <x-marketing.attribute required name="person_id" type="integer" description="The ID of the person the life event belongs to." />
          <x-marketing.attribute required name="id" type="integer" description="The ID of the life event to retrieve." />
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
          <x-marketing.attribute name="data" type="object" description="The requested life event object." />
        </div>
      </div>
    </div>
    <div>
      <x-marketing.code title="/api/persons/{person_id}/life-events/{id}" verb="GET" verbClass="text-blue-700">
        <div>{</div>
        <div class="pl-4">"data": {</div>
        @include('marketing.docs.api.partials.life-event-response')
        <div class="pl-4">}</div>
        <div>}</div>
      </x-marketing.code>
    </div>
  </div>

  <!-- POST /api/persons/{person_id}/life-events -->
  <div class="mb-10 grid grid-cols-1 gap-6 border-b border-gray-200 pb-10 sm:grid-cols-2">
    <div>
      <h3 id="create-a-new-life-event" class="mb-2 text-lg font-bold">Create a new life event</h3>
      <p class="mb-10">This endpoint creates a new life event for a person. It will return the life event in the response.</p>

      <!-- url parameters -->
      <div x-cloak x-data="{ open: false }" class="mb-8">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="mb-2 flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">URL parameters</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition class="mt-2">
          <x-marketing.attribute required name="person_id" type="integer" description="The ID of the person to add the life event to." />
        </div>
      </div>

      <!-- query parameters -->
      <div x-cloak x-data="{ open: false }" class="mb-8">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="mb-2 flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">Query parameters</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition class="mt-2">
          <x-marketing.attribute required name="description" type="string" description="The description of the life event." />
          <x-marketing.attribute required name="happened_at" type="string" description="The date when the life event occurred, in ISO 8601 format." />
          <x-marketing.attribute name="comment" type="string" description="Additional comments about the life event." />
          <x-marketing.attribute name="icon" type="string" description="The icon associated with the life event." />
          <x-marketing.attribute name="bg_color" type="string" description="The background color for the life event." />
          <x-marketing.attribute name="text_color" type="string" description="The text color for the life event." />
          <x-marketing.attribute name="should_be_reminded" type="boolean" description="Whether the life event should trigger reminders. Defaults to false." />
        </div>
      </div>

      <!-- response attributes -->
      <div x-cloak x-data="{ open: false }">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">Response attributes</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition>
          <x-marketing.attribute name="data" type="object" description="The created life event object." />
        </div>
      </div>
    </div>
    <div>
      <x-marketing.code title="/api/persons/{person_id}/life-events" verb="POST" verbClass="text-green-700">
        <div>{</div>
        <div class="pl-4">"data": {</div>
        @include('marketing.docs.api.partials.life-event-response')
        <div class="pl-4">}</div>
        <div>}</div>
      </x-marketing.code>
    </div>
  </div>

  <!-- PUT /api/persons/{person_id}/life-events/{id} -->
  <div class="mb-10 grid grid-cols-1 gap-6 border-b border-gray-200 pb-10 sm:grid-cols-2">
    <div>
      <h3 id="update-a-life-event" class="mb-2 text-lg font-bold">Update a life event</h3>
      <p class="mb-10">This endpoint updates an existing life event. It will return the updated life event in the response.</p>

      <!-- url parameters -->
      <div x-cloak x-data="{ open: false }" class="mb-8">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="mb-2 flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">URL parameters</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition class="mt-2">
          <x-marketing.attribute required name="person_id" type="integer" description="The ID of the person the life event belongs to." />
          <x-marketing.attribute required name="id" type="integer" description="The ID of the life event to update." />
        </div>
      </div>

      <!-- query parameters -->
      <div x-cloak x-data="{ open: false }" class="mb-8">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="mb-2 flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">Query parameters</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition class="mt-2">
          <x-marketing.attribute required name="description" type="string" description="The description of the life event." />
          <x-marketing.attribute required name="happened_at" type="string" description="The date when the life event occurred, in ISO 8601 format." />
          <x-marketing.attribute name="comment" type="string" description="Additional comments about the life event." />
          <x-marketing.attribute name="icon" type="string" description="The icon associated with the life event." />
          <x-marketing.attribute name="bg_color" type="string" description="The background color for the life event." />
          <x-marketing.attribute name="text_color" type="string" description="The text color for the life event." />
          <x-marketing.attribute name="should_be_reminded" type="boolean" description="Whether the life event should trigger reminders." />
        </div>
      </div>

      <!-- response attributes -->
      <div x-cloak x-data="{ open: false }">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">Response attributes</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition>
          <x-marketing.attribute name="data" type="object" description="The updated life event object." />
        </div>
      </div>
    </div>
    <div>
      <x-marketing.code title="/api/persons/{person_id}/life-events/{id}" verb="PUT" verbClass="text-yellow-700">
        <div>{</div>
        <div class="pl-4">"data": {</div>
        @include('marketing.docs.api.partials.life-event-response')
        <div class="pl-4">}</div>
        <div>}</div>
      </x-marketing.code>
    </div>
  </div>

  <!-- DELETE /api/persons/{person_id}/life-events/{id} -->
  <div class="mb-10 grid grid-cols-1 gap-6 border-b border-gray-200 pb-10 sm:grid-cols-2">
    <div>
      <h3 id="delete-a-life-event" class="mb-2 text-lg font-bold">Delete a life event</h3>
      <p class="mb-10">This endpoint deletes a life event. It will return a 204 No Content response on success.</p>

      <!-- url parameters -->
      <div x-cloak x-data="{ open: false }" class="mb-8">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="mb-2 flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">URL parameters</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition class="mt-2">
          <x-marketing.attribute required name="person_id" type="integer" description="The ID of the person the life event belongs to." />
          <x-marketing.attribute required name="id" type="integer" description="The ID of the life event to delete." />
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

        <div x-show="open" x-transition class="mt-2">
          <p class="text-gray-500">This endpoint returns a 204 No Content response with no body on success.</p>
        </div>
      </div>
    </div>
    <div>
      <x-marketing.code title="/api/persons/{person_id}/life-events/{id}" verb="DELETE" verbClass="text-red-700">
        <div class="text-gray-500">204 No Content</div>
      </x-marketing.code>
    </div>
  </div>

  <div>
    <x-marketing-page-widget :marketing-page="$marketingPage" :view-name="$viewName" />
  </div>
</x-marketing-docs-layout>
