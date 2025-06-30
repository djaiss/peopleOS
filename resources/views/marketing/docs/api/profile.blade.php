<?php
/*
 * @var \App\Models\MarketingPage $marketingPage
 * @var string $viewName
 */
?>

<x-marketing-docs-layout :marketing-page="$marketingPage" :view-name="$viewName">
  <h1 class="mb-6 text-2xl font-bold">Profile</h1>

  <div class="mb-8 rounded-lg border p-4">
    <p class="mb-2 text-xs">Table of contents</p>

    <ul>
      <li>
        <a href="#get-the-information-about-the-logged-user" class="text-blue-500 hover:underline">Get the information about the logged user</a>
      </li>
      <li>
        <a href="#update-the-information-about-the-logged-user" class="text-blue-500 hover:underline">Update the information about the logged user</a>
      </li>
      <li>
        <a href="#get-the-timezone-of-the-logged-user" class="text-blue-500 hover:underline">Get the timezone of the logged user</a>
      </li>
      <li>
        <a href="#update-the-timezone-of-the-logged-user" class="text-blue-500 hover:underline">Update the timezone of the logged user</a>
      </li>
    </ul>
  </div>

  <div class="mb-10 grid grid-cols-1 gap-6 border-b border-gray-200 pb-10 sm:grid-cols-2">
    <div>
      <p class="mb-2">The profile endpoint is used to get and set the current user's profile information.</p>
      <p class="mb-2">This will probably not be used often, but it can be useful.</p>
    </div>
    <div>
      <x-marketing.code title="Endpoints">
        <div class="flex flex-col gap-y-2">
          <a href="#get-the-information-about-the-logged-user">
            <span class="text-blue-700">GET</span>
            /api/me
          </a>
          <a href="#update-the-information-about-the-logged-user">
            <span class="text-orange-500">PUT</span>
            /api/me
          </a>
          <a href="#get-the-timezone-of-the-logged-user">
            <span class="text-blue-700">GET</span>
            /api/me/timezone
          </a>
          <a href="#update-the-timezone-of-the-logged-user">
            <span class="text-orange-500">PUT</span>
            /api/me/timezone
          </a>
        </div>
      </x-marketing.code>
    </div>
  </div>

  <!-- GET /api/me -->
  <div class="mb-10 grid grid-cols-1 gap-6 border-b border-gray-200 pb-10 sm:grid-cols-2">
    <div>
      <h3 id="get-the-information-about-the-logged-user" class="mb-2 text-lg font-bold">Get the information about the logged user</h3>
      <p class="mb-10">This endpoint gets the information about the logged user. This endpoint is there to make sure that the API works.</p>

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
          <x-marketing.attribute name="id" type="integer" description="The ID of the user." />
          <x-marketing.attribute name="first_name" type="string" description="The first name of the user." />
          <x-marketing.attribute name="last_name" type="string" description="The last name of the user." />
          <x-marketing.attribute name="nickname" type="string" description="The nickname of the user." />
          <x-marketing.attribute name="email" type="string" description="The email of the user." />
          <x-marketing.attribute name="born_at" type="integer" description="The birth date of the user, in Unix timestamp format." />
        </div>
      </div>
    </div>
    <div>

    </div>
  </div>

  <!-- PUT /api/me -->
  <div class="mb-10 grid grid-cols-1 gap-6 border-b border-gray-200 pb-10 sm:grid-cols-2">
    <div>
      <h3 id="update-the-information-about-the-logged-user" class="mb-2 text-lg font-bold">Update the information about the logged user</h3>
      <p class="mb-2">This endpoint updates the information about the logged user.</p>
      <p class="mb-2">Only the logged user can update these fields.</p>
      <p class="mb-2">If the email is changed, the system will send a new verification email to verify the new email address, and unless the user verifies the new email address, he/she will not be able to access the account.</p>
      <p class="mb-10">Please note that your password can not be changed through the API at the moment.</p>

      <!-- parameters -->
      <div x-cloak x-data="{ open: false }" class="mb-10">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="mb-2 flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">Parameters</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition>
          <x-marketing.attribute name="first_name" required="true" type="string" description="The first name of the user. Max 255 characters." />
          <x-marketing.attribute name="last_name" required="true" type="string" description="The last name of the user. Max 255 characters." />
          <x-marketing.attribute name="nickname" type="string" description="The nickname of the user. Max 255 characters." />
          <x-marketing.attribute name="email" required="true" type="string" description="The email of the user. This email should be unique in the instance, and we will validate the email format. Max 255 characters." />
          <x-marketing.attribute name="born_at" type="string" description="The birth date of the user. Format: YYYY-MM-DD. Example: 1985-03-15" />
        </div>
      </div>

      <!-- response attributes -->
      <div x-cloak x-data="{ open: false }">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">Response attributes</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition>
          <x-marketing.attribute name="id" type="integer" description="The ID of the user." />
          <x-marketing.attribute name="first_name" type="string" description="The first name of the user." />
          <x-marketing.attribute name="last_name" type="string" description="The last name of the user." />
          <x-marketing.attribute name="nickname" type="string" description="The nickname of the user." />
          <x-marketing.attribute name="email" type="string" description="The email of the user." />
          <x-marketing.attribute name="born_at" type="integer" description="The birth date of the user, in Unix timestamp format." />
        </div>
      </div>
    </div>
    <div>
      <x-marketing.code title="/api/me" verb="PUT" verbClass="text-orange-500">
        <div>{</div>
        <div class="pl-4">
          "id":
          <span class="text-rose-800">4</span>
          ,
        </div>
        <div class="pl-4">
          "first_name":
          <span class="text-lime-700">"Ross"</span>
          ,
        </div>
        <div class="pl-4">
          "last_name":
          <span class="text-lime-700">"Geller"</span>
          ,
        </div>
        <div class="pl-4">
          "nickname":
          <span class="text-lime-700">"Ross"</span>
          ,
        </div>
        <div class="pl-4">
          "email":
          <span class="text-lime-700">"ross.geller@friends.com"</span>
          ,
        </div>
        <div class="pl-4">
          "born_at":
          <span class="text-rose-800">479692800</span>
        </div>
        <div>}</div>
      </x-marketing.code>
    </div>
  </div>

  <!-- GET /api/me/timezone -->
  <div class="mb-10 grid grid-cols-1 gap-6 border-b border-gray-200 pb-10 sm:grid-cols-2">
    <div>
      <h3 id="get-the-timezone-of-the-logged-user" class="mb-2 text-lg font-bold">Get the timezone of the logged user</h3>
      <p class="mb-10">This endpoint retrieves the timezone information of the currently logged in user.</p>

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
          <x-marketing.attribute name="timezone" type="string" description="The timezone of the user in IANA format." />
        </div>
      </div>
    </div>
    <div>
      <x-marketing.code title="/api/me/timezone" verb="GET" verbClass="text-blue-700">
        <div>{</div>
        <div class="pl-4">
          "timezone":
          <span class="text-lime-700">"America/New_York"</span>
        </div>
        <div>}</div>
      </x-marketing.code>
    </div>
  </div>

  <!-- PUT /api/me/timezone -->
  <div class="mb-10 grid grid-cols-1 gap-6 border-b border-gray-200 pb-10 sm:grid-cols-2">
    <div>
      <h3 id="update-the-timezone-of-the-logged-user" class="mb-2 text-lg font-bold">Update the timezone of the logged user</h3>
      <p class="mb-2">This endpoint updates the timezone of the currently logged in user.</p>
      <p class="mb-10">The timezone must be a valid IANA timezone identifier (e.g., "America/New_York", "Europe/London").</p>

      <!-- parameters -->
      <div x-cloak x-data="{ open: false }" class="mb-10">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="mb-2 flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">Parameters</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition>
          <x-marketing.attribute name="timezone" required="true" type="string" description="The timezone of the user in IANA format (e.g., 'America/New_York', 'Europe/London')." />
        </div>
      </div>

      <!-- response attributes -->
      <div x-cloak x-data="{ open: false }">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">Response attributes</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition>
          <x-marketing.attribute name="timezone" type="string" description="The updated timezone of the user in IANA format." />
        </div>
      </div>
    </div>
    <div>
      <x-marketing.code title="/api/me/timezone" verb="PUT" verbClass="text-orange-500">
        <div>{</div>
        <div class="pl-4">
          "timezone":
          <span class="text-lime-700">"Europe/London"</span>
        </div>
        <div>}</div>
      </x-marketing.code>
    </div>
  </div>

  <div>
    <x-marketing-page-widget :marketing-page="$marketingPage" :view-name="$viewName" />
  </div>
</x-marketing-docs-layout>
