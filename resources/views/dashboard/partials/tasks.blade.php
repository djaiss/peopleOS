<?php
/*
 * @var array $tasks
 */
?>

<div class="rounded-lg border border-gray-200 bg-white">
  <div class="rounded-t-lg border-b border-gray-200 bg-gray-50 px-4 py-2">
    <div class="flex items-center justify-between">
      <div class="flex items-center gap-2">
        <x-lucide-list-todo class="h-5 w-5 text-amber-500" />
        <h3 class="text-sm font-medium text-gray-700">{{ __('Tasks') }}</h3>
      </div>
    </div>
  </div>
  @forelse ($tasks as $task)
    <div id="task-{{ $task['id'] }}" class="flex justify-between px-4 py-2 hover:bg-gray-50 last:hover:rounded-b-lg">
      <div class="flex gap-2">
        <!-- checkbox -->
        <div class="flex h-6 shrink-0 items-center">
          <form x-target="task-{{ $task['id'] }} tasks-list completed-tasks-list" action="{{ route('person.task.toggle', [$task['person']['slug'], $task['id']]) }}" method="POST" class="group grid size-4 grid-cols-1">
            @csrf
            @method('PUT')
            <input type="checkbox" x-on:change="$el.form.requestSubmit()" class="col-start-1 row-start-1 appearance-none rounded-sm border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto" />
          </form>
        </div>

        <!-- task details -->
        <div class="flex flex-col">
          <a x-target="task-{{ $task['id'] }}" href="{{ route('person.task.edit', [$task['person']['slug'], $task['id']]) }}" class="flex items-center gap-2 text-sm/6">
            @if ($task['task_category'] && $task['task_category']['id'])
              <span class="{{ $task['task_category']['color'] }} rounded-md px-2 text-gray-500">{{ $task['task_category']['name'] }}</span>
            @endif

            <span class="font-medium text-gray-900">{{ $task['name'] }}</span>
            <p class="text-gray-500">{{ $task['due_at'] }}</p>
          </a>

          <div class="text-sm font-normal text-gray-600">
            @if ($task['person']['slug'])
              <a href="{{ route('person.show', $task['person']['slug']) }}" class="hover:underline">{{ $task['person']['name'] }}</a>
            @else
              {{ $task['person']['name'] }}
            @endif
          </div>
        </div>
      </div>
    </div>
  @empty
    <div id="tasks-list" class="mb-10 flex flex-col items-center justify-center rounded-lg bg-white p-8 text-center">
      <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-amber-100">
        <x-lucide-list-todo class="h-6 w-6 text-amber-500" />
      </div>

      <h3 class="mt-2 text-sm font-semibold text-gray-900">{{ __('No tasks yet') }}</h3>
      <p class="mt-1 text-sm text-gray-500">
        {{ __('Tasks are used to track things you need to do for a person.') }}
      </p>
    </div>
  @endforelse
</div>
