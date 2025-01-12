<?php
/**
 * @var array $user
 */
?>

<x-app-layout>
  <div class="grid h-[calc(100vh-48px)] grid-cols-1 lg:grid-cols-[240px,1fr]">
    <!-- sidebar -->
    @include('administration.partials.sidebar')

    <!-- main content -->
    <div class="relative bg-gray-50 px-6 pt-8 lg:px-12">
      <div class="mx-auto max-w-2xl px-2 py-2 sm:px-0">
        <!-- Profile -->
        <h1 class="font-semi-bold mb-4 text-2xl">
          {{ __('Profile') }}
        </h1>

        <livewire:administration.manage-profile />

        <!-- Profile photo -->
        <h2 class="font-semi-bold mb-1 text-lg">{{ __('Profile photo') }}</h2>
        <p class="mb-4 text-sm text-zinc-500">{{ __('You can upload a profile photo to use as your avatar, or use the default avatar.') }}</p>

        <livewire:administration.manage-avatar />

        <!-- Preferences -->
        <h2 class="font-semi-bold mb-4 text-lg">
          {{ __('Preferences') }}
        </h2>

        <div class="mb-8 border border-gray-200 bg-white sm:rounded-lg">
          <!-- Display full names -->
          <div class="grid grid-cols-3 items-center rounded-t-lg border-b border-gray-200 p-3 hover:bg-blue-50">
            <div class="col-span-2">
              <p class="col-span-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                {{ __('Display full names') }}
              </p>
              <x-help>{{ __('Show full names of users instead of nicknames') }}</x-help>
            </div>

            <div class="justify-self-end">
              <livewire:administration.toggle-display-names :user-id="$user['id']" />
            </div>
          </div>

          <!-- Display age -->
          <div class="grid grid-cols-3 items-center rounded-b-lg p-3 hover:bg-blue-50">
            <div class="col-span-2">
              <p class="col-span-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                {{ __('Display age') }}
              </p>
              <x-help>{{ __('Show your age. If you are not comfortable with this, you can hide it.') }}</x-help>
            </div>

            <div class="justify-self-end">
              <livewire:administration.toggle-birthdate />
            </div>
          </div>
        </div>

        <!-- Last activity -->
        <h2 class="font-semi-bold mb-4 text-lg">
          {{ __('Last activity') }}
        </h2>

        <livewire:administration.list-logs lazy />
      </div>
    </div>
  </div>
</x-app-layout>
