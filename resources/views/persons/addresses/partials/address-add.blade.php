<?php
/*
 * @var Person $person
 */
?>

<div id="new-address" class="mb-8 rounded-lg border border-gray-200 bg-white">
  <form x-target="addresses-listing new-address addresses-status" x-target.back="new-address" action="{{ route('person.address.create', $person) }}" method="POST" class="flex flex-col gap-4">
    @csrf

    <div class="mb-4 flex gap-4 px-4 pt-4">
      <div class="flex-1">
        <x-input-label optional for="address_line_1" :value="__('Address Line 1')" class="mb-1" />
        <x-text-input class="block w-full" id="address_line_1" name="address_line_1" type="text" value="{{ old('address_line_1') }}" />
        <x-input-error :messages="$errors->get('address_line_1')" class="mt-2" />
      </div>
      <div class="flex-1">
        <x-input-label optional for="address_line_2" :value="__('Address Line 2')" class="mb-1" />
        <x-text-input class="block w-full" id="address_line_2" name="address_line_2" type="text" value="{{ old('address_line_2') }}" />
        <x-input-error :messages="$errors->get('address_line_2')" class="mt-2" />
      </div>
    </div>

    <div class="mb-4 flex gap-4 px-4">
      <div class="flex-1">
        <x-input-label optional for="city" :value="__('City')" class="mb-1" />
        <x-text-input class="block w-full" id="city" name="city" type="text" value="{{ old('city') }}" />
        <x-input-error :messages="$errors->get('city')" class="mt-2" />
      </div>
      <div class="flex-1">
        <x-input-label optional for="state" :value="__('State/Province')" class="mb-1" />
        <x-text-input class="block w-full" id="state" name="state" type="text" value="{{ old('state') }}" />
        <x-input-error :messages="$errors->get('state')" class="mt-2" />
      </div>
    </div>

    <div class="mb-4 flex gap-4 px-4">
      <div class="flex-1">
        <x-input-label optional for="postal_code" :value="__('Postal Code')" class="mb-1" />
        <x-text-input class="block w-full" id="postal_code" name="postal_code" type="text" value="{{ old('postal_code') }}" />
        <x-input-error :messages="$errors->get('postal_code')" class="mt-2" />
      </div>
      <div class="flex-1">
        <x-input-label optional for="country" :value="__('Country')" class="mb-1" />
        <x-text-input class="block w-full" id="country" name="country" type="text" value="{{ old('country') }}" />
        <x-input-error :messages="$errors->get('country')" class="mt-2" />
      </div>
    </div>

    <div class="px-4">
      <div class="flex items-center">
        <input id="is_active" name="is_active" type="checkbox" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
        <x-input-label for="is_active" :value="__('Active address')" class="ml-2" />
      </div>
      <x-input-error :messages="$errors->get('is_active')" class="mt-2" />
    </div>

    <div class="flex items-center justify-between border-t border-gray-200 px-4 py-4">
      <x-button.secondary x-target="new-address" href="{{ route('person.show', $person) }}">
        {{ __('Cancel') }}
      </x-button.secondary>

      <x-button.primary>
        {{ __('Save') }}
      </x-button.primary>
    </div>
  </form>
</div>
