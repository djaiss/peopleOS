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
          {{ __('Account information') }}
        </h1>

        <form action="{{ route('administration.account.update') }}" method="POST" class="mb-8 border border-gray-200 bg-white sm:rounded-lg" x-data="{ showActions: false }">
          @csrf
          @method('PUT')

          <!-- account logo -->
          <div class="grid grid-cols-3 items-center rounded-t-lg border-b border-gray-200 p-3 hover:bg-blue-50">
            <x-input-label for="logo" :value="__('Logo')" class="col-span-2" />
            <div class="justify-self-end">
              <img class="h-8 w-8 rounded-full object-cover p-[0.1875rem] shadow ring-1 ring-slate-900/10" src="{{ $account['avatar'] }}" alt="{{ $account['name'] }}" />
            </div>
          </div>

          <!-- name -->
          <div class="grid grid-cols-3 items-center p-3 hover:bg-blue-50">
            <x-input-label for="name" :value="__('Name')" class="col-span-2" />
            <div class="w-full justify-self-end">
              <x-text-input class="block w-full" id="name" name="name" value="{{ $account['name'] }}" type="text" required @focus="showActions = true" @blur="showActions = false" data-1p-ignore />
              <x-input-error class="mt-2" :messages="$errors->get('name')" />
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
