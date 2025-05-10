<?php
/*
 * @var Person $person
 */
?>

<div id="new-love-relationship" class="mb-8 rounded-lg border border-gray-200 bg-white">
  <!-- Tabs -->
  <div class="mb-4 border-b border-gray-200">
    <nav class="-mb-px flex justify-center space-x-8">
      <div class="cursor-pointer border-b-2 border-rose-500 px-1 py-3 text-sm font-medium whitespace-nowrap text-rose-600 hover:border-gray-300 hover:text-gray-700">
        {{ __('Add someone new') }}
      </div>
      <a x-target="new-love-relationship" href="{{ route('person.love.existing.new', $person) }}" class="border-b-2 border-transparent px-1 py-3 text-sm font-medium whitespace-nowrap hover:border-gray-300 hover:text-gray-700">
        {{ __('Add existing person') }}
      </a>
    </nav>
  </div>

  <!-- Create new contact form -->
  <form x-target="love-listing new-love-relationship persons" x-target.back="new-love-relationship" action="{{ route('person.love.store', $person) }}" method="POST">
    @csrf

    <div class="mb-4 flex gap-4 px-4">
      <div class="flex-1">
        <x-input-label for="first_name" :value="__('First name')" class="mb-1" />
        <x-text-input class="block w-full" id="first_name" name="first_name" type="text" required autofocus />
        <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
      </div>
      <div class="flex-1">
        <x-input-label optional for="last_name" :value="__('Last name')" class="mb-1" />
        <x-text-input class="block w-full" id="last_name" name="last_name" type="text" />
        <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
      </div>
    </div>

    <div class="mb-4 flex gap-4 px-4">
      <div class="flex-1">
        <x-input-label for="nature_of_relationship" :value="__('Nature of relationship')" class="mb-1" />
        <x-text-input class="block w-full" id="nature_of_relationship" name="nature_of_relationship" placeholder="{{ __('Ex: Spouse, girlfriend, boyfriend, etc.') }}" type="text" required />
        <x-input-error :messages="$errors->get('nature_of_relationship')" class="mt-2" />
      </div>
    </div>

    <div class="mb-4 flex gap-2 px-4">
      <div class="flex h-6 shrink-0 items-center">
        <div class="group grid size-4 grid-cols-1">
          <input id="create_entry" name="create_entry" type="checkbox" value="create_entry" class="col-start-1 row-start-1 appearance-none rounded-sm border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto" />
          <x-input-error :messages="$errors->get('create_entry')" class="mt-2" />
        </div>
      </div>
      <div class="text-sm/6">
        <label for="create_entry" class="font-medium text-gray-900">{{ __('Create an entry for this person in the contact list') }}</label>
        <p id="create_entry-description" class="text-gray-500">{{ __('You will be able to add notes, link with other persons, etc...') }}</p>
      </div>
    </div>

    <div class="mb-4 flex gap-2 border-b border-gray-200 px-4 pb-4">
      <div class="flex h-6 shrink-0 items-center">
        <div class="group grid size-4 grid-cols-1">
          <input id="active" name="active" type="checkbox" value="active" class="col-start-1 row-start-1 appearance-none rounded-sm border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto" />
          <x-input-error :messages="$errors->get('active')" class="mt-2" />
        </div>
      </div>
      <div class="text-sm/6">
        <label for="active" class="font-medium text-gray-900">{{ __('This love relationship is ongoing') }}</label>
        <p id="active-description" class="text-gray-500">{{ __('Select this if the relationship is current. Past relationships will be shown separately.') }}</p>
      </div>
    </div>

    <div class="flex items-center justify-between px-4 pb-4">
      <x-button.secondary x-target="new-love-relationship" href="{{ route('person.family.index', $person) }}">
        {{ __('Cancel') }}
      </x-button.secondary>

      <x-button.primary>
        {{ __('Create relationship') }}
      </x-button.primary>
    </div>
  </form>
</div>
