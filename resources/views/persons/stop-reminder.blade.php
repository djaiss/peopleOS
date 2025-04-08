<?php
/*
 * @var string $name
 * @var string $occasion
 */
?>

<x-guest-layout>
  <div class="min-h-screen w-screen">
    <div class="mx-auto flex w-full max-w-xl flex-1 flex-col justify-center px-5 py-10 sm:px-6">
      <div class="w-full">
        <p class="group mb-10 flex items-center gap-x-1 text-sm text-gray-600">
          <x-lucide-arrow-left class="h-4 w-4 transition-transform duration-150 group-hover:-translate-x-1" />
          <a href="{{ route('login') }}" class="group-hover:underline">Back to login</a>
        </p>

        <!-- logo -->
        <div class="mb-10 flex justify-center">
          <a href="{{ route('dashboard.index') }}" class="group flex items-center gap-x-2 transition-transform ease-in-out">
            <div class="flex h-7 w-7 items-center justify-center transition-all duration-400 group-hover:-translate-y-0.5 group-hover:-rotate-3">
              <img src="{{ asset('marketing/logo.png') }}" alt="PeopleOS logo" width="25" height="25" srcset="{{ asset('marketing/logo.png') }} 1x, {{ asset('marketing/logo@2x.png') }} 2x" />
            </div>
            <span class="text-lg font-semibold text-gray-900 dark:text-white">{{ config('app.name') }}</span>
          </a>
        </div>

        <!-- Title -->
        <div class="mb-8 rounded-lg bg-white p-6 shadow-md">
          <h1 class="mb-4 text-2xl font-semibold text-gray-900">
            {{ __('You will not receive reminders anymore.') }}
          </h1>
          <p class="mb-4 text-sm text-gray-500">
            {{ __('Details of this event:') }}
          </p>
          <ul class="mb-4">
            <li class="pl-2">{{ __('Person: :name', ['name' => $name]) }}</li>
            <li class="pl-2">{{ __('Occasion: :occasion', ['occasion' => $occasion]) }}</li>
          </ul>

          <h2>Have a wonderful day.</h2>
        </div>
      </div>
    </div>
  </div>
</x-guest-layout>
