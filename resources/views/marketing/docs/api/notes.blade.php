<?php
/*
 * @var \App\Models\MarketingPage $marketingPage
 * @var string $viewName
 */
?>

{{-- @llms-title: Notes --}}
{{-- @llms-description: Learn how to manage notes --}}
{{-- @llms-route: /docs/api/notes --}}
<x-marketing-docs-layout :marketing-page="$marketingPage" :view-name="$viewName">
  <h1 class="mb-6 text-2xl font-bold">Notes</h1>

  <div class="mb-8 rounded-lg border p-4">
    <p class="mb-2 text-xs">Table of contents</p>

    <ul>
      <li>
        <a href="#note-object" class="text-blue-500 hover:underline">The Note object</a>
      </li>
      <li>
        <a href="#get-the-list-of-notes" class="text-blue-500 hover:underline">Get the list of notes for a person</a>
      </li>
      <li>
        <a href="#get-a-specific-note" class="text-blue-500 hover:underline">Get a specific note</a>
      </li>
      <li>
        <a href="#create-a-new-note" class="text-blue-500 hover:underline">Create a new note</a>
      </li>
      <li>
        <a href="#update-a-note" class="text-blue-500 hover:underline">Update a note</a>
      </li>
      <li>
        <a href="#delete-a-note" class="text-blue-500 hover:underline">Delete a note</a>
      </li>
    </ul>
  </div>

  <div class="mb-10 grid grid-cols-1 gap-6 border-b border-gray-200 pb-10 sm:grid-cols-2">
    <div>
      <p class="mb-2">This endpoint lets you manage notes for contacts in your account.</p>
      <p class="mb-2">Notes allow you to record important information, reminders, or observations about a specific person.</p>
      <p class="mb-10">All notes are associated with a person and include information about who created them.</p>
    </div>
    <div>
      <x-marketing.code title="Endpoints">
        <div class="flex flex-col gap-y-2">
          <a href="#get-the-list-of-notes">
            <span class="text-blue-700">GET</span>
            /api/persons/{person_id}/notes
          </a>
          <a href="#get-a-specific-note">
            <span class="text-blue-700">GET</span>
            /api/persons/{person_id}/notes/{id}
          </a>
          <a href="#create-a-new-note">
            <span class="text-green-700">POST</span>
            /api/persons/{person_id}/notes
          </a>
          <a href="#update-a-note">
            <span class="text-yellow-700">PUT</span>
            /api/persons/{person_id}/notes/{id}
          </a>
          <a href="#delete-a-note">
            <span class="text-red-700">DELETE</span>
            /api/persons/{person_id}/notes/{id}
          </a>
        </div>
      </x-marketing.code>
    </div>
  </div>

  <!-- Note object -->
  <div class="mb-10 grid grid-cols-1 gap-6 border-b border-gray-200 pb-10 sm:grid-cols-2">
    <div>
      <h3 id="note-object" class="mb-2 text-lg font-bold">The Note object</h3>
      <p class="mb-10">This object represents a note attached to a person in your account.</p>

      <!-- response attributes -->
      <div x-cloak x-data="{ open: false }">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">Attributes</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition>
          <x-marketing.attribute name="id" type="integer" description="The ID of the note." />
          <x-marketing.attribute name="object" type="string" description="The object type. Always 'note'." />
          <x-marketing.attribute name="content" type="string" description="The content of the note." />
          <x-marketing.attribute name="person_id" type="integer" description="The ID of the person this note is attached to." />
          <x-marketing.attribute name="author" type="object" description="Information about the user who created the note." />
          <x-marketing.attribute name="created_at" type="integer" description="The date and time the object was created, in Unix timestamp format." />
          <x-marketing.attribute name="updated_at" type="integer" description="The date and time the object was last updated, in Unix timestamp format." />
        </div>
      </div>
    </div>
    <div>
      <x-marketing.code title="Example" verbClass="text-blue-700">
        <div>{</div>
        @include('marketing.docs.api.partials.note-response')
        <div>}</div>
      </x-marketing.code>
    </div>
  </div>

  <!-- GET /api/persons/{person_id}/notes -->
  <div class="mb-10 grid grid-cols-1 gap-6 border-b border-gray-200 pb-10 sm:grid-cols-2">
    <div>
      <h3 id="get-the-list-of-notes" class="mb-2 text-lg font-bold">Get the list of notes for a person</h3>
      <p class="mb-10">This endpoint retrieves all notes associated with a specific person.</p>

      <!-- url parameters -->
      <div x-cloak x-data="{ open: false }" class="mb-8">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="mb-2 flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">URL parameters</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition class="mt-2">
          <x-marketing.attribute required name="person_id" type="integer" description="The ID of the person whose notes you want to retrieve." />
        </div>
      </div>

      <!-- query parameters -->
      <div x-cloak x-data="{ open: false }" class="mb-8">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="mb-2 flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">Query parameters</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition class="mt-2">
          <x-marketing.attribute name="page" type="integer" description="The page number for paginated results." />
          <x-marketing.attribute name="per_page" type="integer" description="The number of items per page for paginated results." />
        </div>
      </div>

      <!-- response attributes -->
      <div x-cloak x-data="{ open: false }">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">Response attributes</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition>
          <x-marketing.attribute name="data" type="array" description="An array of note objects." />
          <x-marketing.attribute name="links" type="object" description="Pagination links." />
          <x-marketing.attribute name="meta" type="object" description="Pagination metadata." />
        </div>
      </div>
    </div>
    <div>
      <x-marketing.code title="/api/persons/{person_id}/notes" verb="GET" verbClass="text-blue-700">
        <div>{</div>
        <div class="pl-4">"data": [</div>
        <div class="pl-8">{</div>
        @include('marketing.docs.api.partials.note-response')
        <div class="pl-8">}</div>
        <div class="pl-4">],</div>
        <div class="pl-4">"links": {</div>
        <div class="pl-8">"first": "http://example.com/api/persons/456/notes?page=1",</div>
        <div class="pl-8">"last": "http://example.com/api/persons/456/notes?page=1",</div>
        <div class="pl-8">"prev": null,</div>
        <div class="pl-8">"next": null</div>
        <div class="pl-4">},</div>
        <div class="pl-4">"meta": {</div>
        <div class="pl-8">"current_page": 1,</div>
        <div class="pl-8">"from": 1,</div>
        <div class="pl-8">"last_page": 1,</div>
        <div class="pl-8">"links": [</div>
        <div class="pl-12">{"url": null, "label": "&laquo; Previous", "active": false},</div>
        <div class="pl-12">{"url": "http://example.com/api/persons/456/notes?page=1", "label": "1", "active": true},</div>
        <div class="pl-12">{"url": null, "label": "Next &raquo;", "active": false}</div>
        <div class="pl-8">],</div>
        <div class="pl-8">"path": "http://example.com/api/persons/456/notes",</div>
        <div class="pl-8">"per_page": 15,</div>
        <div class="pl-8">"to": 1,</div>
        <div class="pl-8">"total": 1</div>
        <div class="pl-4">}</div>
        <div>}</div>
      </x-marketing.code>
    </div>
  </div>

  <!-- GET /api/persons/{person_id}/notes/{id} -->
  <div class="mb-10 grid grid-cols-1 gap-6 border-b border-gray-200 pb-10 sm:grid-cols-2">
    <div>
      <h3 id="get-a-specific-note" class="mb-2 text-lg font-bold">Get a specific note</h3>
      <p class="mb-10">This endpoint retrieves a specific note by its ID.</p>

      <!-- url parameters -->
      <div x-cloak x-data="{ open: false }" class="mb-8">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="mb-2 flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">URL parameters</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition class="mt-2">
          <x-marketing.attribute required name="person_id" type="integer" description="The ID of the person the note belongs to." />
          <x-marketing.attribute required name="id" type="integer" description="The ID of the note to retrieve." />
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
          <x-marketing.attribute name="data" type="object" description="The requested note object." />
        </div>
      </div>
    </div>
    <div>
      <x-marketing.code title="/api/persons/{person_id}/notes/{id}" verb="GET" verbClass="text-blue-700">
        <div>{</div>
        <div class="pl-4">"data": {</div>
        @include('marketing.docs.api.partials.note-response')
        <div class="pl-4">}</div>
        <div>}</div>
      </x-marketing.code>
    </div>
  </div>

  <!-- POST /api/persons/{person_id}/notes -->
  <div class="mb-10 grid grid-cols-1 gap-6 border-b border-gray-200 pb-10 sm:grid-cols-2">
    <div>
      <h3 id="create-a-new-note" class="mb-2 text-lg font-bold">Create a new note</h3>
      <p class="mb-10">This endpoint creates a new note for a person. It will return the note in the response.</p>

      <!-- url parameters -->
      <div x-cloak x-data="{ open: false }" class="mb-8">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="mb-2 flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">URL parameters</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition class="mt-2">
          <x-marketing.attribute required name="person_id" type="integer" description="The ID of the person to add the note to." />
        </div>
      </div>

      <!-- query parameters -->
      <div x-cloak x-data="{ open: false }" class="mb-8">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="mb-2 flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">Query parameters</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition class="mt-2">
          <x-marketing.attribute required name="content" type="string" description="The content of the note. Maximum 255 characters." />
        </div>
      </div>

      <!-- response attributes -->
      <div x-cloak x-data="{ open: false }">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">Response attributes</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition>
          <x-marketing.attribute name="data" type="object" description="The created note object." />
        </div>
      </div>
    </div>
    <div>
      <x-marketing.code title="/api/persons/{person_id}/notes" verb="POST" verbClass="text-green-700">
        <div>{</div>
        <div class="pl-4">"data": {</div>
        @include('marketing.docs.api.partials.note-response')
        <div class="pl-4">}</div>
        <div>}</div>
      </x-marketing.code>
    </div>
  </div>

  <!-- PUT /api/persons/{person_id}/notes/{id} -->
  <div class="mb-10 grid grid-cols-1 gap-6 border-b border-gray-200 pb-10 sm:grid-cols-2">
    <div>
      <h3 id="update-a-note" class="mb-2 text-lg font-bold">Update a note</h3>
      <p class="mb-10">This endpoint updates an existing note. It will return the updated note in the response.</p>

      <!-- url parameters -->
      <div x-cloak x-data="{ open: false }" class="mb-8">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="mb-2 flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">URL parameters</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition class="mt-2">
          <x-marketing.attribute required name="person_id" type="integer" description="The ID of the person the note belongs to." />
          <x-marketing.attribute required name="id" type="integer" description="The ID of the note to update." />
        </div>
      </div>

      <!-- query parameters -->
      <div x-cloak x-data="{ open: false }" class="mb-8">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="mb-2 flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">Query parameters</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition class="mt-2">
          <x-marketing.attribute required name="content" type="string" description="The updated content of the note. Maximum 255 characters." />
        </div>
      </div>

      <!-- response attributes -->
      <div x-cloak x-data="{ open: false }">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">Response attributes</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition>
          <x-marketing.attribute name="data" type="object" description="The updated note object." />
        </div>
      </div>
    </div>
    <div>
      <x-marketing.code title="/api/persons/{person_id}/notes/{id}" verb="PUT" verbClass="text-yellow-700">
        <div>{</div>
        <div class="pl-4">"data": {</div>
        @include('marketing.docs.api.partials.note-response')
        <div class="pl-4">}</div>
        <div>}</div>
      </x-marketing.code>
    </div>
  </div>

  <!-- DELETE /api/persons/{person_id}/notes/{id} -->
  <div class="mb-10 grid grid-cols-1 gap-6 border-b border-gray-200 pb-10 sm:grid-cols-2">
    <div>
      <h3 id="delete-a-note" class="mb-2 text-lg font-bold">Delete a note</h3>
      <p class="mb-10">This endpoint deletes a note. It will return a 204 No Content response on success, or a 404 Not Found if the note doesn't exist or you don't have permission to delete it.</p>

      <!-- url parameters -->
      <div x-cloak x-data="{ open: false }" class="mb-8">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="mb-2 flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">URL parameters</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition class="mt-2">
          <x-marketing.attribute required name="person_id" type="integer" description="The ID of the person the note belongs to." />
          <x-marketing.attribute required name="id" type="integer" description="The ID of the note to delete." />
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
          <p class="text-gray-500">This endpoint returns a 204 No Content response with no body on success, or a 404 Not Found if the note doesn't exist or you don't have permission to delete it.</p>
        </div>
      </div>
    </div>
    <div>
      <x-marketing.code title="/api/persons/{person_id}/notes/{id}" verb="DELETE" verbClass="text-red-700">
        <div class="text-gray-500">204 No Content</div>
      </x-marketing.code>
    </div>
  </div>

  <div>
    <x-marketing-page-widget :marketing-page="$marketingPage" :view-name="$viewName" />
  </div>
</x-marketing-docs-layout>
