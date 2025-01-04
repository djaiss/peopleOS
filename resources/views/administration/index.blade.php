<?php
/**
 * @var \App\Models\User $user
 */
?>

<x-app-layout>
  <div class="grid h-[calc(100vh-48px)] grid-cols-1 lg:grid-cols-[240px,1fr]">
    <div class="border-r border-gray-300 bg-gray-100">
      <div class="flex flex-col px-6 pt-8">
        <!-- back to dashboard -->
        <a href="{{ route('dashboard') }}" class="mb-4">
          <div class="flex h-8 items-center justify-between gap-3 rounded-lg px-2 text-sm leading-5 text-zinc-600 hover:bg-zinc-950/5 hover:text-zinc-800 dark:text-zinc-400 dark:hover:bg-white/5 dark:hover:text-white">
            <div class="flex items-center gap-2">
              <x-lucide-chevron-left class="size-3 min-w-3" />
              <span>
                {{ __('Back to dashboard') }}
              </span>
            </div>
          </div>
        </a>

        <div class="flex flex-col gap-4">
          <div class="flex flex-col gap-0.5">
            <span class="tpx-2 py-1.5 text-xs font-semibold text-zinc-950/40 dark:text-white/40">
              {{ __('Your account') }}
            </span>
            <a href="{{ route('administration.index') }}">
              <div class="{{ request()->routeIs('administration.index') ? 'text-green-600 hover:bg-green-600/5 dark:text-green-500 dark:hover:bg-green-500/5' : 'text-zinc-600 hover:bg-zinc-950/5 hover:text-zinc-800 dark:text-zinc-400' }} flex h-8 items-center justify-between gap-3 rounded-lg px-2 text-sm leading-5 dark:hover:bg-white/5 dark:hover:text-white">
                <div class="flex items-center gap-2">
                  <x-lucide-user class="size-4 min-w-3" />
                  <span>
                    {{ __('Profile') }}
                  </span>
                </div>
              </div>
            </a>
            <a href="">
              <div class="flex h-8 items-center justify-between gap-3 rounded-lg px-2 text-sm leading-5 text-zinc-600 hover:bg-zinc-950/5 hover:text-zinc-800 dark:text-zinc-400 dark:hover:bg-white/5 dark:hover:text-white">
                <div class="flex items-center gap-2">
                  <x-lucide-shield-alert class="size-4 min-w-3" />
                  <span>
                    {{ __('Security') }}
                  </span>
                </div>
              </div>
            </a>
            <a href="">
              <div class="flex h-8 items-center justify-between gap-3 rounded-lg px-2 text-sm leading-5 text-zinc-600 hover:bg-zinc-950/5 hover:text-zinc-800 dark:text-zinc-400 dark:hover:bg-white/5 dark:hover:text-white">
                <div class="flex items-center gap-2">
                  <x-lucide-key class="size-4 min-w-3" />
                  <span>
                    {{ __('Api tokens') }}
                  </span>
                </div>
              </div>
            </a>
          </div>
        </div>
      </div>
    </div>

    <div class="relative bg-gray-50 px-6 pt-8 lg:px-12">
      <div class="mx-auto max-w-2xl px-2 py-2 sm:px-0">
        <h1 class="font-semi-bold mb-4 text-xl">
          {{ __('Profile') }}
        </h1>

        <form class="border border-gray-200 bg-white sm:rounded-lg" x-data="{ showActions: false }" action="{{ route('administration.update') }}" method="POST">
          @csrf
          @method('PUT')

          <!-- profile photo -->
          <div class="grid grid-cols-3 items-center border-b border-gray-200 p-3">
            <x-input-label for="profile_photo_path" :value="__('Profile photo')" class="col-span-2" />
            <div class="justify-self-end">
              <img class="h-8 w-8 rounded-full object-cover p-[0.1875rem] shadow ring-1 ring-slate-900/10" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
            </div>
          </div>

          <!-- first name -->
          <div class="grid grid-cols-3 items-center border-b border-gray-200 p-3">
            <x-input-label for="first_name" :value="__('First name')" class="col-span-2" />
            <div class="w-full justify-self-end">
              <x-text-input class="block w-full" id="first_name" name="first_name" value="{{ $user->first_name }}" type="text" required @focus="showActions = true" @blur="showActions = false" />
              <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
            </div>
          </div>

          <!-- last name -->
          <div class="grid grid-cols-3 items-center border-b border-gray-200 p-3">
            <x-input-label for="last_name" :value="__('Last name')" class="col-span-2" />
            <div class="w-full justify-self-end">
              <x-text-input class="block w-full" id="last_name" name="last_name" value="{{ $user->last_name }}" type="text" required @focus="showActions = true" @blur="showActions = false" />
              <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
            </div>
          </div>

          <!-- email -->
          <div class="grid grid-cols-3 items-center p-3">
            <div class="col-span-2">
              <x-input-label for="email" :value="__('Email')" />
              <x-help>{{ __('We will send you an email to verify this email address, and won\'t use this email for marketing purposes.') }}</x-help>
            </div>

            <div class="w-full justify-self-end">
              <x-text-input class="block w-full" id="email" name="email" value="{{ $user->email }}" type="email" required @focus="showActions = true" @blur="showActions = false" />
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
      </div>
    </div>
  </div>
</x-app-layout>
