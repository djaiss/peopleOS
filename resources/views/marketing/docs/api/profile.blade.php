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

      <!-- url parameters -->
      <x-marketing.url-parameters>
        <p class="text-gray-500">This endpoint does not have any parameters.</p>
      </x-marketing.url-parameters>

      <!-- query parameters -->
      <x-marketing.query-parameters>
        <p class="text-gray-500">No query parameters are available for this endpoint.</p>
      </x-marketing.query-parameters>

      <!-- response attributes -->
      <x-marketing.response-attributes>
        <x-marketing.attribute name="type" type="string" description="The type of the resource." />
        <x-marketing.attribute name="id" type="string" description="The ID of the user." />
        <x-marketing.attribute name="first_name" type="string" description="The first name of the user." />
        <x-marketing.attribute name="last_name" type="string" description="The last name of the user." />
        <x-marketing.attribute name="nickname" type="string" description="The nickname of the user." />
        <x-marketing.attribute name="email" type="string" description="The email of the user." />
        <x-marketing.attribute name="born_at" type="integer" description="The birth date of the user, in Unix timestamp format." />
        <x-marketing.attribute name="links" type="object" description="The link to access the user." />
      </x-marketing.response-attributes>
    </div>
    <div>
      <x-marketing.code title="/api/me" verb="GET" verbClass="text-blue-700">
        <div>{</div>
        <div class="pl-4">"data": {</div>
        <div class="pl-8">
          "type":
          <span class="text-lime-700">"user"</span>
          ,
        </div>
        <div class="pl-8">
          "id":
          <span class="text-rose-800">"1"</span>
          ,
        </div>
        <div class="pl-8">"attributes": {</div>
        <div class="pl-12">
          "first_name":
          <span class="text-lime-700">"Monica"</span>
          ,
        </div>
        <div class="pl-12">
          "last_name":
          <span class="text-lime-700">"Geller"</span>
          ,
        </div>
        <div class="pl-12">
          "nickname":
          <span class="text-lime-700">"Godzilla"</span>
          ,
        </div>
        <div class="pl-12">
          "email":
          <span class="text-lime-700">"admin@admin.com"</span>
          ,
        </div>
        <div class="pl-12">
          "born_at":
          <span class="text-rose-800">1715145600</span>
        </div>
        <div class="pl-8">},</div>
        <div class="pl-8">"links": {</div>
        <div class="pl-12">
          "self":
          <span class="text-lime-700">"{{ config('app.url') }}/api/me"</span>
        </div>
        <div class="pl-8">}</div>
        <div class="pl-4">}</div>
        <div>}</div>
      </x-marketing.code>
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

      <!-- url parameters -->
      <x-marketing.url-parameters>
        <p class="text-gray-500">This endpoint does not have any parameters.</p>
      </x-marketing.url-parameters>

      <!-- query parameters -->
      <x-marketing.query-parameters>
        <x-marketing.attribute name="first_name" required="true" type="string" description="The first name of the user. Max 255 characters." />
        <x-marketing.attribute name="last_name" required="true" type="string" description="The last name of the user. Max 255 characters." />
        <x-marketing.attribute name="nickname" type="string" description="The nickname of the user. Max 255 characters." />
        <x-marketing.attribute name="email" required="true" type="string" description="The email of the user. This email should be unique in the instance, and we will validate the email format. Max 255 characters." />
        <x-marketing.attribute name="born_at" type="string" description="The birth date of the user. Format: YYYY-MM-DD. Example: 1985-03-15" />
      </x-marketing.query-parameters>

      <!-- response attributes -->
      <x-marketing.response-attributes>
        <x-marketing.attribute name="type" type="string" description="The type of the resource." />
        <x-marketing.attribute name="id" type="string" description="The ID of the user." />
        <x-marketing.attribute name="first_name" type="string" description="The first name of the user." />
        <x-marketing.attribute name="last_name" type="string" description="The last name of the user." />
        <x-marketing.attribute name="nickname" type="string" description="The nickname of the user." />
        <x-marketing.attribute name="email" type="string" description="The email of the user." />
        <x-marketing.attribute name="born_at" type="integer" description="The birth date of the user, in Unix timestamp format." />
        <x-marketing.attribute name="links" type="object" description="The link to access the user." />
      </x-marketing.response-attributes>
    </div>
    <div>
      <x-marketing.code title="/api/me" verb="PUT" verbClass="text-yellow-700">
        <div>{</div>
        <div class="pl-4">"data": {</div>
        <div class="pl-8">
          "type":
          <span class="text-lime-700">"user"</span>
          ,
        </div>
        <div class="pl-8">
          "id":
          <span class="text-rose-800">"1"</span>
          ,
        </div>
        <div class="pl-8">"attributes": {</div>
        <div class="pl-12">
          "first_name":
          <span class="text-lime-700">"Dwight"</span>
          ,
        </div>
        <div class="pl-12">
          "last_name":
          <span class="text-lime-700">"Schrute"</span>
          ,
        </div>
        <div class="pl-12">
          "nickname":
          <span class="text-lime-700">"Dwightchou"</span>
          ,
        </div>
        <div class="pl-12">
          "email":
          <span class="text-lime-700">"dwight.schrute@dundermifflin.com"</span>
          ,
        </div>
        <div class="pl-12">
          "born_at":
          <span class="text-rose-800">479692800</span>
        </div>
        <div class="pl-8">},</div>
        <div class="pl-8">"links": {</div>
        <div class="pl-12">
          "self":
          <span class="text-lime-700">"{{ config('app.url') }}/api/me"</span>
        </div>
        <div class="pl-8">}</div>
        <div class="pl-4">}</div>
        <div>}</div>
      </x-marketing.code>
    </div>
  </div>

  <!-- GET /api/me/timezone -->
  <div class="mb-10 grid grid-cols-1 gap-6 border-b border-gray-200 pb-10 sm:grid-cols-2">
    <div>
      <h3 id="get-the-timezone-of-the-logged-user" class="mb-2 text-lg font-bold">Get the timezone of the logged user</h3>
      <p class="mb-10">
        This endpoint retrieves the timezone information of the currently logged in user. The timezone is stored in the database as a string, and is in
        <a href="https://timeie.com/iana-timezones" target="_blank" class="text-blue-500 hover:underline">IANA format</a>
        (e.g.,
        <code class="text-sm">America/New_York</code>
        ,
        <code class="text-sm">Europe/London</code>
        ).
      </p>

      <!-- url parameters -->
      <x-marketing.url-parameters>
        <p class="text-gray-500">This endpoint does not have any parameters.</p>
      </x-marketing.url-parameters>

      <!-- query parameters -->
      <x-marketing.query-parameters>
        <p class="text-gray-500">No query parameters are available for this endpoint.</p>
      </x-marketing.query-parameters>

      <!-- response attributes -->
      <x-marketing.response-attributes>
        <x-marketing.attribute name="timezone" type="string" description="The timezone of the user in IANA format." />
      </x-marketing.response-attributes>
    </div>
    <div>
      <x-marketing.code title="/api/me/timezone" verb="GET" verbClass="text-blue-700">
        <div>{</div>
        <div class="pl-4">"data": {</div>
        <div class="pl-8">
          "type":
          <span class="text-lime-700">"timezone"</span>
          ,
        </div>
        <div class="pl-8">"attributes": {</div>
        <div class="pl-12">
          "timezone":
          <span class="text-lime-700">"America/New_York"</span>
        </div>
        <div class="pl-8">},</div>
        <div class="pl-8">"links": {</div>
        <div class="pl-12">
          "self":
          <span class="text-lime-700">"{{ config('app.url') }}/api/me"</span>
        </div>
        <div class="pl-8">}</div>
        <div class="pl-4">}</div>
        <div>}</div>
      </x-marketing.code>
    </div>
  </div>

  <!-- PUT /api/me/timezone -->
  <div class="mb-10 grid grid-cols-1 gap-6 border-b border-gray-200 pb-10 sm:grid-cols-2">
    <div>
      <h3 id="update-the-timezone-of-the-logged-user" class="mb-2 text-lg font-bold">Update the timezone of the logged user</h3>
      <p class="mb-2">This endpoint updates the timezone of the currently logged in user.</p>
      <p class="mb-10">
        The timezone must be a valid
        <a href="https://timeie.com/iana-timezones" target="_blank" class="text-blue-500 hover:underline">IANA timezone identifier</a>
        (e.g.,
        <code class="text-sm">America/New_York</code>
        ,
        <code class="text-sm">Europe/London</code>
        ).
      </p>

      <!-- url parameters -->
      <x-marketing.url-parameters>
        <p class="text-gray-500">This endpoint does not have any parameters.</p>
      </x-marketing.url-parameters>

      <!-- query parameters -->
      <x-marketing.query-parameters>
        <x-marketing.attribute name="timezone" required="true" type="string" description="The timezone of the user in IANA format (e.g., 'America/New_York', 'Europe/London')." />
      </x-marketing.query-parameters>

      <!-- response attributes -->
      <x-marketing.response-attributes>
        <x-marketing.attribute name="timezone" type="string" description="The updated timezone of the user in IANA format." />
      </x-marketing.response-attributes>
    </div>
    <div>
      <x-marketing.code title="/api/me/timezone" verb="PUT" verbClass="text-yellow-700">
        <div>{</div>
        <div class="pl-4">"data": {</div>
        <div class="pl-8">
          "type":
          <span class="text-lime-700">"timezone"</span>
          ,
        </div>
        <div class="pl-8">"attributes": {</div>
        <div class="pl-12">
          "timezone":
          <span class="text-lime-700">"Europe/Paris"</span>
        </div>
        <div class="pl-8">},</div>
        <div class="pl-8">"links": {</div>
        <div class="pl-12">
          "self":
          <span class="text-lime-700">"{{ config('app.url') }}/api/me"</span>
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
