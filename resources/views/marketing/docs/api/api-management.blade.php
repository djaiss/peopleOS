<?php
/*
 * @var string $pageviews
 */
?>

<x-marketing-docs-layout :pageviews="$pageviews">
  <h1 class="mb-6 text-2xl font-bold">API management</h1>

  <div class="mb-8 rounded-lg border p-4">
    <p class="mb-2 text-xs">Table of contents</p>

    <ul>
      <li>
        <a href="#get-the-list-of-api-keys-in-the-account" class="text-blue-500 hover:underline">Get the list of API keys in the account</a>
      </li>
      <li>
        <a href="#create-a-new-api-key" class="text-blue-500 hover:underline">Create a new API key</a>
      </li>
      <li>
        <a href="#delete-an-api-key" class="text-blue-500 hover:underline">Delete an API key</a>
      </li>
    </ul>
  </div>

  <div class="mb-10 grid grid-cols-1 gap-6 border-b border-gray-200 pb-10 sm:grid-cols-2">
    <div>
      <p class="mb-2">This endpoint lets you manage the API keys in your account.</p>
      <p class="mb-10">API keys are used to authenticate requests to the API. They are used to identify the user and the application that is making the request. You need to be very careful with them, since they can be used to access sensitive data.</p>
    </div>
    <div>
      <x-marketing.code title="Endpoints">
        <div class="flex flex-col gap-y-2">
          <a href="#get-the-list-of-api-keys-in-the-account">
            <span class="text-blue-700">GET</span>
            /api/administration/api
          </a>
          <a href="#create-a-new-api-key">
            <span class="text-green-700">POST</span>
            /api/administration/api
          </a>
          <a href="#delete-an-api-key">
            <span class="text-red-700">DELETE</span>
            /api/administration/api/{id}
          </a>
        </div>
      </x-marketing.code>
    </div>
  </div>

  <!-- GET /api/administration/api -->
  <div class="mb-10 grid grid-cols-1 gap-6 border-b border-gray-200 pb-10 sm:grid-cols-2">
    <div>
      <h3 id="get-the-list-of-api-keys-in-the-account" class="mb-2 text-lg font-bold">Get the list of API keys in the account</h3>
      <p class="mb-2">This endpoint gets the list of API keys in the account.</p>
      <p class="mb-10">This call is not paginated, since there should not be too many API keys in the account.</p>

      <!-- parameters -->
      <div x-cloak x-data="{ open: false }" class="mb-10">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="mb-2 flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">Parameters</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition class="mt-2">
          <p class="text-gray-500">This endpoint does not have any parameters.</p>
        </div>
      </div>

      <!-- response attributes -->
      <div x-cloak x-data="{ open: false }">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">Response attributes</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition>
          <x-marketing.attribute name="id" type="integer" description="The ID of the API key." />
          <x-marketing.attribute name="object" type="string" description="The object type. Always 'api_key'." />
          <x-marketing.attribute name="name" type="string" description="The name of the API key." />
          <x-marketing.attribute name="last_used_at" type="string" description="The date and time the API key was last used, in Unix timestamp format." />
          <x-marketing.attribute name="created_at" type="integer" description="The date and time the object was created, in Unix timestamp format." />
          <x-marketing.attribute name="updated_at" type="integer" description="The date and time the object was last updated, in Unix timestamp format." />
        </div>
      </div>
    </div>
    <div>
      <x-marketing.code title="/api/administration/api" verb="GET" verbClass="text-blue-700">
        <div>{</div>
        <div class="pl-4">
          "id":
          <span class="text-rose-800">4</span>
          ,
        </div>
        <div class="pl-4">
          "object":
          <span class="text-lime-700">"api_key"</span>
          ,
        </div>
        <div class="pl-4">
          "name":
          <span class="text-lime-700">"Production API key"</span>
          ,
        </div>
        <div class="pl-4">
          "last_used_at":
          <span class="text-rose-800">1715145600</span>
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

  <!-- POST /api/administration/api -->
  <div class="mb-10 grid grid-cols-1 gap-6 border-b border-gray-200 pb-10 sm:grid-cols-2">
    <div>
      <h3 id="create-a-new-api-key" class="mb-2 text-lg font-bold">Create a new API key</h3>
      <p class="mb-10">This endpoint creates a new API key. It will return the API key in the response. This will be the only time you will see the API key, so please save it in a secure location.</p>

      <!-- parameters -->
      <div x-cloak x-data="{ open: false }" class="mb-10">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="mb-2 flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">Parameters</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition class="mt-2">
          <x-marketing.attribute required name="label" type="string" description="The name of the API key. Maximum 255 characters." />
        </div>
      </div>

      <!-- response attributes -->
      <div x-cloak x-data="{ open: false }">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">Response attributes</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition>
          <x-marketing.attribute name="id" type="integer" description="The ID of the API key." />
          <x-marketing.attribute name="object" type="string" description="The object type. Always 'api_key'." />
          <x-marketing.attribute name="token" type="string" description="The API key." />
          <x-marketing.attribute name="name" type="string" description="The name of the API key." />
          <x-marketing.attribute name="last_used_at" type="string" description="The date and time the API key was last used, in Unix timestamp format." />
          <x-marketing.attribute name="created_at" type="integer" description="The date and time the object was created, in Unix timestamp format." />
          <x-marketing.attribute name="updated_at" type="integer" description="The date and time the object was last updated, in Unix timestamp format." />
        </div>
      </div>
    </div>
    <div>
      <x-marketing.code title="/api/administration/api" verb="POST" verbClass="text-green-700">
        <div>{</div>
        <div class="pl-4">
          "id":
          <span class="text-rose-800">4</span>
          ,
        </div>
        <div class="pl-4">
          "object":
          <span class="text-lime-700">"api_key"</span>
          ,
        </div>
        <div class="pl-4">
          "token":
          <span class="text-lime-700">"1234567890"</span>
          ,
        </div>
        <div class="pl-4">
          "name":
          <span class="text-lime-700">"Production API key"</span>
          ,
        </div>
        <div class="pl-4">
          "last_used_at":
          <span class="text-rose-800">1715145600</span>
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

  <!-- DELETE /api/administration/api/{id} -->
  <div class="mb-10 grid grid-cols-1 gap-6 border-b border-gray-200 pb-10 sm:grid-cols-2">
    <div>
      <h3 id="delete-an-api-key" class="mb-2 text-lg font-bold">Delete an API key</h3>
      <p class="mb-10">This endpoint deletes an API key. It will return a success message in the response.</p>

      <!-- parameters -->
      <div x-cloak x-data="{ open: false }" class="mb-10">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="mb-2 flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">Parameters</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition class="mt-2">
          <x-marketing.attribute required name="id" type="integer" description="The ID of the API key." />
        </div>
      </div>

      <!-- response attributes -->
      <div x-cloak x-data="{ open: false }">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">Response attributes</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition>
          <x-marketing.attribute name="message" type="string" description="The success message." />
        </div>
      </div>
    </div>
    <div>
      <x-marketing.code title="/api/administration/api" verb="DELETE" verbClass="text-red-700">
        <div>{</div>
        <div class="pl-4">
          "message":
          <span class="text-rose-800">"API key deleted"</span>
          ,
        </div>
        <div>}</div>
      </x-marketing.code>
    </div>
  </div>

  <div>
    <x-marketing.edit-github />
  </div>
</x-marketing-docs-layout>
