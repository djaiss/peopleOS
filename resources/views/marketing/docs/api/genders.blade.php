<?php
/*
 * @var string $pageviews
 */
?>

<x-marketing-docs-layout :pageviews="$pageviews">
  <h1 class="mb-6 text-2xl font-bold">Genders</h1>

  <div class="mb-8 rounded-lg border p-4">
    <p class="mb-2 text-xs">Table of contents</p>

    <ul>
      <li>
        <a href="#get-the-list-of-genders" class="text-blue-500 hover:underline">Get the list of genders in the account</a>
      </li>
      <li>
        <a href="#create-a-new-gender" class="text-blue-500 hover:underline">Create a new gender</a>
      </li>
      <li>
        <a href="#update-a-gender" class="text-blue-500 hover:underline">Update a gender</a>
      </li>
      <li>
        <a href="#delete-a-gender" class="text-blue-500 hover:underline">Delete a gender</a>
      </li>
    </ul>
  </div>

  <div class="mb-10 grid grid-cols-1 gap-6 border-b border-gray-200 pb-10 sm:grid-cols-2">
    <div>
      <p class="mb-2">This endpoint lets you manage the genders in your account.</p>
      <p class="mb-10">Genders are used to identify the gender of a person. You can define as many genders as you want. An account comes with a default set of genders, but feel free to add more to your liking.</p>
    </div>
    <div>
      <x-marketing.code title="Endpoints">
        <div class="flex flex-col gap-y-2">
          <a href="#get-the-list-of-genders">
            <span class="text-blue-700">GET</span>
            /api/administration/genders
          </a>
          <a href="#create-a-new-gender">
            <span class="text-green-700">POST</span>
            /api/administration/genders
          </a>
          <a href="#update-a-gender">
            <span class="text-yellow-700">PUT</span>
            /api/administration/genders/{id}
          </a>
          <a href="#delete-a-gender">
            <span class="text-red-700">DELETE</span>
            /api/administration/genders/{id}
          </a>
        </div>
      </x-marketing.code>
    </div>
  </div>

  <!-- GET /api/administration/genders -->
  <div class="mb-10 grid grid-cols-1 gap-6 border-b border-gray-200 pb-10 sm:grid-cols-2">
    <div>
      <h3 id="get-the-list-of-genders" class="mb-2 text-lg font-bold">Get the list of genders</h3>
      <p class="mb-2">This endpoint gets the list of genders in the account.</p>
      <p class="mb-2">Genders are ordered by position.</p>
      <p class="mb-10">This call is not paginated, since there should not be too many genders in the account.</p>

      <!-- url parameters -->
      <div x-cloak x-data="{ open: false }" class="mb-8">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="mb-2 flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">URL parameters</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition class="mt-2">
          <p class="text-gray-500">No URL parameters are required for this endpoint.</p>
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
          <x-marketing.attribute name="id" type="integer" description="The ID of the gender." />
          <x-marketing.attribute name="object" type="string" description="The object type. Always 'gender'." />
          <x-marketing.attribute name="name" type="string" description="The name of the gender." />
          <x-marketing.attribute name="position" type="integer" description="The position of the gender." />
          <x-marketing.attribute name="created_at" type="integer" description="The date and time the object was created, in Unix timestamp format." />
          <x-marketing.attribute name="updated_at" type="integer" description="The date and time the object was last updated, in Unix timestamp format." />
        </div>
      </div>
    </div>
    <div>
      <x-marketing.code title="/api/administration/genders" verb="GET" verbClass="text-blue-700">
        <div>{</div>
        <div class="pl-4">"data": [</div>
        <div class="pl-8">{</div>
        @include('marketing.docs.api.partials.gender-response')
        <div class="pl-8">}</div>
        <div class="pl-4">]</div>
        <div>}</div>
      </x-marketing.code>
    </div>
  </div>

  <!-- POST /api/administration/genders -->
  <div class="mb-10 grid grid-cols-1 gap-6 border-b border-gray-200 pb-10 sm:grid-cols-2">
    <div>
      <h3 id="create-a-new-gender" class="mb-2 text-lg font-bold">Create a new gender</h3>
      <p class="mb-10">This endpoint creates a new gender. It will return the gender in the response.</p>

      <!-- url parameters -->
      <div x-cloak x-data="{ open: false }" class="mb-8">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="mb-2 flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">URL parameters</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition class="mt-2">
          <p class="text-gray-500">No URL parameters are required for this endpoint.</p>
        </div>
      </div>

      <!-- query parameters -->
      <div x-cloak x-data="{ open: false }" class="mb-8">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="mb-2 flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">Query parameters</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition class="mt-2">
          <x-marketing.attribute required name="name" type="string" description="The name of the gender. Maximum 255 characters." />
        </div>
      </div>

      <!-- response attributes -->
      <div x-cloak x-data="{ open: false }">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">Response attributes</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition>
          <x-marketing.attribute name="id" type="integer" description="The ID of the gender." />
          <x-marketing.attribute name="object" type="string" description="The object type. Always 'gender'." />
          <x-marketing.attribute name="name" type="string" description="The name of the gender." />
          <x-marketing.attribute name="position" type="integer" description="The position of the gender." />
          <x-marketing.attribute name="created_at" type="integer" description="The date and time the object was created, in Unix timestamp format." />
          <x-marketing.attribute name="updated_at" type="integer" description="The date and time the object was last updated, in Unix timestamp format." />
        </div>
      </div>
    </div>
    <div>
      <x-marketing.code title="/api/administration/genders" verb="POST" verbClass="text-green-700">
        <div>{</div>
        <div class="pl-4">"data": {</div>
        @include('marketing.docs.api.partials.gender-response')
        <div class="pl-4">}</div>
        <div>}</div>
      </x-marketing.code>
    </div>
  </div>

  <!-- PUT /api/administration/genders/{id} -->
  <div class="mb-10 grid grid-cols-1 gap-6 border-b border-gray-200 pb-10 sm:grid-cols-2">
    <div>
      <h3 id="update-a-gender" class="mb-2 text-lg font-bold">Update a gender</h3>
      <p class="mb-10">This endpoint updates a gender. It will return the gender in the response.</p>

      <!-- url parameters -->
      <div x-cloak x-data="{ open: false }" class="mb-8">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="mb-2 flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">URL parameters</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition class="mt-2">
          <x-marketing.attribute required name="id" type="integer" description="The ID of the gender to update." />
        </div>
      </div>

      <!-- query parameters -->
      <div x-cloak x-data="{ open: false }" class="mb-8">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="mb-2 flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">Query parameters</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition class="mt-2">
          <x-marketing.attribute required name="name" type="string" description="The name of the gender. Maximum 255 characters." />
          <x-marketing.attribute required name="position" type="integer" description="The position of the gender." />
        </div>
      </div>

      <!-- response attributes -->
      <div x-cloak x-data="{ open: false }">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">Response attributes</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition>
          <x-marketing.attribute name="id" type="integer" description="The ID of the gender." />
          <x-marketing.attribute name="object" type="string" description="The object type. Always 'gender'." />
          <x-marketing.attribute name="name" type="string" description="The name of the gender." />
          <x-marketing.attribute name="position" type="integer" description="The position of the gender." />
          <x-marketing.attribute name="created_at" type="integer" description="The date and time the object was created, in Unix timestamp format." />
          <x-marketing.attribute name="updated_at" type="integer" description="The date and time the object was last updated, in Unix timestamp format." />
        </div>
      </div>
    </div>
    <div>
      <x-marketing.code title="/api/administration/genders/{id}" verb="PUT" verbClass="text-yellow-700">
        <div>{</div>
        <div class="pl-4">"data": {</div>
        @include('marketing.docs.api.partials.gender-response')
        <div class="pl-4">}</div>
        <div>}</div>
      </x-marketing.code>
    </div>
  </div>

  <!-- DELETE /api/administration/api/{id} -->
  <div class="mb-10 grid grid-cols-1 gap-6 border-b border-gray-200 pb-10 sm:grid-cols-2">
    <div>
      <h3 id="delete-a-gender" class="mb-2 text-lg font-bold">Delete a gender</h3>
      <p class="mb-10">This endpoint deletes a gender. It will return a 204 No Content response.</p>

      <!-- url parameters -->
      <div x-cloak x-data="{ open: false }" class="mb-8">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="mb-2 flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">URL parameters</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition class="mt-2">
          <x-marketing.attribute required name="id" type="integer" description="The ID of the gender to delete." />
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
          <p class="text-gray-500">This endpoint returns a 204 No Content response with no body.</p>
        </div>
      </div>
    </div>
    <div>
      <x-marketing.code title="/api/administration/genders/{id}" verb="DELETE" verbClass="text-red-700">
        <div class="text-gray-500">204 No Content</div>
      </x-marketing.code>
    </div>
  </div>

  <div>
    <x-marketing.edit-github />
  </div>
</x-marketing-docs-layout>
