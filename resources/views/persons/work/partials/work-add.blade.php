<?php
/*
 * @var \App\Models\Person $person
 */
?>

<form x-target="work-history-list add-work-form notifications" x-target.422="add-work-form" id="add-work-form" action="{{ route('persons.work.store', $person->slug) }}" method="POST">
  @csrf

  <div class="mb-4 flex gap-4 px-4 pt-4">
    <div class="flex-1">
      <x-input-label for="title" :value="__('Job title')" class="mb-2" />
      <x-text-input class="block w-full" id="title" name="title" type="text" required data-1p-ignore value="{{ old('title') }}" />
      <x-input-error :messages="$errors->get('title')" class="mt-2" />
    </div>
    <div class="flex-1">
      <x-input-label optional for="company" :value="__('Company')" class="mb-1" />
      <x-text-input class="block w-full" id="company" name="company" type="text" data-1p-ignore value="{{ old('company') }}" />
      <x-input-error :messages="$errors->get('company')" class="mt-2" />
    </div>
  </div>

  <div class="mb-4 flex gap-4 px-4">
    <div class="flex-1">
      <x-input-label optional for="duration" :value="__('Duration')" class="mb-1" />
      <x-text-input class="block w-full" id="duration" name="duration" type="text" value="{{ old('duration') }}" />
      <x-input-error :messages="$errors->get('duration')" class="mt-2" />
    </div>
    <div class="flex-1">
      <x-input-label optional for="salary" :value="__('Estimated salary')" class="mb-1" />
      <x-text-input class="block w-full" id="salary" name="salary" type="text" value="{{ old('salary') }}" />
      <x-input-error :messages="$errors->get('salary')" class="mt-2" />
    </div>
  </div>

  <div class="mb-4 flex gap-2 border-b border-gray-200 px-4 pb-4">
    <div class="flex h-6 shrink-0 items-center">
      <div class="group grid size-4 grid-cols-1">
        <input checked value="1" id="is_current" name="is_current" type="checkbox" class="col-start-1 row-start-1 appearance-none rounded-sm border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto" />
      </div>
    </div>
    <div class="text-sm/6">
      <label for="is_current" class="font-medium text-gray-900">{{ __('Mark as current job') }}</label>
      <p id="is_current-description" class="text-gray-500">{{ __('This job will be highlighted in the list.') }}</p>
      <x-input-error :messages="$errors->get('is_current')" class="mt-2" />
    </div>
  </div>

  <div class="flex items-center justify-between px-4 pb-4">
    <x-button.secondary x-target="add-work-form" href="{{ route('persons.work.index', $person->slug) }}">
      {{ __('Cancel') }}
    </x-button.secondary>

    <x-button.primary>
      {{ __('Save') }}
    </x-button.primary>
  </div>
</form>
