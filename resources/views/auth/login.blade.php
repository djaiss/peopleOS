<x-guest-layout>
  <!-- Session Status -->
  <x-auth-session-status class="mb-4" :status="session('status')" />

  <div class="mb-12 mt-6 flex w-full flex-col overflow-hidden rounded-lg bg-white shadow-md sm:max-w-4xl md:flex-row dark:bg-gray-800">

    <div class="w-full">
      <!-- title -->
      <div class="border-b border-gray-200 px-6 pb-6 pt-8 dark:border-gray-700">
        <h1 class="text-center text-xl text-gray-800 dark:text-gray-200">
          <span class="me-2">👋</span>
          {{ __('Sign in to your account') }}
        </h1>
      </div>

      <!-- form -->
      <form method="POST" action="{{ route('login') }}" class="border-b border-gray-200 px-6 pb-6 pt-8">
        @csrf

        <!-- Email Address -->
        <div>
          <x-input-label for="email" :value="__('Email')" />
          <x-text-input id="email" class="block w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
          <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
          <x-input-label for="password" :value="__('Password')" />

          <x-text-input id="password" class="block w-full" type="password" name="password" required autocomplete="current-password" />

          <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="mt-4 block">
          <label for="remember_me" class="inline-flex items-center">
            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember" />
            <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">
              {{ __('Remember me') }}
            </span>
          </label>
        </div>

        <div class="mt-4 flex items-center justify-end">
          @if (Route::has('password.request'))
            <x-link href="{{ route('password.request') }}" class="mr-3">{{ __('Forgot your password?') }}</x-link>
          @endif

          <x-button.primary class="ms-3">
            {{ __('Log in') }}
          </x-button.primary>
        </div>
      </form>

      <!-- register -->
      <div class="px-6 py-6 text-sm dark:text-gray-50">
        {{ __('New to Monica?') }}

        <x-link :href="route('register')">
          {{ __('Create an account') }}
        </x-link>
      </div>
    </div>
  </div>
</x-guest-layout>
