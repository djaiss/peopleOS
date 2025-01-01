<x-app-layout>
  <!-- breadcrumb -->
  <x-slot name="breadcrumb">
    <div class="flex text-sm">
      <p class="mr-2">{{ __('You are here:') }}</p>
      <ul>
        <li class="inline after:text-xs after:text-gray-500 after:content-['>']">
          <x-link href="{{ route('settings.index') }}">
            {{ __('Settings') }}
          </x-link>
        </li>
        <li class="inline after:text-xs after:text-gray-500 after:content-['>']">
          <x-link href="{{ route('settings.templates.index') }}">
            {{ __('Templates') }}
          </x-link>
        </li>
        <li class="inline">
          {{ __('New template') }}
        </li>
      </ul>
    </div>
  </x-slot>

  <main class="relative mt-16 sm:mt-24">
    <div class="mx-auto max-w-lg px-2 py-2 sm:py-6">
      <form action="{{ route('vaults.store') }}" method="post" class="mb-6 overflow-hidden rounded-lg border border-gray-200 bg-white shadow-md dark:border-gray-700 dark:bg-gray-800">
        @csrf
        @method('post')

        <div class="rounded-t-lg border-b border-gray-200 bg-slate-200 p-3 sm:p-5 dark:border-gray-700 dark:bg-blue-900">
          <h1 class="mb-1 flex justify-center text-2xl font-medium">
            <span>{{ __('Create a template') }}</span>
          </h1>
          <p class="text-center text-sm">
            {{ __('Templates are used to structure your journal entries. As of now, a template is a YAML file.') }}
          </p>
        </div>

        <div class="border-b border-gray-200 px-5 dark:border-gray-700">
          <!-- name -->
          <div class="relative py-4">
            <x-input-label for="name" :value="__('Name')" />

            <x-text-input class="mt-1 block w-full" id="name" name="name" type="text" required autofocus />

            <x-input-error class="mt-2" :messages="$errors->get('name')" />
          </div>

          <!-- description -->
          <div class="relative pb-4 pt-2">
            <x-input-label for="content" :value="__('Content (must be valid YAML)')" />

            <x-textarea id="content" name="content" :height="'min-h-[400px]'" class="mt-2 block w-full" type="text">{{ old('content') }}</x-textarea>

            <x-input-error class="mt-2" :messages="$errors->get('content')" />
          </div>
        </div>

        <div class="flex items-center justify-between rounded-b-lg bg-gray-50 px-6 py-4">
          <x-button.secondary hover href="{{ route('settings.templates.index') }}">
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
