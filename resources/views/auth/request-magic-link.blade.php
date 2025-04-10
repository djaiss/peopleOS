<x-guest-layout>
  <div class="min-h-screen w-screen">
    <div class="mx-auto flex w-full max-w-md flex-1 flex-col justify-center px-5 py-10 sm:px-6">
      <div class="w-full">
        <!-- Title -->
        <div class="mb-8 flex items-center gap-x-2">
          <div>
            <h1 class="text-2xl font-semibold text-gray-900">
              {{ __('Receive a link to login') }}
            </h1>
            <p class="mt-2 text-sm text-gray-500">
              {{ __('Enter your email below and we will send you a link to magically connect to your account.') }}
            </p>
          </div>
        </div>

        <!-- Session status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <div class="mt-6 mb-12 w-full overflow-hidden rounded-lg bg-white p-6 shadow-md dark:bg-gray-900">
          <form method="POST" action="{{ route('magic.link.store') }}">
            @csrf

            <!-- Email address -->
            <div class="mb-4">
              <x-input-label for="email" :value="__('Email')" class="mb-2" />
              <x-text-input id="email" class="block w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
              <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="mt-6">
              <x-button.primary class="w-full">
                {{ __('Email me a link to login') }}
              </x-button.primary>
            </div>
          </form>
        </div>

        <!-- Login link -->
        <div class="mb-8 rounded-md border border-gray-200 bg-white p-4 text-center text-sm text-gray-600">
          {{ __('Want to use your password instead?') }}
          <x-link :href="route('login')" class="ml-1">
            {{ __('Back to login') }}
          </x-link>
        </div>

        <ul class="text-xs text-gray-600">
          <li>© PeopleOS {{ now()->format('Y') }}</li>
        </ul>
      </div>
    </div>
  </div>
</x-guest-layout>
