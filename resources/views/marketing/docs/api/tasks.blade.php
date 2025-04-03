<?php
/*
 * @var \App\Models\MarketingPage $marketingPage
 */
?>

<x-marketing-docs-layout :marketing-page="$marketingPage">
  <h1 class="mb-6 text-2xl font-bold">Tasks linked to a person</h1>

  <div class="mb-8 rounded-lg border p-4">
    <p class="mb-2 text-xs">Table of contents</p>

    <ul>
      <li>
        <a href="#get-the-list-of-tasks" class="text-blue-500 hover:underline">Get the list of tasks for a person</a>
      </li>
      <li>
        <a href="#create-a-new-task" class="text-blue-500 hover:underline">Create a new task</a>
      </li>
      <li>
        <a href="#get-a-specific-task" class="text-blue-500 hover:underline">Get a specific task</a>
      </li>
      <li>
        <a href="#update-a-task" class="text-blue-500 hover:underline">Update a task</a>
      </li>
      <li>
        <a href="#delete-a-task" class="text-blue-500 hover:underline">Delete a task</a>
      </li>
      <li>
        <a href="#toggle-a-task" class="text-blue-500 hover:underline">Toggle a task</a>
      </li>
    </ul>
  </div>

  <!-- introduction -->
  <div class="mb-10 grid grid-cols-1 gap-6 border-b border-gray-200 pb-10 sm:grid-cols-2">
    <div>
      <p class="mb-2">This endpoint lets you manage tasks for a person.</p>
      <p class="mb-10">
        Tasks help you track things you need to do related to a person. Each task can be assigned
        <a href="{{ route('marketing.docs.api.task-categories') }}" class="text-blue-500 hover:underline">a category</a>
        to help organize them.
      </p>
    </div>
    <div>
      <x-marketing.code title="Endpoints">
        <div class="flex flex-col gap-y-2">
          <a href="#get-the-list-of-tasks">
            <span class="text-blue-700">GET</span>
            /api/persons/{person}/tasks
          </a>
          <a href="#create-a-new-task">
            <span class="text-green-700">POST</span>
            /api/persons/{person}/tasks
          </a>
          <a href="#get-a-specific-task">
            <span class="text-blue-700">GET</span>
            /api/persons/{person}/tasks/{task}
          </a>
          <a href="#update-a-task">
            <span class="text-yellow-700">PUT</span>
            /api/persons/{person}/tasks/{task}
          </a>
          <a href="#delete-a-task">
            <span class="text-red-700">DELETE</span>
            /api/persons/{person}/tasks/{task}
          </a>
          <a href="#toggle-a-task">
            <span class="text-yellow-700">PUT</span>
            /api/tasks/{task}/toggle
          </a>
        </div>
      </x-marketing.code>
    </div>
  </div>

  <!-- GET /api/persons/{person}/tasks -->
  <div class="mb-10 grid grid-cols-1 gap-6 border-b border-gray-200 pb-10 sm:grid-cols-2">
    <div>
      <h3 id="get-the-list-of-tasks" class="mb-2 text-lg font-bold">Get the list of tasks</h3>
      <p class="mb-2">This endpoint gets the list of tasks for a specific person.</p>
      <p class="mb-10">Tasks are ordered by creation date, with the most recent first.</p>

      <!-- url parameters -->
      <div x-cloak x-data="{ open: false }" class="mb-8">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="mb-2 flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">URL parameters</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition class="mt-2">
          <x-marketing.attribute required name="person" type="integer" description="The ID of the person." />
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
          <x-marketing.attribute name="id" type="integer" description="The ID of the task." />
          <x-marketing.attribute name="object" type="string" description="The object type. Always 'task'." />
          <x-marketing.attribute name="name" type="string" description="The name of the task." />
          <x-marketing.attribute name="is_completed" type="boolean" description="Whether the task is completed." />
          <x-marketing.attribute name="due_at" type="integer" description="The date the task is due, in Unix timestamp format." />
          <x-marketing.attribute name="completed_at" type="integer" description="The date the task was completed, in Unix timestamp format." />
          <x-marketing.attribute name="task_category" type="array" description="A subset of the Task category object linked to the task." />
          <x-marketing.attribute name="created_at" type="integer" description="The date and time the object was created, in Unix timestamp format." />
          <x-marketing.attribute name="updated_at" type="integer" description="The date and time the object was last updated, in Unix timestamp format." />
        </div>
      </div>
    </div>

    <!-- example response -->
    <div>
      <x-marketing.code title="/api/persons/{person}/tasks" verb="GET" verbClass="text-blue-700">
        <div>{</div>
        <div class="pl-4">"data": [</div>
        <div class="pl-8">{</div>
        @include('marketing.docs.api.partials.task-response')
        <div class="pl-8">}</div>
        <div class="pl-4">]</div>
        <div>}</div>
      </x-marketing.code>
    </div>
  </div>

  <!-- POST /api/persons/{person}/tasks -->
  <div class="mb-10 grid grid-cols-1 gap-6 border-b border-gray-200 pb-10 sm:grid-cols-2">
    <div>
      <h3 id="create-a-new-task" class="mb-2 text-lg font-bold">Create a new task</h3>
      <p class="mb-10">This endpoint creates a new task for a specific person. It will return the task in the response.</p>

      <!-- url parameters -->
      <div x-cloak x-data="{ open: false }" class="mb-8">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="mb-2 flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">URL parameters</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition class="mt-2">
          <x-marketing.attribute required name="person" type="integer" description="The ID of the person." />
        </div>
      </div>

      <!-- query parameters -->
      <div x-cloak x-data="{ open: false }" class="mb-8">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="mb-2 flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">Query parameters</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition class="mt-2">
          <x-marketing.attribute required name="name" type="string" description="The name of the task. Maximum 255 characters." />
          <x-marketing.attribute name="due_at" type="date" description="The date the task is due, in ISO 8601 format (YYYY-MM-DD)." />
          <x-marketing.attribute name="task_category_id" type="integer" description="The ID of the task category object." />
        </div>
      </div>

      <!-- response attributes -->
      <div x-cloak x-data="{ open: false }">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">Response attributes</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition class="mt-2">
          <x-marketing.attribute name="id" type="integer" description="The ID of the task." />
          <x-marketing.attribute name="object" type="string" description="The object type. Always 'task'." />
          <x-marketing.attribute name="name" type="string" description="The name of the task." />
          <x-marketing.attribute name="is_completed" type="boolean" description="Whether the task is completed." />
          <x-marketing.attribute name="due_at" type="integer" description="The date the task is due, in Unix timestamp format." />
          <x-marketing.attribute name="completed_at" type="integer" description="The date the task was completed, in Unix timestamp format." />
          <x-marketing.attribute name="task_category" type="array" description="A subset of the Task category object linked to the task." />
          <x-marketing.attribute name="created_at" type="integer" description="The date and time the object was created, in Unix timestamp format." />
          <x-marketing.attribute name="updated_at" type="integer" description="The date and time the object was last updated, in Unix timestamp format." />
        </div>
      </div>
    </div>
    <div>
      <x-marketing.code title="/api/persons/{person}/tasks" verb="POST" verbClass="text-green-700">
        <div>{</div>
        <div class="pl-4">"data": {</div>
        @include('marketing.docs.api.partials.task-response')
        <div class="pl-8">}</div>
        <div>}</div>
      </x-marketing.code>
    </div>
  </div>

  <!-- GET /api/persons/{person}/tasks/{task} -->
  <div class="mb-10 grid grid-cols-1 gap-6 border-b border-gray-200 pb-10 sm:grid-cols-2">
    <div>
      <h3 id="get-a-specific-task" class="mb-2 text-lg font-bold">Get a specific task</h3>
      <p class="mb-10">This endpoint retrieves a specific task for a person.</p>

      <!-- parameters -->
      <div x-cloak x-data="{ open: false }" class="mb-8">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="mb-2 flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">Parameters</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition class="mt-2">
          <x-marketing.attribute required name="person" type="integer" description="The ID of the person." />
          <x-marketing.attribute required name="task" type="integer" description="The ID of the task." />
        </div>
      </div>

      <!-- response attributes -->
      <div x-cloak x-data="{ open: false }">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">Response attributes</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition class="mt-2">
          <x-marketing.attribute name="id" type="integer" description="The ID of the task." />
          <x-marketing.attribute name="object" type="string" description="The object type. Always 'task'." />
          <x-marketing.attribute name="name" type="string" description="The name of the task." />
          <x-marketing.attribute name="is_completed" type="boolean" description="Whether the task is completed." />
          <x-marketing.attribute name="due_at" type="integer" description="The date the task is due, in Unix timestamp format." />
          <x-marketing.attribute name="completed_at" type="integer" description="The date the task was completed, in Unix timestamp format." />
          <x-marketing.attribute name="task_category" type="array" description="A subset of the Task category object linked to the task." />
          <x-marketing.attribute name="created_at" type="integer" description="The date and time the object was created, in Unix timestamp format." />
          <x-marketing.attribute name="updated_at" type="integer" description="The date and time the object was last updated, in Unix timestamp format." />
        </div>
      </div>
    </div>
    <div>
      <x-marketing.code title="/api/persons/{person}/tasks/{task}" verb="GET" verbClass="text-blue-700">
        <div>{</div>
        <div class="pl-4">"data": {</div>
        @include('marketing.docs.api.partials.task-response')
        <div class="pl-8">}</div>
        <div>}</div>
      </x-marketing.code>
    </div>
  </div>

  <!-- PUT /api/persons/{person}/tasks/{task} -->
  <div class="mb-10 grid grid-cols-1 gap-6 border-b border-gray-200 pb-10 sm:grid-cols-2">
    <div>
      <h3 id="update-a-task" class="mb-2 text-lg font-bold">Update a task</h3>
      <p class="mb-10">This endpoint updates a specific task for a person. It will return the updated task in the response.</p>

      <!-- parameters -->
      <div x-cloak x-data="{ open: false }" class="mb-8">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="mb-2 flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">Parameters</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition class="mt-2">
          <x-marketing.attribute required name="person" type="integer" description="The ID of the person." />
          <x-marketing.attribute required name="task" type="integer" description="The ID of the task." />
          <x-marketing.attribute required name="name" type="string" description="The name of the task. Maximum 255 characters." />
          <x-marketing.attribute name="is_completed" type="boolean" description="Whether the task is completed." />
          <x-marketing.attribute name="due_at" type="integer" description="The date the task is due, in Unix timestamp format." />
          <x-marketing.attribute name="task_category_id" type="integer" description="The ID of the task category." />
        </div>
      </div>

      <!-- response attributes -->
      <div x-cloak x-data="{ open: false }">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">Response attributes</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition class="mt-2">
          <x-marketing.attribute name="id" type="integer" description="The ID of the task." />
          <x-marketing.attribute name="object" type="string" description="The object type. Always 'task'." />
          <x-marketing.attribute name="name" type="string" description="The name of the task." />
          <x-marketing.attribute name="is_completed" type="boolean" description="Whether the task is completed." />
          <x-marketing.attribute name="due_at" type="integer" description="The date the task is due, in Unix timestamp format." />
          <x-marketing.attribute name="completed_at" type="integer" description="The date the task was completed, in Unix timestamp format." />
          <x-marketing.attribute name="task_category" type="array" description="A subset of the Task category object linked to the task." />
          <x-marketing.attribute name="created_at" type="integer" description="The date and time the object was created, in Unix timestamp format." />
          <x-marketing.attribute name="updated_at" type="integer" description="The date and time the object was last updated, in Unix timestamp format." />
        </div>
      </div>
    </div>
    <div>
      <x-marketing.code title="/api/persons/{person}/tasks/{task}" verb="PUT" verbClass="text-yellow-700">
        <div>{</div>
        <div class="pl-4">"data": {</div>
        @include('marketing.docs.api.partials.task-response')
        <div class="pl-8">}</div>
        <div>}</div>
      </x-marketing.code>
    </div>
  </div>

  <!-- DELETE /api/persons/{person}/tasks/{task} -->
  <div class="mb-10 grid grid-cols-1 gap-6 border-b border-gray-200 pb-10 sm:grid-cols-2">
    <div>
      <h3 id="delete-a-task" class="mb-2 text-lg font-bold">Delete a task</h3>
      <p class="mb-10">This endpoint deletes a specific task for a person. It will return a 204 No Content response.</p>

      <!-- parameters -->
      <div x-cloak x-data="{ open: false }" class="mb-8">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="mb-2 flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">Parameters</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition class="mt-2">
          <x-marketing.attribute required name="person" type="integer" description="The ID of the person." />
          <x-marketing.attribute required name="task" type="integer" description="The ID of the task." />
        </div>
      </div>

      <!-- response attributes -->
      <div x-cloak x-data="{ open: false }">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">Response attributes</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition class="mt-2">
          <p class="text-gray-500">This endpoint returns a 204 No Content response with no body.</p>
        </div>
      </div>
    </div>
    <div>
      <x-marketing.code title="/api/persons/{person}/tasks/{task}" verb="DELETE" verbClass="text-red-700">
        <div class="text-gray-500">204 No Content</div>
      </x-marketing.code>
    </div>
  </div>

  <!-- PUT /api/tasks/{task}/toggle -->
  <div class="mb-10 grid grid-cols-1 gap-6 border-b border-gray-200 pb-10 sm:grid-cols-2">
    <div>
      <h3 id="toggle-a-task" class="mb-2 text-lg font-bold">Toggle a task</h3>
      <p class="mb-10">This endpoint marks a task as completed or not completed, depending on its current state. It will return the updated task in the response.</p>

      <!-- parameters -->
      <div x-cloak x-data="{ open: false }" class="mb-8">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="mb-2 flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">Parameters</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition class="mt-2">
          <x-marketing.attribute required name="task" type="integer" description="The ID of the task." />
        </div>
      </div>

      <!-- response attributes -->
      <div x-cloak x-data="{ open: false }">
        <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="flex cursor-pointer items-center justify-between pb-2">
          <p class="font-semibold">Response attributes</p>
          <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
        </div>

        <div x-show="open" x-transition class="mt-2">
          <x-marketing.attribute name="id" type="integer" description="The ID of the task." />
          <x-marketing.attribute name="object" type="string" description="The object type. Always 'task'." />
          <x-marketing.attribute name="name" type="string" description="The name of the task." />
          <x-marketing.attribute name="is_completed" type="boolean" description="Whether the task is completed." />
          <x-marketing.attribute name="due_at" type="integer" description="The date the task is due, in Unix timestamp format." />
          <x-marketing.attribute name="completed_at" type="integer" description="The date the task was completed, in Unix timestamp format." />
          <x-marketing.attribute name="task_category" type="array" description="A subset of the Task category object linked to the task." />
          <x-marketing.attribute name="created_at" type="integer" description="The date and time the object was created, in Unix timestamp format." />
          <x-marketing.attribute name="updated_at" type="integer" description="The date and time the object was last updated, in Unix timestamp format." />
        </div>
      </div>
    </div>
    <div>
      <x-marketing.code title="/api/tasks/{task}/toggle" verb="PUT" verbClass="text-yellow-700">
        @include('marketing.docs.api.partials.task-response')
      </x-marketing.code>
    </div>
  </div>

  <div>
    <x-marketing-page-widget :marketing-page="$marketingPage" />
  </div>
</x-marketing-docs-layout>
