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
        {{--
          @if ($editedWorkHistoryId === $history['id'])
          <form wire:submit="update" class="p-4">
          <div class="mb-4 flex gap-4">
          <div class="flex-1">
          <x-input-label for="title" :value="__('Job title')" class="mb-1" />
          <x-text-input class="block w-full" id="title" name="title" type="text" data-1p-ignore />
          <x-input-error :messages="$errors->get('title')" class="mt-2" />
          </div>
          <div class="flex-1">
          <x-input-label optional for="company" :value="__('Company')" class="mb-1" />
          <x-text-input class="block w-full" id="company" name="company" type="text" data-1p-ignore />
          <x-input-error :messages="$errors->get('company')" class="mt-2" />
          </div>
          </div>
          
          <div class="mb-4 flex gap-4">
          <div class="flex-1">
          <x-input-label optional for="duration" :value="__('Duration')" class="mb-1" />
          <x-text-input class="block w-full" id="duration" name="duration" type="text" data-1p-ignore />
          <x-input-error :messages="$errors->get('duration')" class="mt-2" />
          </div>
          <div class="flex-1">
          <x-input-label optional for="salary" :value="__('Estimated salary')" class="mb-1" />
          <x-text-input class="block w-full" id="salary" name="salary" type="text" data-1p-ignore />
          <x-input-error :messages="$errors->get('salary')" class="mt-2" />
          </div>
          </div>
          
          <div class="mb-4 flex gap-2">
          <div class="flex h-6 shrink-0 items-center">
          <div class="group grid size-4 grid-cols-1">
          <input id="isCurrentJob" name="isCurrentJob" type="checkbox" class="col-start-1 row-start-1 appearance-none rounded-sm border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto" />
          <svg class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white group-has-disabled:stroke-gray-950/25" viewBox="0 0 14 14" fill="none">
          <path class="opacity-0 group-has-checked:opacity-100" d="M3 8L6 11L11 3.5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
          <path class="opacity-0 group-has-indeterminate:opacity-100" d="M3 7H11" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
          </svg>
          </div>
          </div>
          <div class="text-sm/6">
          <label for="isCurrentJob" class="font-medium text-gray-900">{{ __('Mark as current job') }}</label>
          <p id="isCurrentJob-description" class="text-gray-500">{{ __('This job will be highlighted in the list.') }}</p>
          </div>
          </div>
          
          <div class="flex items-center justify-between">
          <x-button.secondary wire:click="resetEdit" type="button" class="mr-2">
          {{ __('Cancel') }}
          </x-button.secondary>
          
          <x-button.primary>
          {{ __('Save') }}
          </x-button.primary>
          </div>
          </form>
          @else
        --}}
        <div id="work-history-{{ $history['id'] }}" class="group flex items-center justify-between p-4">
          <div class="flex items-center gap-3">
            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-100">
              <x-lucide-briefcase class="h-4 w-4 text-blue-600" />
            </span>
            <div>
              <h3 class="font-medium">
                {{ $history['title'] }}
                @if ($history['is_current'])
                  <span class="rounded-full bg-green-100 px-2 py-1 text-xs font-medium text-green-800">{{ __('Current') }}</span>
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
            <x-button.invisible wire:click="toggleEditMode({{ $history['id'] }})" class="hidden text-sm group-hover:block">
              {{ __('Edit') }}
            </x-button.invisible>

            <x-button.invisible wire:click="delete({{ $history['id'] }})" wire:confirm="{{ __('Are you sure you want to proceed? This can not be undone.') }}" class="hidden text-sm group-hover:block">
              {{ __('Delete') }}
            </x-button.invisible>
          </div>
        </div>
        {{-- @endif --}}
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
