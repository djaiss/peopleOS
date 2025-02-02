<?php
/*
 * @var \App\Models\Person $person
 * @var Collection $workHistories
 */
?>

<div>
  <h2 class="font-semi-bold mb-1 text-lg">
    {{ __('Work History') }}
  </h2>

  <p class="mb-4 text-sm text-zinc-500">
    {{ __('Track professional journey and career milestones.') }}
  </p>

  <div class="mb-8 rounded-lg border border-gray-200 bg-white">
    <!-- Add Job Form -->
    <div class="border-b border-gray-200">
      <div id="add-work-form" class="p-4">
        <a href="{{ route('persons.work.new', $person->slug) }}" x-target="add-work-form" class="flex w-full cursor-pointer items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
          <x-lucide-plus class="h-4 w-4" />
          {{ __('Add work information') }}
        </a>
      </div>
    </div>

    <!-- Job List -->
    <div id="work-history-list" class="divide-y divide-gray-200">
      @forelse ($workHistories as $history)
      <div id="work-history-{{ $history['id'] }}" class="group flex items-center justify-between p-4">
        <div class="flex items-center gap-3">
          <span class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-100">
            <x-lucide-briefcase class="h-4 w-4 text-blue-600" />
          </span>
          <div>
            <h3 class="font-medium mb-1">
              {{ $history['title'] }}
              @if ($history['is_current'])
                <span class="rounded-full bg-green-100 ml-1 px-2 py-1 text-xs font-medium text-green-800">{{ __('Current') }}</span>
              @endif
            </h3>
            <p class="text-sm text-gray-600 [&>span:not(:last-child)]:after:mx-1 [&>span:not(:last-child)]:after:content-['•']">
              @if ($history['company'])
                <span>{{ $history['company'] }}</span>
              @endif

              @if ($history['duration'])
                <span>{{ $history['duration'] }}</span>
              @endif

              @if ($history['salary'])
                <span>{{ $history['salary'] }}</span>
              @endif
            </p>
          </div>
        </div>
        <div class="flex gap-2">
          <x-button.invisible x-target="work-history-{{ $history['id'] }}" href="{{ route('persons.work.edit', [$person->slug, $history['id']]) }}" class="hidden text-sm group-hover:block">
            {{ __('Edit') }}
          </x-button.invisible>

          <x-button.invisible wire:click="delete({{ $history['id'] }})" wire:confirm="{{ __('Are you sure you want to proceed? This can not be undone.') }}" class="hidden text-sm group-hover:block">
            {{ __('Delete') }}
          </x-button.invisible>
        </div>
      </div>
      @empty
        <div class="flex flex-col items-center justify-center p-6 text-center">
          <span class="flex h-12 w-12 items-center justify-center rounded-full bg-blue-100">
            <x-lucide-briefcase class="h-6 w-6 text-blue-600" />
          </span>
          <h3 class="mt-2 text-sm font-semibold text-gray-900">{{ __('No work history yet') }}</h3>
          <p class="mt-1 text-sm text-gray-500">{{ __('Track their professional journey by adding their work experiences.') }}</p>
        </div>
      @endforelse
    </div>
  </div>
</div>
