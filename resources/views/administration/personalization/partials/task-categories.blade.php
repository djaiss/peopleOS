<?php
/*
 * @var array $taskCategories
 */
?>

<h2 class="font-semi-bold mb-1 text-lg">
  {{ __('Edit your categories for tasks') }}
</h2>

<p class="mb-4 text-sm text-zinc-500">
  {{ __('Changes to categories affect all the tasks in your account. For instance, if you change "Call" to "Phone call", all the tasks that are related to calls will be updated.') }}
</p>

<div class="mb-8 border border-gray-200 bg-white sm:rounded-lg">
  <!-- nb of categories + action -->
  <div id="add-category-form" class="flex items-center justify-between rounded-t-lg border-b border-gray-200 p-3 last:rounded-b-lg last:border-b-0 hover:bg-blue-50">
    @if ($taskCategories->isEmpty())
      <p class="text-sm text-zinc-500">{{ __('No categories created') }}</p>
    @else
      <p class="text-sm text-zinc-500">{{ __(':count category(s)', ['count' => $taskCategories->count()]) }}</p>
    @endif

    <x-button.secondary x-target="add-category-form" href="{{ route('administration.personalization.task-categories.new') }}" class="mr-2 text-sm">
      {{ __('New category') }}
    </x-button.secondary>
  </div>

  <div id="category-list" class="divide-y divide-gray-200">
    @forelse ($taskCategories as $taskCategory)
      <div id="task-category-{{ $taskCategory['id'] }}" class="group flex items-center justify-between p-3 transition-colors duration-200 last:rounded-b-lg">
        <div class="flex items-center gap-2">
          <div class="{{ $taskCategory['color'] }} h-4 w-4 rounded-full"></div>
          <p class="border border-transparent py-1 text-sm font-semibold">{{ $taskCategory['name'] }}</p>
        </div>

        <div class="flex gap-2">
          <x-button.invisible x-target="task-category-{{ $taskCategory['id'] }}" href="{{ route('administration.personalization.task-categories.edit', $taskCategory['id']) }}" class="hidden text-sm group-hover:block">
            {{ __('Edit') }}
          </x-button.invisible>

          <form x-target="task-category-{{ $taskCategory['id'] }}" x-on:ajax:before="
            confirm('Are you sure you want to proceed? This can not be undone.') ||
              $event.preventDefault()
          " action="{{ route('administration.personalization.task-categories.destroy', $taskCategory['id']) }}" method="POST">
            @csrf
            @method('DELETE')

            <x-button.invisible class="hidden text-sm group-hover:block">
              {{ __('Delete') }}
            </x-button.invisible>
          </form>
        </div>
      </div>
    @empty
      <div class="flex flex-col items-center justify-center p-6 text-center">
        <x-lucide-dna class="h-8 w-8 text-gray-400" />
        <h3 class="mt-2 text-sm font-semibold text-gray-900">{{ __('No categories created') }}</h3>
        <p class="mt-1 text-sm text-gray-500">{{ __('Get started by creating a new category.') }}</p>
      </div>
    @endforelse
  </div>
</div>
