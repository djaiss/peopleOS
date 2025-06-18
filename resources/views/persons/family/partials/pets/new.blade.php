<?php
/*
 * @var Person $person
 * @var Collection $persons
 */
?>

<div id="new-pet" class="mb-8 rounded-lg border border-gray-200 bg-white">
  <form x-target="pets-listing new-pet" x-target.back="new-pet" action="{{ route('person.pet.store', $person) }}" method="POST">
    @csrf

    <div class="mb-4 flex gap-4 px-4 pt-4">
      <div class="flex-1">
        <x-input-label optional for="name" :value="__('Pet name')" class="mb-1" />
        <x-text-input class="block w-full" id="name" name="name" type="text" value="{{ old('name') }}" />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
      </div>
      <div class="flex-1">
        <x-input-label for="species" :value="__('Species')" class="mb-1" />
        <select id="species" name="species" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
          <option value="">{{ __('Select a species...') }}</option>
          <option value="dog">{{ __('Dog') }}</option>
          <option value="cat">{{ __('Cat') }}</option>
          <option value="bird">{{ __('Bird') }}</option>
          <option value="fish">{{ __('Fish') }}</option>
          <option value="hamster">{{ __('Hamster') }}</option>
          <option value="rabbit">{{ __('Rabbit') }}</option>
          <option value="other">{{ __('Other') }}</option>
        </select>
        <x-input-error :messages="$errors->get('species')" class="mt-2" />
      </div>
    </div>

    <div class="mb-4 flex gap-4 px-4">
      <div class="flex-1">
        <x-input-label optional for="breed" :value="__('Breed')" class="mb-1" />
        <x-text-input class="block w-full" id="breed" name="breed" type="text" value="{{ old('breed') }}" />
        <x-input-error :messages="$errors->get('breed')" class="mt-2" />
      </div>
      <div class="flex-1">
        <x-input-label optional for="gender" :value="__('Gender')" class="mb-1" />
        <select id="gender" name="gender" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
          <option value="">{{ __('Select gender...') }}</option>
          <option value="male">{{ __('Male') }}</option>
          <option value="female">{{ __('Female') }}</option>
        </select>
        <x-input-error :messages="$errors->get('gender')" class="mt-2" />
      </div>
    </div>

    <div class="flex items-center justify-between border-t border-gray-200 px-4 py-4">
      <x-button.secondary x-target="new-pet" href="{{ route('person.family.index', $person) }}">
        {{ __('Cancel') }}
      </x-button.secondary>

      <x-button.primary>
        {{ __('Save') }}
      </x-button.primary>
    </div>
  </form>
</div>
