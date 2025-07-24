<?php
//
// @var array $quote (not used here, but for consistency)
//
?>

<x-guest-layout>
  <div class="grid min-h-screen w-screen grid-cols-1 lg:grid-cols-2">
    <!-- Left side - 2FA form -->
    <div class="mx-auto flex w-full max-w-2xl flex-1 flex-col justify-center px-5 py-10 sm:px-30">
      <div class="w-full">
        @if (config('peopleos.show_marketing_site'))
          <p class="group mb-10 flex items-center gap-x-1 text-sm text-gray-600">
            <x-lucide-arrow-left class="h-4 w-4 transition-transform duration-150 group-hover:-translate-x-1" />
            <a href="{{ route('marketing.index') }}" class="group-hover:underline">Back to the marketing website</a>
          </p>
        @endif

        <div class="mb-8 flex items-center gap-x-2">
          <a href="/" class="group flex items-center gap-x-2 transition-transform ease-in-out">
            <div class="flex h-7 w-7 items-center justify-center transition-all duration-400 group-hover:-translate-y-0.5 group-hover:-rotate-3">
              <x-image src="{{ asset('marketing/logo.webp') }}" alt="PeopleOS logo" width="25" height="25" srcset="{{ asset('marketing/logo.webp') }} 1x, {{ asset('marketing/logo@2x.webp') }} 2x" />
            </div>
          </a>
          <h1 class="text-2xl font-semibold text-gray-900">
            {{ __('Two-Factor Authentication') }}
          </h1>
        </div>

        <div class="mt-6 mb-12 w-full overflow-hidden rounded-lg bg-white p-4 shadow-md sm:max-w-md dark:bg-gray-900">
          <form method="POST" action="{{ route('2fa.challenge') }}">
            @csrf
            <div>
              <label for="code" class="mb-2 block text-sm font-medium text-gray-700">{{ __('Enter your 2FA code') }}</label>
              <input id="code" name="code" type="text" required autofocus class="block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-200" autocomplete="one-time-code" />
              @error('code')
                <span class="text-sm text-red-600">{{ $message }}</span>
              @enderror
            </div>
            <div class="mt-6 flex items-center justify-between">
              <button type="submit" class="w-full rounded bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700">
                {{ __('Verify') }}
              </button>
            </div>
          </form>
        </div>

        <!-- Register link -->
        <div class="mb-8 rounded-md border border-gray-200 bg-white p-4 text-center text-sm text-gray-600">
          {{ __('New to PeopleOS?') }}
          <x-link :href="route('register')" class="ml-1">
            {{ __('Create an account') }}
          </x-link>
        </div>

        <ul class="text-xs text-gray-600">
          <li>© PeopleOS {{ now()->format('Y') }}</li>
        </ul>
      </div>
    </div>
    <!-- Right side - Illustration (optional, blank for now) -->
    <div class="login-image relative hidden lg:block">
      <!-- You can add a 2FA-related illustration here if desired -->
    </div>
  </div>
</x-guest-layout>
