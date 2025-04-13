<?php
/*
 * @var $task
 */
?>

<div id="task-{{ $task['id'] }}" class="flex justify-between rounded-lg border border-transparent px-4 py-2 hover:border-gray-200 hover:bg-white">
  <div class="flex gap-2">
    <!-- checkbox -->
    <div class="flex h-6 shrink-0 items-center">
      <form x-target="task-{{ $task['id'] }} tasks-list completed-tasks-list" action="{{ route('person.task.toggle', [$person->slug, $task['id']]) }}" method="POST" class="group grid size-4 grid-cols-1">
        @csrf
        @method('PUT')
        <input @checked($task['is_completed']) type="checkbox" x-on:change="$el.form.requestSubmit()" class="col-start-1 row-start-1 appearance-none rounded-sm border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto" />
      </form>
    </div>

    <!-- task details -->
    <a x-target="task-{{ $task['id'] }}" href="{{ route('person.task.edit', [$person->slug, $task['id']]) }}" class="flex items-center gap-2 text-sm/6">
      @if ($task['task_category'])
        <span class="{{ $task['task_category']['color'] }} rounded-md px-2 text-gray-500">{{ $task['task_category']['name'] }}</span>
      @endif

      <span class="font-medium text-gray-900">{{ $task['name'] }}</span>
      <p class="text-gray-500">{{ $task['due_at'] }}</p>
    </a>
  </div>
</div>
