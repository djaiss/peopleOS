<x-app-layout>
  <x-slot name="breadcrumb">
    <div class="flex text-sm">
      <p class="mr-2">{{ __('You are here:') }}</p>
      <ul class="text-sm">
        <li class="inline after:text-xs after:text-gray-500 after:content-['>']">
          <x-link hover href="{{ route('settings.index') }}">
            {{ __('Settings') }}
          </x-link>
        </li>
        <li class="inline after:text-xs after:text-gray-500 after:content-['>']">
          <x-link hover href="{{ route('settings.api.index') }}">
            {{ __('All the API keys') }}
          </x-link>
        </li>
        <li class="inline">
          {{ __('API') }}
        </li>
      </ul>
    </div>
  </x-slot>

  <main class="relative mt-16 sm:mt-24">
    <div class="mx-auto max-w-lg px-2 py-2 sm:py-6">
      <form action="{{ route('settings.api.store') }}" method="post" class="mb-6 overflow-hidden rounded-lg border border-gray-200 bg-white shadow-md dark:border-gray-700 dark:bg-gray-800">
        @csrf
        @method('post')

        <div class="rounded-t-lg border-b border-gray-200 bg-slate-200 p-3 sm:p-5 dark:border-gray-700 dark:bg-blue-900">
          <h1 class="mb-1 flex justify-center text-2xl font-medium">
            <span>{{ __('Add a new API key to your account') }}</span>
          </h1>
          <p class="text-center text-sm">
            {{ __('This will let you access all your data through the API, in a programmatic way.') }}
          </p>
        </div>

        <div class="border-b border-gray-200 p-4 dark:border-gray-700">
          <x-input-label for="token_name" :value="__('Give this key a descriptive name')" />
          <x-text-input id="token_name" name="token_name" type="text" class="mt-1 block w-full" autofocus required />
          <x-input-error :messages="$errors->get('token_name')" class="mt-2" />
        </div>

        <div class="flex justify-between p-5">
          <x-button.secondary navigate href="{{ route('settings.api.index') }}">
            {{ __('Cancel') }}
          </x-button.secondary>

          <x-button.primary dusk="submit-form-button">
            {{ __('Create') }}
          </x-button.primary>
        </div>
      </form>
    </div>
  </main>
</x-app-layout>
