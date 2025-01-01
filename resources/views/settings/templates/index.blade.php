<?php
/**
 * @var array $templates
 * @var array $routes
 */
?>

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
        <li class="inline">
          {{ __('Templates') }}
        </li>
      </ul>
    </div>
  </x-slot>

  <main class="relative sm:mt-10">
    <div class="mx-auto max-w-7xl px-2 py-2 sm:px-0">
      <div class="hidden space-y-6 pb-16 md:block">
        <div class="space-y-0.5">
          <h2 class="text-2xl font-bold tracking-tight">{{ __('Settings') }}</h2>
          <p class="">{{ __('Manage your account settings.') }}</p>
        </div>

        <div class="flex flex-col space-y-8 bg-white shadow sm:rounded-lg lg:flex-row lg:space-x-12 lg:space-y-0">
          <aside class="px-4 lg:w-1/5">
            @include('settings.partials.navigation')
          </aside>
          <div class="flex-1 py-3 lg:max-w-2xl">
            <div class="space-y-6">
              <div class="border-b border-gray-200 pb-4">
                <h3 class="text-lg font-medium">{{ __('Journal templates') }}</h3>
                <p class="text-sm"></p>
                <div class="flex items-center justify-between">
                  <p class="text-sm text-gray-500">{{ __('Day entries in your journal will follow the structure of the template you select. There must be at least one template in your account for journals to work.') }}</p>

                  <x-button.secondary href="{{ $routes['template']['new'] }}" class="flex-shrink-0">
                    <span>{{ __('New template') }}</span>
                  </x-button.secondary>
                </div>
              </div>
              <div class="space-y-6">
                <div class="mb-4 rounded-lg border border-gray-200">
                  @forelse ($templates as $template)
                    <div class="flex border-b border-b-gray-200 py-2 last:border-b-0 hover:bg-blue-50 first:hover:rounded-t-lg last:hover:rounded-b-lg sm:flex-row sm:items-center sm:justify-between sm:px-3 dark:hover:bg-gray-600">
                      <div class="flex items-center">
                        <p>{{ $template['name'] }}</p>
                      </div>

                      <div x-data="{ dropdownOpen: false }" class="relative">
                        <button @click="dropdownOpen=true" class="inline-flex items-center justify-center rounded-md border bg-white px-3 py-2 text-sm font-medium text-neutral-700 transition-colors hover:bg-neutral-100 focus:bg-white focus:outline-none active:bg-white disabled:pointer-events-none disabled:opacity-50">
                          <span class="mr-2">{{ __('Options') }}</span>
                          <x-lucide-chevron-down class="h-4 w-4 text-gray-500" />
                        </button>

                        <div x-show="dropdownOpen" @click.away="dropdownOpen=false" x-transition:enter="duration-200 ease-out" x-transition:enter-start="-translate-y-2" x-transition:enter-end="translate-y-0" class="absolute -top-3 left-1/2 z-50 mt-12 w-56 -translate-x-1/2" x-cloak>
                          <div class="mt-1 rounded-md border border-neutral-200/70 bg-white p-1 text-neutral-700 shadow-md">
                            <span wire:click="toggleEditMode({{ $template['id'] }})" class="relative flex cursor-default select-none items-center rounded px-2 py-1.5 text-sm outline-none transition-colors hover:bg-neutral-100 data-[disabled]:pointer-events-none data-[disabled]:opacity-50">
                              <x-lucide-pencil class="mr-2 h-4 w-4 text-gray-600" />
                              <span>{{ __('Edit') }}</span>
                            </span>
                            <span wire:click="delete({{ $template['id'] }})" wire:confirm="{{ __('Are you sure you want to proceed? This can not be undone.') }}" class="relative flex cursor-default select-none items-center rounded px-2 py-1.5 text-sm outline-none transition-colors hover:bg-neutral-100 data-[disabled]:pointer-events-none data-[disabled]:opacity-50">
                              <x-lucide-trash-2 class="mr-2 h-4 w-4 text-gray-600" />
                              <span>{{ __('Delete') }}</span>
                            </span>
                          </div>
                        </div>
                      </div>
                    </div>
                  @empty
                    <div id="blank-state" class="flex flex-col items-center rounded-lg bg-white p-6">
                      <div class="mb-5 rounded-full bg-slate-100 p-4">
                        <x-lucide-file-text class="h-6 w-6 text-gray-500" />
                      </div>

                      <p class="text-center">{{ __('Templates are used to structure your journal entries.') }}</p>
                    </div>
                  @endforelse
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</x-app-layout>
