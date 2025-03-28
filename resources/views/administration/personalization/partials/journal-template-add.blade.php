<?php
/*
 * @var array $genders
 * @var array $taskCategories
 */
?>

<x-app-layout>
  <div class="grid h-[calc(100vh-48px)] grid-cols-1 lg:grid-cols-[240px_1fr]">
    <!-- sidebar -->
    @include('administration.partials.sidebar')

    <!-- main content -->
    <div class="relative bg-gray-50 px-6 pt-8 lg:px-12">
      <div class="mx-auto max-w-5xl px-2 py-2 sm:px-0">
        <form action="{{ route('administration.personalization.journal-templates.create') }}" method="POST" class="grid grid-rows-2 gap-4 sm:grid-cols-6 sm:grid-rows-1">
          @csrf

          <!-- left column -->
          <div class="col-span-6 overflow-hidden rounded-md border border-gray-200 bg-white sm:col-start-1 sm:col-end-6 sm:rounded-lg dark:bg-gray-800">
            <div class="border-b border-gray-200 bg-white p-6 lg:p-8 dark:border-gray-700 dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent">
              <h1 class="mb-2 text-xl font-medium text-gray-900 dark:text-white">{{ __('Add a new journal template') }}</h1>

              <p class="text-gray-500 dark:text-gray-400">{{ __('Think of journal templates as a way to structure journal entries.') }}</p>
            </div>

            <div class="p-6">
              <x-input-error :messages="$errors->get('name')" class="mt-2" />
              <x-input-error :messages="$errors->get('content')" class="mt-2" />

              <x-input-label for="name" :value="__('Name')" class="mb-1" />
              <x-text-input id="name" class="mt-1 mb-4" type="text" name="name" required />

              <x-input-label for="content" :value="__('Content')" class="mb-1" />
              <x-textarea id="content" name="content" class="w-full" :height="'min-h-[600px]'" required />
              <p class="mt-1 text-xs text-gray-600">{{ __('This should be a valid YAML file.') }}</p>
            </div>
          </div>

          <!-- right column -->
          <div class="col-span-6 sm:col-span-1">
            <div class="flex flex-col items-center space-y-4">
              <x-button.primary class="w-full">
                {{ __('Save') }}
              </x-button.primary>

              <x-button.secondary class="w-full text-center">
                {{ __('Cancel') }}
              </x-button.secondary>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</x-app-layout>
