<?php
/*
 * @var \App\Models\MarketingPage $marketingPage
 * @var string $viewName
 */
?>

<x-marketing-docs-layout :marketing-page="$marketingPage" :view-name="$viewName">
  <h1 class="mb-6 text-2xl font-bold">Task categories</h1>

  <div class="mb-8 rounded-lg border p-4">
    <p class="mb-2 text-xs">Table of contents</p>

    <ul>
      <li>
        <a href="#get-the-list-of-task-categories" class="text-blue-500 hover:underline">Get the list of task categories in the account</a>
      </li>
      <li>
        <a href="#create-a-new-task-category" class="text-blue-500 hover:underline">Create a new task category</a>
      </li>
      <li>
        <a href="#show-a-task-category" class="text-blue-500 hover:underline">Show a task category</a>
      </li>
      <li>
        <a href="#update-a-task-category" class="text-blue-500 hover:underline">Update a task category</a>
      </li>
      <li>
        <a href="#delete-a-task-category" class="text-blue-500 hover:underline">Delete a task category</a>
      </li>
    </ul>
  </div>

  <div class="mb-10 grid grid-cols-1 gap-6 border-b border-gray-200 pb-10 sm:grid-cols-2">
    <div>
      <p class="mb-2">This endpoint lets you manage the task categories in your account.</p>
      <p class="mb-10">Task categories help you organize and classify different types of tasks. Each category can have a name and a color to help visually distinguish them.</p>
    </div>
    <div>
      <x-marketing.code title="Endpoints">
        <div class="flex flex-col gap-y-2">
          <a href="#get-the-list-of-task-categories">
            <span class="text-blue-700">GET</span>
            /api/administration/task-categories
          </a>
          <a href="#create-a-new-task-category">
            <span class="text-green-700">POST</span>
            /api/administration/task-categories
          </a>
          <a href="#show-a-task-category">
            <span class="text-blue-700">GET</span>
            /api/administration/task-categories/{id}
          </a>
          <a href="#update-a-task-category">
            <span class="text-yellow-700">PUT</span>
            /api/administration/task-categories/{id}
          </a>
          <a href="#delete-a-task-category">
            <span class="text-red-700">DELETE</span>
            /api/administration/task-categories/{id}
          </a>
        </div>
      </x-marketing.code>
    </div>
  </div>

  <!-- GET /api/administration/task-categories -->
  <div class="mb-10 grid grid-cols-1 gap-6 border-b border-gray-200 pb-10 sm:grid-cols-2">
    <div>
      <h3 id="get-the-list-of-task-categories" class="mb-2 text-lg font-bold">Get the list of task categories</h3>
      <p class="mb-2">This endpoint gets the list of task categories in the account.</p>
      <p class="mb-10">This call is not paginated, since there should not be too many task categories in the account.</p>

      <!-- url parameters -->
      <x-marketing.url-parameters>
        <p class="text-gray-500">No URL parameters are required for this endpoint.</p>
      </x-marketing.url-parameters>

      <!-- query parameters -->
      <x-marketing.query-parameters>
        <p class="text-gray-500">No query parameters are available for this endpoint.</p>
      </x-marketing.query-parameters>

      <!-- response attributes -->
      <x-marketing.response-attributes>
        <x-marketing.attribute name="id" type="integer" description="The ID of the task category." />
        <x-marketing.attribute name="object" type="string" description="The object type. Always 'task_category'." />
        <x-marketing.attribute name="name" type="string" description="The name of the task category." />
        <x-marketing.attribute name="color" type="string" description="The color of the task category." />
        <x-marketing.attribute name="created_at" type="integer" description="The date and time the object was created, in Unix timestamp format." />
        <x-marketing.attribute name="updated_at" type="integer" description="The date and time the object was last updated, in Unix timestamp format." />
      </x-marketing.response-attributes>
    </div>
    <div>
      <x-marketing.code title="/api/administration/task-categories" verb="GET" verbClass="text-blue-700">
        <div>{</div>
        <div class="pl-4">"data": [</div>
        @include('marketing.docs.api.partials.task-category-response', ['with_comma' => true])
        <div class="pl-8">{</div>
        <div class="pl-12">...</div>
        <div class="pl-8">}</div>
        <div class="pl-4">]</div>
        <div>}</div>
      </x-marketing.code>
    </div>
  </div>

  <!-- POST /api/administration/task-categories -->
  <div class="mb-10 grid grid-cols-1 gap-6 border-b border-gray-200 pb-10 sm:grid-cols-2">
    <div>
      <h3 id="create-a-new-task-category" class="mb-2 text-lg font-bold">Create a new task category</h3>
      <p class="mb-10">This endpoint creates a new task category. It will return the task category in the response.</p>

      <!-- url parameters -->
      <x-marketing.url-parameters>
        <p class="text-gray-500">No URL parameters are required for this endpoint.</p>
      </x-marketing.url-parameters>

      <!-- query parameters -->
      <x-marketing.query-parameters>
        <x-marketing.attribute required name="name" type="string" description="The name of the task category. Maximum 255 characters." />
        <x-marketing.attribute required name="color" type="string" description="The color of the task category. Maximum 30 characters." />
      </x-marketing.query-parameters>

      <!-- response attributes -->
      <x-marketing.response-attributes>
        <x-marketing.attribute name="id" type="integer" description="The ID of the task category." />
        <x-marketing.attribute name="object" type="string" description="The object type. Always 'task_category'." />
        <x-marketing.attribute name="name" type="string" description="The name of the task category." />
        <x-marketing.attribute name="color" type="string" description="The color of the task category." />
        <x-marketing.attribute name="created_at" type="integer" description="The date and time the object was created, in Unix timestamp format." />
        <x-marketing.attribute name="updated_at" type="integer" description="The date and time the object was last updated, in Unix timestamp format." />
      </x-marketing.response-attributes>
    </div>
    <div>
      <x-marketing.code title="/api/administration/task-categories" verb="POST" verbClass="text-green-700">
        <div>{</div>
        <div class="pl-4">"data": {</div>
        @include('marketing.docs.api.partials.task-category-response')
        <div class="pl-4">}</div>
        <div>}</div>
      </x-marketing.code>
    </div>
  </div>

  <!-- GET /api/administration/task-categories/{id} -->
  <div class="mb-10 grid grid-cols-1 gap-6 border-b border-gray-200 pb-10 sm:grid-cols-2">
    <div>
      <h3 id="show-a-task-category" class="mb-2 text-lg font-bold">Show a task category</h3>
      <p class="mb-10">This endpoint shows a task category.</p>

      <!-- url parameters -->
      <x-marketing.url-parameters>
        <x-marketing.attribute required name="id" type="integer" description="The ID of the task category to show." />
      </x-marketing.url-parameters>

      <!-- query parameters -->
      <x-marketing.query-parameters>
        <p class="text-gray-500">No query parameters are available for this endpoint.</p>
      </x-marketing.query-parameters>

      <!-- response attributes -->
      <x-marketing.response-attributes>
        <x-marketing.attribute name="id" type="integer" description="The ID of the task category." />
        <x-marketing.attribute name="object" type="string" description="The object type. Always 'task_category'." />
        <x-marketing.attribute name="name" type="string" description="The name of the task category." />
        <x-marketing.attribute name="color" type="string" description="The color of the task category." />
        <x-marketing.attribute name="created_at" type="integer" description="The date and time the object was created, in Unix timestamp format." />
        <x-marketing.attribute name="updated_at" type="integer" description="The date and time the object was last updated, in Unix timestamp format." />
      </x-marketing.response-attributes>
    </div>
    <div>
      <x-marketing.code title="/api/administration/task-categories/{id}" verb="GET" verbClass="text-blue-700">
        <div>{</div>
        <div class="pl-4">"data": {</div>
        @include('marketing.docs.api.partials.task-category-response')
        <div class="pl-4">}</div>
        <div>}</div>
      </x-marketing.code>
    </div>
  </div>

  <!-- PUT /api/administration/task-categories/{id} -->
  <div class="mb-10 grid grid-cols-1 gap-6 border-b border-gray-200 pb-10 sm:grid-cols-2">
    <div>
      <h3 id="update-a-task-category" class="mb-2 text-lg font-bold">Update a task category</h3>
      <p class="mb-10">This endpoint updates a task category. It will return the task category in the response.</p>

      <!-- url parameters -->
      <x-marketing.url-parameters>
        <x-marketing.attribute required name="id" type="integer" description="The ID of the task category to update." />
      </x-marketing.url-parameters>

      <!-- query parameters -->
      <x-marketing.query-parameters>
        <x-marketing.attribute required name="name" type="string" description="The name of the task category. Maximum 255 characters." />
        <x-marketing.attribute required name="color" type="string" description="The color of the task category. Maximum 30 characters." />
      </x-marketing.query-parameters>

      <!-- response attributes -->
      <x-marketing.response-attributes>
        <x-marketing.attribute name="id" type="integer" description="The ID of the task category." />
        <x-marketing.attribute name="object" type="string" description="The object type. Always 'task_category'." />
        <x-marketing.attribute name="name" type="string" description="The name of the task category." />
        <x-marketing.attribute name="color" type="string" description="The color of the task category." />
        <x-marketing.attribute name="created_at" type="integer" description="The date and time the object was created, in Unix timestamp format." />
        <x-marketing.attribute name="updated_at" type="integer" description="The date and time the object was last updated, in Unix timestamp format." />
      </x-marketing.response-attributes>
    </div>
    <div>
      <x-marketing.code title="/api/administration/task-categories/{id}" verb="PUT" verbClass="text-yellow-700">
        <div>{</div>
        <div class="pl-4">"data": {</div>
        @include('marketing.docs.api.partials.task-category-response')
        <div class="pl-4">}</div>
        <div>}</div>
      </x-marketing.code>
    </div>
  </div>

  <!-- DELETE /api/administration/task-categories/{id} -->
  <div class="mb-10 grid grid-cols-1 gap-6 border-b border-gray-200 pb-10 sm:grid-cols-2">
    <div>
      <h3 id="delete-a-task-category" class="mb-2 text-lg font-bold">Delete a task category</h3>
      <p class="mb-10">This endpoint deletes a task category. It will return a 204 No Content response.</p>

      <!-- url parameters -->
      <x-marketing.url-parameters>
        <x-marketing.attribute required name="id" type="integer" description="The ID of the task category to delete." />
      </x-marketing.url-parameters>

      <!-- query parameters -->
      <x-marketing.query-parameters>
        <p class="text-gray-500">No query parameters are available for this endpoint.</p>
      </x-marketing.query-parameters>

      <!-- response attributes -->
      <x-marketing.response-attributes>
        <p class="text-gray-500">This endpoint returns a 204 No Content response with no body.</p>
      </x-marketing.response-attributes>
    </div>
    <div>
      <x-marketing.code title="/api/administration/task-categories/{id}" verb="DELETE" verbClass="text-red-700">
        <div class="text-gray-500">204 No Content</div>
      </x-marketing.code>
    </div>
  </div>

  <div>
    <x-marketing-page-widget :marketing-page="$marketingPage" :view-name="$viewName" />
  </div>
</x-marketing-docs-layout>
