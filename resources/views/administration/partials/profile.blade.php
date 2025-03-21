<?php
/*
 * @var \App\Models\User $user
 */
?>

<h1 class="font-semi-bold mb-4 text-2xl">
  {{ __('Profile') }}
</h1>

<form action="{{ route('administration.update') }}" method="post" class="mb-8 border border-gray-200 bg-white sm:rounded-lg" x-data="{ showActions: false }">
  @csrf
  @method('put')

  <!-- first name -->
  <div class="grid grid-cols-3 items-center rounded-t-lg border-b border-gray-200 p-3 hover:bg-blue-50">
    <x-input-label for="first_name" :value="__('First name')" class="col-span-2" />
    <div class="w-full justify-self-end">
      <x-text-input class="block w-full" value="{{ old('first_name', $user->first_name) }}" id="first_name" name="first_name" type="text" required @focus="showActions = true" @blur="showActions = false" />
      <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
    </div>
  </div>

  <!-- last name -->
  <div class="grid grid-cols-3 items-center border-b border-gray-200 p-3 hover:bg-blue-50">
    <x-input-label for="last_name" :value="__('Last name')" class="col-span-2" />
    <div class="w-full justify-self-end">
      <x-text-input class="block w-full" value="{{ old('last_name', $user->last_name) }}" id="last_name" name="last_name" type="text" required @focus="showActions = true" @blur="showActions = false" />
      <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
    </div>
  </div>

  <!-- nickname -->
  <div class="grid grid-cols-3 items-center border-b border-gray-200 p-3 hover:bg-blue-50">
    <x-input-label for="nickname" :value="__('Nickname')" class="col-span-2" />
    <div class="w-full justify-self-end">
      <x-text-input class="block w-full placeholder-shown:bg-gray-50" value="{{ old('nickname', $user->nickname) }}" id="nickname" name="nickname" type="text" placeholder="{{ __('No nickname defined') }}" @focus="showActions = true" @blur="showActions = false" />
      <x-input-error class="mt-2" :messages="$errors->get('nickname')" />
    </div>
  </div>

  <!-- email -->
  <div class="grid grid-cols-3 items-center border-b border-gray-200 p-3 hover:bg-blue-50">
    <div class="col-span-2">
      <x-input-label for="email" :value="__('Email')" />
      <x-help>{{ __('We will send you an email to verify this email address, and won\'t use this email for marketing purposes.') }}</x-help>
    </div>

    <div class="w-full justify-self-end">
      <x-text-input class="block w-full" value="{{ old('email', $user->email) }}" id="email" name="email" type="email" required @focus="showActions = true" @blur="showActions = false" />
      <x-input-error class="mt-2" :messages="$errors->get('email')" />
    </div>
  </div>

  <!-- birthdate -->
  <div class="grid grid-cols-3 items-center p-3 last:rounded-b-lg hover:bg-blue-50">
    <x-input-label for="born_at" :value="__('Birthdate')" class="col-span-2" />
    <div class="w-full justify-self-end">
      <x-text-input x-mask="99/99/9999" placeholder="MM/DD/YYYY" class="block w-full" value="{{ old('born_at', $user->born_at?->format('m-d-Y')) }}" id="born_at" name="born_at" type="text" @focus="showActions = true" @blur="showActions = false" />
      <x-input-error class="mt-2" :messages="$errors->get('born_at')" />
    </div>
  </div>

  <div x-cloak x-show="showActions" x-transition:enter="transition duration-200 ease-out" x-transition:enter-start="-translate-y-2 transform opacity-0" x-transition:enter-end="translate-y-0 transform opacity-100" x-transition:leave="transition duration-150 ease-in" x-transition:leave-start="translate-y-0 transform opacity-100" x-transition:leave-end="-translate-y-2 transform opacity-0" class="flex justify-between border-t border-gray-200 p-3">
    <x-button.secondary @click="showActions = false" class="mr-2">
      {{ __('Cancel') }}
    </x-button.secondary>

    <x-button.primary>
      {{ __('Save') }}
    </x-button.primary>
  </div>
</form>
