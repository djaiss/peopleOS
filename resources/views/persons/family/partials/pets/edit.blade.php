<?php
/*
 * @var Person $person
 * @var Pet $pet
 * @var Collection $persons
 */
?>

<div id="pet-{{ $pet->id }}" class="rounded-lg bg-white">
  <form x-target="pets-listing pet-{{ $pet->id }} pets-status" x-target.back="pet-{{ $pet->id }}" action="{{ route('person.pet.update', ['slug' => $person->slug, 'pet' => $pet->id]) }}" method="POST" class="flex flex-col gap-4">
    @csrf
    @method('PUT')

    <div class="mb-4 flex gap-4 px-4 pt-4">
      <div class="flex-1">
        <x-input-label optional for="name" :value="__('Pet name')" class="mb-1" />
        <x-text-input class="block w-full" id="name" name="name" type="text" value="{{ old('name', $pet->name) }}" />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
      </div>
      <div class="flex-1">
        <x-input-label for="species" :value="__('Species')" class="mb-1" />
        <select id="species" name="species" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
          <option value="">{{ __('Select a species...') }}</option>
          <option value="dog" {{ old('species', $pet->species) === 'dog' ? 'selected' : '' }}>{{ __('Dog') }}</option>
          <option value="cat" {{ old('species', $pet->species) === 'cat' ? 'selected' : '' }}>{{ __('Cat') }}</option>
          <option value="bird" {{ old('species', $pet->species) === 'bird' ? 'selected' : '' }}>{{ __('Bird') }}</option>
          <option value="fish" {{ old('species', $pet->species) === 'fish' ? 'selected' : '' }}>{{ __('Fish') }}</option>
          <option value="hamster" {{ old('species', $pet->species) === 'hamster' ? 'selected' : '' }}>{{ __('Hamster') }}</option>
          <option value="rabbit" {{ old('species', $pet->species) === 'rabbit' ? 'selected' : '' }}>{{ __('Rabbit') }}</option>
          <option value="other" {{ old('species', $pet->species) === 'other' ? 'selected' : '' }}>{{ __('Other') }}</option>
        </select>
        <x-input-error :messages="$errors->get('species')" class="mt-2" />
      </div>
    </div>

    <div class="mb-4 flex gap-4 px-4">
      <div class="flex-1">
        <x-input-label optional for="breed" :value="__('Breed')" class="mb-1" />
        <x-text-input class="block w-full" id="breed" name="breed" type="text" value="{{ old('breed', $pet->breed) }}" />
        <x-input-error :messages="$errors->get('breed')" class="mt-2" />
      </div>
      <div class="flex-1">
        <x-input-label optional for="gender" :value="__('Gender')" class="mb-1" />
        <select id="gender" name="gender" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
          <option value="">{{ __('Select gender...') }}</option>
          <option value="male" {{ old('gender', $pet->gender) === 'male' ? 'selected' : '' }}>{{ __('Male') }}</option>
          <option value="female" {{ old('gender', $pet->gender) === 'female' ? 'selected' : '' }}>{{ __('Female') }}</option>
        </select>
        <x-input-error :messages="$errors->get('gender')" class="mt-2" />
      </div>
    </div>

    <div class="flex items-center justify-between border-t border-gray-200 px-4 py-4">
      <x-button.secondary x-target="pet-{{ $pet->id }}" href="{{ route('person.family.index', $person) }}">
        {{ __('Cancel') }}
      </x-button.secondary>

      <x-button.primary>
        {{ __('Save') }}
      </x-button.primary>
    </div>
  </form>
</div>
