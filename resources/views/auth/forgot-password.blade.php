<x-guest-layout>
  <div class="min-h-screen w-screen">
    <div class="mx-auto flex w-full max-w-xl flex-1 flex-col justify-center px-5 py-10 sm:px-6">
      <div class="w-full">
        <p class="group mb-10 flex items-center gap-x-1 text-sm text-gray-600">
          <x-lucide-arrow-left class="h-4 w-4 transition-transform duration-150 group-hover:-translate-x-1" />
          <a href="{{ route('login') }}" class="group-hover:underline">Back to login</a>
        </p>

        <!-- Title -->
        <div class="mb-8">
          <h1 class="text-2xl font-semibold text-gray-900">
            {{ __('Forgot your password?') }}
          </h1>
          <p class="mt-2 text-sm text-gray-500">
            {{ __('No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
          </p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Password Reset Form -->
        <div class="mt-6 mb-12 w-full overflow-hidden rounded-lg bg-white p-6 shadow-md dark:bg-gray-900">
          <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div class="mb-4">
              <x-input-label for="email" :value="__('Email')" class="mb-2" />
              <x-text-input id="email" class="block w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
              <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="mt-6">
              <x-button.primary class="w-full">
                {{ __('Email Password Reset Link') }}
              </x-button.primary>
            </div>
          </form>
        </div>

        <!-- Login Link -->
        <div class="mb-8 rounded-md border border-gray-200 bg-white p-4 text-center text-sm text-gray-600">
          {{ __('Remember your password?') }}
          <x-link :href="route('login')" class="ml-1">
            {{ __('Back to login') }}
          </x-link>
        </div>

        <ul class="text-xs text-gray-600">
          <li>© PeopleOS 2025</li>
        </ul>
      </div>
    </div>
  </div>
</x-guest-layout>
