<form wire:submit="store">
  <div class="mb-4 flex gap-4 px-4 pt-4">
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

  <div class="mb-4 flex gap-4 px-4">
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

  <div class="mb-4 flex gap-2 border-b border-gray-200 px-4 pb-4">
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

  <div class="flex items-center justify-between px-4 pb-4">
    <x-button.secondary wire:click="toggleAddMode" type="button" class="mr-2">
      {{ __('Cancel') }}
    </x-button.secondary>

    <x-button.primary>
      {{ __('Save') }}
    </x-button.primary>
  </div>
</form>
