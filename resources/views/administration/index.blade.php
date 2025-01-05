<?php
/**
 * @var array $user
 * @var array $logs
 * @var bool $has_more_logs
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

        <form action="{{ route('administration.update') }}" method="POST" class="mb-8 border border-gray-200 bg-white sm:rounded-lg" x-data="{ showActions: false }">
          @csrf
          @method('PUT')

          <!-- profile photo -->
          <div class="grid grid-cols-3 items-center rounded-t-lg border-b border-gray-200 p-3 hover:bg-blue-50">
            <x-input-label for="profile_photo_path" :value="__('Profile photo')" class="col-span-2" />
            <div class="justify-self-end">
              <img class="h-8 w-8 rounded-full object-cover p-[0.1875rem] shadow ring-1 ring-slate-900/10" src="{{ $user['profile_photo_url'] }}" alt="{{ $user['name'] }}" />
            </div>
          </div>

          <!-- first name -->
          <div class="grid grid-cols-3 items-center border-b border-gray-200 p-3 hover:bg-blue-50">
            <x-input-label for="first_name" :value="__('First name')" class="col-span-2" />
            <div class="w-full justify-self-end">
              <x-text-input class="block w-full" id="first_name" name="first_name" value="{{ $user['first_name'] }}" type="text" required @focus="showActions = true" @blur="showActions = false" />
              <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
            </div>
          </div>

          <!-- last name -->
          <div class="grid grid-cols-3 items-center border-b border-gray-200 p-3 hover:bg-blue-50">
            <x-input-label for="last_name" :value="__('Last name')" class="col-span-2" />
            <div class="w-full justify-self-end">
              <x-text-input class="block w-full" id="last_name" name="last_name" value="{{ $user['last_name'] }}" type="text" required @focus="showActions = true" @blur="showActions = false" />
              <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
            </div>
          </div>

          <!-- nickname -->
          <div class="grid grid-cols-3 items-center border-b border-gray-200 p-3 hover:bg-blue-50">
            <x-input-label for="nickname" :value="__('Nickname')" class="col-span-2" />
            <div class="w-full justify-self-end">
              <x-text-input class="block w-full [&:placeholder-shown]:bg-gray-50" id="nickname" name="nickname" value="{{ $user['nickname'] }}" type="text" placeholder="{{ __('No nickname defined') }}" @focus="showActions = true" @blur="showActions = false" />
              <x-input-error class="mt-2" :messages="$errors->get('nickname')" />
            </div>
          </div>

          <!-- email -->
          <div class="grid grid-cols-3 items-center p-3 hover:bg-blue-50">
            <div class="col-span-2">
              <x-input-label for="email" :value="__('Email')" />
              <x-help>{{ __('We will send you an email to verify this email address, and won\'t use this email for marketing purposes.') }}</x-help>
            </div>

            <div class="w-full justify-self-end">
              <x-text-input class="block w-full" id="email" name="email" value="{{ $user['email'] }}" type="email" required @focus="showActions = true" @blur="showActions = false" />
              <x-input-error class="mt-2" :messages="$errors->get('email')" />
            </div>
          </div>

          <div x-cloak x-show="showActions" x-transition:enter="transition duration-200 ease-out" x-transition:enter-start="-translate-y-2 transform opacity-0" x-transition:enter-end="translate-y-0 transform opacity-100" x-transition:leave="transition duration-150 ease-in" x-transition:leave-start="translate-y-0 transform opacity-100" x-transition:leave-end="-translate-y-2 transform opacity-0" class="flex justify-between border-t border-gray-200 p-3">
            <x-button.secondary wire:click="toggleAddMode" class="mr-2">
              {{ __('Cancel') }}
            </x-button.secondary>

            <x-button.primary>
              {{ __('Save') }}
            </x-button.primary>
          </div>
        </form>

        <!-- Preferences -->
        <h2 class="font-semi-bold mb-4 text-lg">
          {{ __('Preferences') }}
        </h2>

        <div class="mb-8 border border-gray-200 bg-white sm:rounded-lg">
          <div class="grid grid-cols-3 items-center rounded-lg p-3 hover:bg-blue-50">
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
        </div>

        <!-- Last activity -->
        <h2 class="font-semi-bold mb-4 text-lg">
          {{ __('Last activity') }}
        </h2>

        <div class="mb-8 border border-gray-200 bg-white sm:rounded-lg">
          <!-- last actions -->
          @foreach ($logs as $log)
            <div class="flex items-center justify-between border-b border-gray-200 p-3 text-sm first:rounded-t-lg last:rounded-b-lg last:border-b-0 hover:bg-blue-50">
              <div class="flex items-center gap-3">
                <x-lucide-activity class="size-3 min-w-3 text-zinc-600 dark:text-zinc-400" />
                <div class="">
                  <p class="flex items-center gap-1">
                    <span class="">{{ $log['user']['name'] }}</span>
                    |
                    <span class="font-mono text-xs">{{ $log['action'] }}</span>
                  </p>
                  <p>{{ $log['description'] }}</p>
                </div>
              </div>

              <p class="font-mono text-xs">{{ $log['created_at'] }}</p>
            </div>
          @endforeach

          @if ($has_more_logs)
            <div class="flex justify-center rounded-b-lg p-3 text-sm hover:bg-blue-50">
              <x-link class="text-center">Browse all activity</x-link>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
