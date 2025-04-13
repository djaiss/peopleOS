<?php
/*
 * @var \App\Models\Person $person
 * @var array $activeTasks
 * @var array $completedTasks
 */
?>

<!-- Header -->
<div class="mb-4 flex items-center justify-between">
  <div class="flex items-center gap-2">
    <x-lucide-list-todo class="h-5 w-5 text-amber-500" />
    <h2 class="text-lg font-semibold text-gray-900">{{ __('Tasks') }}</h2>
  </div>

  <div class="flex items-center gap-2">
    <a x-target="add-task-form" href="{{ route('person.task.new', $person->slug) }}" class="inline-flex items-center gap-1 rounded-md bg-amber-200 px-2 py-1 text-sm font-medium text-amber-600 hover:bg-amber-300">
      <x-lucide-plus class="mr-1 h-3 w-3" />
      {{ __('Add') }}
    </a>
  </div>
</div>

<div id="add-task-form"></div>

<!-- tasks list -->
@if ($activeTasks->count() > 0 || $completedTasks->count() > 0)
  <div id="tasks-list" class="mb-10 space-y-0">
    @foreach ($activeTasks as $task)
      @include('persons.reminders.partials.task-detail', ['task' => $task])
    @endforeach

    @if ($completedTasks->count() > 0)
      <!-- completed tasks -->
      <div id="completed-tasks-list" class="mt-4 ml-4" x-data="{ completedTasksExpanded: false }">
        <div @click="completedTasksExpanded = !completedTasksExpanded" class="mb-4 flex cursor-pointer items-center justify-between gap-x-1 rounded-lg border p-2 hover:bg-white">
          <h3 class="text-sm font-semibold text-gray-900">{{ __('Completed tasks') }}</h3>
          <x-lucide-chevron-down x-show="! completedTasksExpanded" class="h-4 w-4" />
          <x-lucide-chevron-up x-show="completedTasksExpanded" class="h-4 w-4" />
        </div>

        <div x-cloak x-show="completedTasksExpanded">
          @foreach ($completedTasks as $task)
            @include('persons.reminders.partials.task-detail', ['task' => $task])
          @endforeach
        </div>
      </div>
    @endif
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
