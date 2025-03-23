<?php
/*
 * @var \App\Models\Person $person
 * @var array $tasks
 */
?>

<!-- Header -->
<div class="mb-4 flex items-center justify-between">
  <div class="flex items-center gap-2">
    <x-lucide-list-todo class="h-5 w-5 text-amber-500" />
    <h2 class="text-lg font-semibold text-gray-900">{{ __('Tasks') }}</h2>
  </div>

  <div class="flex items-center gap-2">
    <a x-target="add-task-form" href="{{ route('persons.tasks.new', $person->slug) }}" class="inline-flex items-center gap-1 rounded-md bg-amber-200 px-2 py-1 text-sm font-medium text-amber-600 hover:bg-amber-300">
      <x-lucide-plus class="mr-1 h-3 w-3" />
      {{ __('Add') }}
    </a>
  </div>
</div>

<div id="add-task-form"></div>

<!-- tasks list -->
@if ($tasks->count() > 0)
  <div id="tasks-list" class="mb-10 space-y-0">
    @foreach ($tasks as $task)
      <div class="flex justify-between rounded-lg border border-transparent px-4 py-2 hover:border-gray-200 hover:bg-white">
        <div class="flex gap-2">
          <div class="flex h-6 shrink-0 items-center">
            <div class="group grid size-4 grid-cols-1">
              <input id="createEntry" name="createEntry" type="checkbox" class="col-start-1 row-start-1 appearance-none rounded-sm border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto" />
            </div>
          </div>
          <div class="flex items-center gap-2 text-sm/6">
            @if ($task['task_category'])
              <span id="createEntry-description" class="{{ $task['task_category']['color'] }} px-2 text-gray-500">{{ $task['task_category']['name'] }}</span>
            @endif

            <label for="createEntry" class="font-medium text-gray-900">{{ $task['name'] }}</label>
            <p id="createEntry-description" class="text-gray-500">{{ $task['due_at'] }}</p>
          </div>
        </div>
      </div>
    @endforeach
  </div>
@else
  <div id="tasks-list" class="mb-10 flex flex-col items-center justify-center rounded-lg border border-gray-200 bg-white p-8 text-center">
    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-amber-100">
      <x-lucide-list-todo class="h-6 w-6 text-amber-500" />
    </div>

    <h3 class="mt-2 text-sm font-semibold text-gray-900">{{ __('No tasks yet') }}</h3>
    <p class="mt-1 text-sm text-gray-500">
      {{ __('Tasks are used to track things you need to do for a person.') }}
    </p>
  </div>
@endif
