<x-marketing-docs-layout>
  <h1 class="mb-6 text-2xl font-bold">Gifts</h1>

  <div class="mb-8 rounded-lg border p-4">
    <p class="mb-2 text-xs">Table of contents</p>

    <ul>
      <li>
        <a href="#get-the-list-of-gifts" class="text-blue-500 hover:underline">Get the list of gifts for a person</a>
      </li>
      <li>
        <a href="#create-a-new-gift" class="text-blue-500 hover:underline">Create a new gift</a>
      </li>
      <li>
        <a href="#get-a-specific-gift" class="text-blue-500 hover:underline">Get a specific gift</a>
      </li>
      <li>
        <a href="#update-a-gift" class="text-blue-500 hover:underline">Update a gift</a>
      </li>
      <li>
        <a href="#delete-a-gift" class="text-blue-500 hover:underline">Delete a gift</a>
      </li>
    </ul>
  </div>

  <div class="mb-10 grid grid-cols-1 gap-6 border-b border-gray-200 pb-10 sm:grid-cols-2">
    <div>
      <p class="mb-2">This endpoint lets you manage gifts for a person.</p>
      <p class="mb-10">Gifts can be used to track gift ideas, gifts you've given, or gifts you've received from a person. You can track the occasion, status, and other details about the gift.</p>
    </div>
    <div>
      <x-marketing.code title="Endpoints">
        <div class="flex flex-col gap-y-2">
          <a href="#get-the-list-of-gifts">
            <span class="text-blue-700">GET</span>
            /api/persons/{person}/gifts
          </a>
          <a href="#create-a-new-gift">
            <span class="text-green-700">POST</span>
            /api/persons/{person}/gifts
          </a>
          <a href="#get-a-specific-gift">
            <span class="text-blue-700">GET</span>
            /api/persons/{person}/gifts/{gift}
          </a>
          <a href="#update-a-gift">
            <span class="text-yellow-700">PUT</span>
            /api/persons/{person}/gifts/{gift}
          </a>
          <a href="#delete-a-gift">
            <span class="text-red-700">DELETE</span>
            /api/persons/{person}/gifts/{gift}
          </a>
        </div>
      </x-marketing.code>
    </div>
  </div>

  <!-- GET /api/persons/{person}/gifts -->
  <div class="mb-10 grid grid-cols-1 gap-6 border-b border-gray-200 pb-10 sm:grid-cols-2">
    <div>
      <h3 id="get-the-list-of-gifts" class="mb-2 text-lg font-bold">Get the list of gifts</h3>
      <p class="mb-2">This endpoint gets the list of gifts for a specific person.</p>
      <p class="mb-10">Gifts are ordered by creation date, with the most recent first.</p>

      <!-- parameters -->
      <div x-cloak x-data="{ open: false }" class="mb-10">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="mb-2 flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">Parameters</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition class="mt-2">
          <x-marketing.attribute required name="person" type="integer" description="The ID of the person." />
        </div>
      </div>

      <!-- response attributes -->
      <div x-cloak x-data="{ open: false }">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">Response attributes</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition>
          <x-marketing.attribute name="id" type="integer" description="The ID of the gift." />
          <x-marketing.attribute name="object" type="string" description="The object type. Always 'gift'." />
          <x-marketing.attribute name="name" type="string" description="The name of the gift." />
          <x-marketing.attribute name="occasion" type="string" description="The occasion for the gift." />
          <x-marketing.attribute name="url" type="string" description="The URL associated with the gift." />
          <x-marketing.attribute name="status" type="string" description="The status of the gift. Possible values: idea, given, offered." />
          <x-marketing.attribute name="gifted_at" type="integer" description="The date the gift was given, in Unix timestamp format." />
          <x-marketing.attribute name="created_at" type="integer" description="The date and time the object was created, in Unix timestamp format." />
          <x-marketing.attribute name="updated_at" type="integer" description="The date and time the object was last updated, in Unix timestamp format." />
        </div>
      </div>
    </div>
    <div>
      <x-marketing.code title="/api/persons/{person}/gifts" verb="GET" verbClass="text-blue-700">
        <div>{</div>
        <div class="pl-4">"data": [</div>
        <div class="pl-8">{</div>
        <div class="pl-12">
          "id":
          <span class="text-rose-800">1</span>
          ,
        </div>
        <div class="pl-12">
          "object":
          <span class="text-lime-700">"gift"</span>
          ,
        </div>
        <div class="pl-12">
          "name":
          <span class="text-lime-700">"Birthday present"</span>
          ,
        </div>
        <div class="pl-12">
          "occasion":
          <span class="text-lime-700">"Birthday"</span>
          ,
        </div>
        <div class="pl-12">
          "url":
          <span class="text-lime-700">"https://example.com/gift"</span>
          ,
        </div>
        <div class="pl-12">
          "status":
          <span class="text-lime-700">"idea"</span>
          ,
        </div>
        <div class="pl-12">
          "gifted_at":
          <span class="text-rose-800">1715145600</span>
          ,
        </div>
        <div class="pl-12">
          "created_at":
          <span class="text-rose-800">1715145600</span>
          ,
        </div>
        <div class="pl-12">
          "updated_at":
          <span class="text-rose-800">1715145600</span>
        </div>
        <div class="pl-8">}</div>
        <div class="pl-4">]</div>
        <div>}</div>
      </x-marketing.code>
    </div>
  </div>

  <!-- POST /api/persons/{person}/gifts -->
  <div class="mb-10 grid grid-cols-1 gap-6 border-b border-gray-200 pb-10 sm:grid-cols-2">
    <div>
      <h3 id="create-a-new-gift" class="mb-2 text-lg font-bold">Create a new gift</h3>
      <p class="mb-10">This endpoint creates a new gift for a specific person. It will return the gift in the response.</p>

      <!-- parameters -->
      <div x-cloak x-data="{ open: false }" class="mb-10">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="mb-2 flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">Parameters</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition class="mt-2">
          <x-marketing.attribute required name="person" type="integer" description="The ID of the person." />
          <x-marketing.attribute required name="name" type="string" description="The name of the gift. Maximum 255 characters." />
          <x-marketing.attribute name="occasion" type="string" description="The occasion for the gift." />
          <x-marketing.attribute name="url" type="string" description="The URL associated with the gift. Maximum 255 characters." />
          <x-marketing.attribute required name="status" type="string" description="The status of the gift. Possible values: idea, given, offered." />
          <x-marketing.attribute name="date" type="date" description="The date the gift was given. Format: YYYY-MM-DD." />
        </div>
      </div>

      <!-- response attributes -->
      <div x-cloak x-data="{ open: false }">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">Response attributes</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition>
          <x-marketing.attribute name="id" type="integer" description="The ID of the gift." />
          <x-marketing.attribute name="object" type="string" description="The object type. Always 'gift'." />
          <x-marketing.attribute name="name" type="string" description="The name of the gift." />
          <x-marketing.attribute name="occasion" type="string" description="The occasion for the gift." />
          <x-marketing.attribute name="url" type="string" description="The URL associated with the gift." />
          <x-marketing.attribute name="status" type="string" description="The status of the gift. Possible values: idea, given, offered." />
          <x-marketing.attribute name="gifted_at" type="integer" description="The date the gift was given, in Unix timestamp format." />
          <x-marketing.attribute name="created_at" type="integer" description="The date and time the object was created, in Unix timestamp format." />
          <x-marketing.attribute name="updated_at" type="integer" description="The date and time the object was last updated, in Unix timestamp format." />
        </div>
      </div>
    </div>
    <div>
      <x-marketing.code title="/api/persons/{person}/gifts" verb="POST" verbClass="text-green-700">
        <div>{</div>
        <div class="pl-4">
          "id":
          <span class="text-rose-800">1</span>
          ,
        </div>
        <div class="pl-4">
          "object":
          <span class="text-lime-700">"gift"</span>
          ,
        </div>
        <div class="pl-4">
          "name":
          <span class="text-lime-700">"Birthday present"</span>
          ,
        </div>
        <div class="pl-4">
          "occasion":
          <span class="text-lime-700">"Birthday"</span>
          ,
        </div>
        <div class="pl-4">
          "url":
          <span class="text-lime-700">"https://example.com/gift"</span>
          ,
        </div>
        <div class="pl-4">
          "status":
          <span class="text-lime-700">"idea"</span>
          ,
        </div>
        <div class="pl-4">
          "gifted_at":
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
        </div>
        <div>}</div>
      </x-marketing.code>
    </div>
  </div>

  <!-- GET /api/persons/{person}/gifts/{gift} -->
  <div class="mb-10 grid grid-cols-1 gap-6 border-b border-gray-200 pb-10 sm:grid-cols-2">
    <div>
      <h3 id="get-a-specific-gift" class="mb-2 text-lg font-bold">Get a specific gift</h3>
      <p class="mb-10">This endpoint retrieves a specific gift for a person.</p>

      <!-- parameters -->
      <div x-cloak x-data="{ open: false }" class="mb-10">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="mb-2 flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">Parameters</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition class="mt-2">
          <x-marketing.attribute required name="person" type="integer" description="The ID of the person." />
          <x-marketing.attribute required name="gift" type="integer" description="The ID of the gift." />
        </div>
      </div>

      <!-- response attributes -->
      <div x-cloak x-data="{ open: false }">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">Response attributes</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition>
          <x-marketing.attribute name="id" type="integer" description="The ID of the gift." />
          <x-marketing.attribute name="object" type="string" description="The object type. Always 'gift'." />
          <x-marketing.attribute name="name" type="string" description="The name of the gift." />
          <x-marketing.attribute name="occasion" type="string" description="The occasion for the gift." />
          <x-marketing.attribute name="url" type="string" description="The URL associated with the gift." />
          <x-marketing.attribute name="status" type="string" description="The status of the gift. Possible values: idea, given, offered." />
          <x-marketing.attribute name="gifted_at" type="integer" description="The date the gift was given, in Unix timestamp format." />
          <x-marketing.attribute name="created_at" type="integer" description="The date and time the object was created, in Unix timestamp format." />
          <x-marketing.attribute name="updated_at" type="integer" description="The date and time the object was last updated, in Unix timestamp format." />
        </div>
      </div>
    </div>
    <div>
      <x-marketing.code title="/api/persons/{person}/gifts/{gift}" verb="GET" verbClass="text-blue-700">
        <div>{</div>
        <div class="pl-4">
          "id":
          <span class="text-rose-800">1</span>
          ,
        </div>
        <div class="pl-4">
          "object":
          <span class="text-lime-700">"gift"</span>
          ,
        </div>
        <div class="pl-4">
          "name":
          <span class="text-lime-700">"Birthday present"</span>
          ,
        </div>
        <div class="pl-4">
          "occasion":
          <span class="text-lime-700">"Birthday"</span>
          ,
        </div>
        <div class="pl-4">
          "url":
          <span class="text-lime-700">"https://example.com/gift"</span>
          ,
        </div>
        <div class="pl-4">
          "status":
          <span class="text-lime-700">"idea"</span>
          ,
        </div>
        <div class="pl-4">
          "gifted_at":
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
        </div>
        <div>}</div>
      </x-marketing.code>
    </div>
  </div>

  <!-- PUT /api/persons/{person}/gifts/{gift} -->
  <div class="mb-10 grid grid-cols-1 gap-6 border-b border-gray-200 pb-10 sm:grid-cols-2">
    <div>
      <h3 id="update-a-gift" class="mb-2 text-lg font-bold">Update a gift</h3>
      <p class="mb-10">This endpoint updates a specific gift for a person. It will return the updated gift in the response.</p>

      <!-- parameters -->
      <div x-cloak x-data="{ open: false }" class="mb-10">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="mb-2 flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">Parameters</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition class="mt-2">
          <x-marketing.attribute required name="person" type="integer" description="The ID of the person." />
          <x-marketing.attribute required name="gift" type="integer" description="The ID of the gift." />
          <x-marketing.attribute required name="name" type="string" description="The name of the gift. Maximum 255 characters." />
          <x-marketing.attribute name="occasion" type="string" description="The occasion for the gift." />
          <x-marketing.attribute name="url" type="string" description="The URL associated with the gift. Maximum 255 characters." />
          <x-marketing.attribute required name="status" type="string" description="The status of the gift. Possible values: idea, given, offered." />
          <x-marketing.attribute name="date" type="date" description="The date the gift was given. Format: YYYY-MM-DD." />
        </div>
      </div>

      <!-- response attributes -->
      <div x-cloak x-data="{ open: false }">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">Response attributes</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition>
          <x-marketing.attribute name="id" type="integer" description="The ID of the gift." />
          <x-marketing.attribute name="object" type="string" description="The object type. Always 'gift'." />
          <x-marketing.attribute name="name" type="string" description="The name of the gift." />
          <x-marketing.attribute name="occasion" type="string" description="The occasion for the gift." />
          <x-marketing.attribute name="url" type="string" description="The URL associated with the gift." />
          <x-marketing.attribute name="status" type="string" description="The status of the gift. Possible values: idea, given, offered." />
          <x-marketing.attribute name="gifted_at" type="integer" description="The date the gift was given, in Unix timestamp format." />
          <x-marketing.attribute name="created_at" type="integer" description="The date and time the object was created, in Unix timestamp format." />
          <x-marketing.attribute name="updated_at" type="integer" description="The date and time the object was last updated, in Unix timestamp format." />
        </div>
      </div>
    </div>
    <div>
      <x-marketing.code title="/api/persons/{person}/gifts/{gift}" verb="PUT" verbClass="text-yellow-700">
        <div>{</div>
        <div class="pl-4">
          "id":
          <span class="text-rose-800">1</span>
          ,
        </div>
        <div class="pl-4">
          "object":
          <span class="text-lime-700">"gift"</span>
          ,
        </div>
        <div class="pl-4">
          "name":
          <span class="text-lime-700">"Updated gift name"</span>
          ,
        </div>
        <div class="pl-4">
          "occasion":
          <span class="text-lime-700">"Christmas"</span>
          ,
        </div>
        <div class="pl-4">
          "url":
          <span class="text-lime-700">"https://example.com/updated-gift"</span>
          ,
        </div>
        <div class="pl-4">
          "status":
          <span class="text-lime-700">"given"</span>
          ,
        </div>
        <div class="pl-4">
          "gifted_at":
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
          <span class="text-rose-800">1715145700</span>
        </div>
        <div>}</div>
      </x-marketing.code>
    </div>
  </div>

  <!-- DELETE /api/persons/{person}/gifts/{gift} -->
  <div class="mb-10 grid grid-cols-1 gap-6 border-b border-gray-200 pb-10 sm:grid-cols-2">
    <div>
      <h3 id="delete-a-gift" class="mb-2 text-lg font-bold">Delete a gift</h3>
      <p class="mb-10">This endpoint deletes a specific gift for a person. It will return a 204 No Content response on success.</p>

      <!-- parameters -->
      <div x-cloak x-data="{ open: false }" class="mb-10">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="mb-2 flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">Parameters</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition class="mt-2">
          <x-marketing.attribute required name="person" type="integer" description="The ID of the person." />
          <x-marketing.attribute required name="gift" type="integer" description="The ID of the gift." />
        </div>
      </div>

      <!-- response attributes -->
      <div x-cloak x-data="{ open: false }">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">Response</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition>
          <p class="text-gray-500">This endpoint returns a 204 No Content response with no body on success.</p>
        </div>
      </div>
    </div>
    <div>
      <x-marketing.code title="/api/persons/{person}/gifts/{gift}" verb="DELETE" verbClass="text-red-700">
        <div class="text-gray-500">// Returns 204 No Content</div>
      </x-marketing.code>
    </div>
  </div>

  <div>
    <x-marketing.edit-github />
  </div>
</x-marketing-docs-layout>
