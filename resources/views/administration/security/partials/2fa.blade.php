<?php
/*
 * @var Collection $apiKeys
 * @var bool $has_2fa
 */
?>

<h2 class="font-semi-bold mb-1 text-lg">{{ __('Two-factor authentication') }}</h2>
<p class="mb-2 text-sm text-zinc-500">{{ __('Two-factor authentication adds an additional layer of security to your account by requiring more than just a password to sign in.') }}</p>
<p class="mb-4 text-sm text-zinc-500">{{ __('Set your preferred method to use for two-factor authentication when signing into PeopleOS.') }}</p>

<form x-target="timezone-form" x-target.back="timezone-form" id="timezone-form" action="{{ route('administration.timezone.update') }}" method="post" class="mb-8 border border-gray-200 bg-white sm:rounded-lg" x-data="{ showActions: false }">
  @csrf
  @method('put')

  <!-- timezone -->
  <div class="grid grid-cols-3 items-center rounded-t-lg p-3 last:rounded-b-lg hover:bg-blue-50">
    <div class="col-span-2">
      <x-input-label for="timezone" :value="__('Preferred methods')" />
    </div>
    <div class="col-span-1 w-full justify-self-end">
      <select @focus="showActions = true" @blur="showActions = false" id="timezone" name="timezone" class="mt-1 block w-full rounded-md border-gray-300 shadow-xs focus:border-indigo-500 focus:ring-indigo-500 disabled:text-gray-400 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">
        <option value="{{ App\Enums\TwoFactorType::NONE }}">{{ __('None') }}</option>
        <option value="{{ App\Enums\TwoFactorType::AUTHENTICATOR }}">{{ __('Authenticator app') }}</option>
        <option value="{{ App\Enums\TwoFactorType::EMAIL }}">{{ __('Code by email') }}</option>
      </select>

      <x-input-error class="mt-2" :messages="$errors->get('timezone')" />
    </div>
  </div>

  <!-- actions -->
  <div x-cloak x-show="showActions" x-transition:enter="transition duration-200 ease-out" x-transition:enter-start="-translate-y-2 transform opacity-0" x-transition:enter-end="translate-y-0 transform opacity-100" x-transition:leave="transition duration-150 ease-in" x-transition:leave-start="translate-y-0 transform opacity-100" x-transition:leave-end="-translate-y-2 transform opacity-0" class="flex justify-between border-t border-gray-200 p-3">
    <x-button.secondary @click="showActions = false" class="mr-2">
      {{ __('Cancel') }}
    </x-button.secondary>

    <x-button.primary>
      {{ __('Save') }}
    </x-button.primary>
  </div>
</form>

<div class="mb-8 border border-gray-200 bg-white sm:rounded-lg">
  <!-- Authenticator app -->
  <div id="authenticator-app" class="flex items-center rounded-t-lg border-b border-gray-200 p-3 hover:bg-blue-50">
    <x-lucide-smartphone class="h-5 w-5 text-gray-500" />
    <div class="ms-5 flex w-full items-center justify-between">
      <div>
        <p class="font-semibold">
          {{ __('Authenticator app') }}
          @if ($has_2fa)
          <span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-green-900 dark:text-green-300">{{ __('Configured') }}</span>
          @endif
        </p>
        <p class="text-xs text-gray-600">{{ __('Use an authentication app to get two-factor authentication codes when prompted.') }}</p>
      </div>

      @if ($has_2fa)
        <x-button.secondary href="{{ route('administration.security.2fa.new') }}" x-target="authenticator-app" class="mr-2 text-sm">
          {{ __('Edit') }}
        </x-button.secondary>
      @else
        <x-button.secondary href="{{ route('administration.security.2fa.new') }}" x-target="authenticator-app" class="mr-2 text-sm">
          {{ __('Set up') }}
        </x-button.secondary>
      @endif
    </div>
  </div>

  <!-- recovery codes -->
  @if ($has_2fa)
  <div id="recovery-codes" class="flex items-center border-b border-gray-200 p-3 hover:bg-blue-50">
    <x-lucide-container class="h-5 w-5 text-gray-500" />
    <div class="ms-5 flex w-full items-center justify-between">
      <div>
        <p class="font-semibold">
          {{ __('Recovery codes') }}
        </p>
        <p class="text-xs text-gray-600">{{ __('Use these codes to access your account if you lose access to your authenticator app.') }}</p>
      </div>

      <x-button.secondary href="{{ route('administration.security.recoverycodes.show') }}" x-target="recovery-codes" class="mr-2 text-sm">
        {{ __('Show') }}
      </x-button.secondary>
    </div>
  </div>
  @endif

  <!-- Code by email -->
  <div class="flex items-center rounded-b-lg p-3 hover:bg-blue-50">
    <x-lucide-mail class="h-5 w-5 text-gray-500" />
    <div class="ms-5 flex w-full items-center justify-between">
      <div class="">
        <p class="font-semibold">{{ __('Code by email') }}</p>
        <p class="text-xs text-gray-600">{{ __('Receive a one-time code via email.') }}</p>
      </div>

      <x-button.secondary class="mr-2 text-sm">
        {{ __('Set up') }}
      </x-button.secondary>
    </div>
  </div>
</div>
