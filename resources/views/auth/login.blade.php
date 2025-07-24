<?php
/*
 * @var array $quote
 */
?>

<x-guest-layout>
  <div class="grid min-h-screen w-screen grid-cols-1 lg:grid-cols-2">
    <!-- Left side - Login form -->
    <div class="mx-auto flex w-full max-w-2xl flex-1 flex-col justify-center px-5 py-10 sm:px-30">
      <div class="w-full">
        @if (config('peopleos.show_marketing_site'))
          <p class="group mb-10 flex items-center gap-x-1 text-sm text-gray-600">
            <x-lucide-arrow-left class="h-4 w-4 transition-transform duration-150 group-hover:-translate-x-1" />
            <a href="{{ route('marketing.index') }}" class="group-hover:underline">Back to the marketing website</a>
          </p>
        @endif

        <!-- Session status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Title -->
        <div class="mb-8 flex items-center gap-x-2">
          <a href="{{ route('marketing.index') }}" class="group flex items-center gap-x-2 transition-transform ease-in-out">
            <div class="flex h-7 w-7 items-center justify-center transition-all duration-400 group-hover:-translate-y-0.5 group-hover:-rotate-3">
              <x-image src="{{ asset('marketing/logo.webp') }}" alt="PeopleOS logo" width="25" height="25" srcset="{{ asset('marketing/logo.webp') }} 1x, {{ asset('marketing/logo@2x.webp') }} 2x" />
            </div>
          </a>
          <h1 class="text-2xl font-semibold text-gray-900">
            {{ __('Welcome back') }}
          </h1>
        </div>

        <!-- Login form -->
        <div class="mt-6 mb-12 w-full overflow-hidden rounded-lg bg-white p-4 shadow-md sm:max-w-md dark:bg-gray-900">
          <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email address -->
            <div>
              <x-input-label for="email" :value="__('Email')" class="mb-2" />
              <x-text-input id="email" class="block w-full" type="email" name="email" :value="old('email')" required autofocus :avoidAutofill="false" autocomplete="username" />
              <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
              <x-input-label for="password" :value="__('Password')" class="mb-2" />
              <x-text-input id="password" class="block w-full" type="password" name="password" required :avoidAutofill="false" autocomplete="current-password" />
              <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember me -->
            <div class="mt-4 block">
              <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded-sm border-gray-300 text-indigo-600 shadow-xs focus:ring-indigo-500" name="remember" />
                <span class="ms-2 text-sm text-gray-600">
                  {{ __('Remember me') }}
                </span>
              </label>
            </div>

            @if (config('peopleos.enable_anti_spam'))
              <div class="mt-4 mb-0">
                <x-turnstile data-size="flexible" />

                <x-input-error :messages="$errors->get('cf-turnstile-response')" class="mt-2" />
              </div>
            @endif

            <div class="mt-6 flex items-center justify-between">
              @if (Route::has('password.request'))
                <x-link href="{{ route('password.request') }}" class="text-sm text-gray-600">
                  {{ __('Forgot your password?') }}
                </x-link>
              @endif

              <x-button.primary>
                {{ __('Log in') }}
              </x-button.primary>
            </div>
          </form>
        </div>

        <!-- send me a link -->
        <div class="mb-4 rounded-md border border-gray-200 bg-white p-4 text-center text-sm text-gray-600">
          {{ __('Wanna skip the password?') }}
          <x-link :href="route('magic.link')" class="ml-1">
            {{ __('Send me a link instead') }}
          </x-link>
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

    <!-- Right side - Image -->
    <div class="login-image relative hidden lg:block">
      <!-- Quote Box -->
      <div class="absolute inset-0 flex items-center justify-center">
        <div x-data="{ showDescription: false }" @mouseenter="showDescription = true" @mouseleave="showDescription = false" class="relative rounded-lg border-2 border-white/70 bg-white/90 p-1 shadow-lg backdrop-blur-sm">
          <div class="max-w-lg rounded-lg bg-white/90 p-8 shadow-lg backdrop-blur-sm">
            <p class="mb-4 text-xl font-medium text-gray-900">"{{ $quote['sentence'] }}"</p>

            <div class="flex items-center gap-x-2">
              <x-image src="{{ asset('marketing/quotes/' . $quote['file'] . '.webp') }}" srcset="{{ asset('marketing/quotes/' . $quote['file'] . '.webp') }}, {{ asset('marketing/quotes/' . $quote['file'] . '@2x.webp') }} 2x" height="48" width="48" alt="{{ $quote['character'] }}" class="h-12 w-12 rounded-full border border-gray-200" />
              <div class="flex flex-col gap-y-1">
                <p class="text-sm font-semibold text-gray-600">{{ $quote['character'] }}</p>
                <p class="text-sm text-gray-600">
                  <span class="italic">from</span>
                  {{ $quote['tv_show'] }} ({{ $quote['season_episode'] }})
                </p>
              </div>
            </div>
          </div>

          <!-- Description Popover -->
          <div x-show="showDescription" x-transition:enter="transition duration-200 ease-out" x-transition:enter-start="scale-95 transform opacity-0" x-transition:enter-end="scale-100 transform opacity-100" x-transition:leave="transition duration-100 ease-in" x-transition:leave-start="scale-100 transform opacity-100" x-transition:leave-end="scale-95 transform opacity-0" class="absolute -top-22 left-1/2 z-10 w-72 -translate-x-1/2 rounded-md bg-gray-800 p-4 shadow-lg" style="display: none">
            <div class="relative">
              <!-- Triangle pointer -->
              <div class="absolute -bottom-4 left-1/2 h-4 w-4 -translate-x-1/2 rotate-45 bg-gray-800"></div>
              <p class="text-center text-sm text-white">{{ $quote['description'] }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-guest-layout>
