<x-app-layout>
  <x-slot name="breadcrumb">
    <div class="flex text-sm">
      <p class="mr-2">{{ __('You are here:') }}</p>
      <ul class="text-sm">
        <li class="inline after:text-xs after:text-gray-500 after:content-['>']">
          <x-link href="{{ route('settings.index') }}">
            {{ __('Settings') }}
          </x-link>
        </li>
        <li class="inline after:text-xs after:text-gray-500 after:content-['>']">
          <x-link href="{{ route('settings.api.index') }}">
            {{ __('All the API keys') }}
          </x-link>
        </li>
        <li class="inline">
          {{ __('API') }}
        </li>
      </ul>
    </div>
  </x-slot>

  <div class="mx-auto mt-16 max-w-2xl px-4 sm:px-0">
    <div class="rounded-lg bg-white shadow dark:bg-gray-800">
      <header class="rounded-t-lg border-b border-gray-200 bg-blue-50 p-3 dark:border-gray-700 dark:bg-blue-900">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
          {{ __('Add a new API key to your account') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
          {{ __('This will let you access all your data through the API, in a programmatic way.') }}
        </p>
      </header>

      <form method="post" action="{{ route('settings.api.store') }}" class="">
        @csrf
        @method('post')

        <div class="border-b border-gray-200 p-4 dark:border-gray-700">
          <x-input-label for="token_name" :value="__('Give this key a descriptive name')" />
          <x-text-input id="token_name" name="token_name" type="text" class="mt-1 block w-full" autofocus required />
          <x-input-error :messages="$errors->get('token_name')" class="mt-2" />
        </div>

        <div class="flex justify-between p-5">
          <x-button.secondary href="{{ route('settings.api.index') }}">
            {{ __('Cancel') }}
          </x-button.secondary>

          <x-button.primary dusk="submit-form-button">
            {{ __('Create') }}
          </x-button.primary>
        </div>
      </form>
    </div>
  </div>
</x-app-layout>
