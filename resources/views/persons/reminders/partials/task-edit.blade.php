<?php
/*
 * @var Person $person
 * @var array $taskCategories
 * @var Task $task
 */
?>

<div id="task-{{ $task->id }}" class="mb-4 rounded-lg border border-gray-200 bg-white">
  <form x-data="{
    showDueDate: {{ $task->due_at ? 'true' : 'false' }},
    showCategory: {{ $task->task_category_id ? 'true' : 'false' }},
  }" x-target="tasks-list task-{{ $task->id }} notifications" x-target.back="task-{{ $task->id }}" action="{{ route('person.task.update', [$person->slug, $task->id]) }}" method="POST" class="border-b border-gray-200">
    @csrf
    @method('PUT')

    <!-- Hidden fields to track shown sections -->
    <input type="checkbox" name="has_due_date" x-bind:checked="showDueDate" class="hidden" />
    <input type="checkbox" name="has_category" x-bind:checked="showCategory" class="hidden" />

    <div class="flex flex-col gap-y-4 p-4">
      <!-- name of the task -->
      <div>
        <x-input-label for="name" :value="__('Task name')" class="mb-1" />
        <x-text-input class="block w-full" id="name" name="name" type="text" value="{{ $task->name }}" required autofocus />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
      </div>

      <!-- toggles -->
      <div x-show="!showDueDate || !showCategory" class="flex gap-2">
        <!-- due date toggle -->
        <div x-show="!showDueDate" @click="showDueDate = true" class="flex cursor-pointer items-center gap-2 rounded-md border border-transparent bg-gray-50 p-1 text-sm text-gray-500 shadow-xs hover:border-gray-300">
          <x-lucide-calendar class="h-4 w-4" />
          <span>{{ __('Add a due date') }}</span>
        </div>

        <!-- category button -->
        @if ($taskCategories->count() > 0)
          <div x-show="!showCategory" @click="showCategory = true" class="flex cursor-pointer items-center gap-2 rounded-md border border-transparent bg-gray-50 p-1 text-sm text-gray-500 shadow-xs hover:border-gray-300">
            <x-lucide-tag class="h-4 w-4" />
            <span>{{ __('Add a category') }}</span>
          </div>
        @endif
      </div>

      <!-- form fields -->
      <div x-show="showDueDate || showCategory" x-cloak class="flex gap-4">
        <!-- due date -->
        <div x-show="showDueDate" x-cloak>
          <x-input-label optional for="due_at" :value="__('Due date')" />
          <x-text-input id="due_at" name="due_at" type="date" class="mt-1 block" required value="{{ $task->due_at ? $task->due_at->format('Y-m-d') : now()->format('Y-m-d') }}" />
          <x-input-error :messages="$errors->get('due_at')" class="mt-2" />
          <div class="mt-2 cursor-pointer text-xs text-gray-500 underline" @click="showDueDate = false">
            {{ __('Reset date') }}
          </div>
        </div>

        @if ($taskCategories->count() > 0)
          <!-- category dropdown -->
          <div x-show="showCategory" x-cloak class="flex-1">
            <x-input-label optional for="task_category_id" :value="__('Task category')" class="mb-1" />
            <select id="task_category_id" name="task_category_id" class="block w-full rounded-md border-gray-300 px-2 py-1 shadow-xs focus:border-indigo-500 focus:ring-indigo-500 disabled:text-gray-400 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">
              @foreach ($taskCategories as $taskCategory)
                <option value="{{ $taskCategory->id }}" @selected($task->task_category_id == $taskCategory->id)>{{ $taskCategory->name }}</option>
              @endforeach
            </select>
            <x-input-error :messages="$errors->get('task_category_id')" class="mt-2" />
            <div class="mt-2 cursor-pointer text-xs text-gray-500 underline" @click="showCategory = false">
              {{ __('Reset category') }}
            </div>
          </div>
        @endif
      </div>
    </div>

    <div class="flex items-center justify-between border-t border-gray-200 px-4 py-4">
      <x-button.secondary x-target="task-{{ $task->id }}" href="{{ route('person.reminder.index', $person->slug) }}">
        {{ __('Cancel') }}
      </x-button.secondary>

      <x-button.primary>
        {{ __('Save') }}
      </x-button.primary>
    </div>
  </form>

  <form x-target="task-{{ $task->id }}" x-on:ajax:before="
    confirm('Are you sure you want to proceed? This can not be undone.') ||
      $event.preventDefault()
  " action="{{ route('person.task.destroy', [$person->slug, $task->id]) }}" method="POST" class="p-4">
    @csrf
    @method('DELETE')
    <button type="submit" class="inline-flex items-center gap-x-2 rounded-md bg-red-600 px-3.5 py-2 text-sm font-semibold text-white shadow-xs hover:bg-red-500 focus-visible:outline-offset-2 focus-visible:outline-red-600">
      <x-lucide-trash-2 class="h-4 w-4" />
      {{ __('Delete') }}
    </button>
  </form>
</div>
