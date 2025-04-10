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
            {{ __('Reset password') }}
          </h1>
          <p class="mt-2 text-sm text-gray-500">
            {{ __('Enter your new password below to complete the password reset process.') }}
          </p>
        </div>

        <!-- Password reset form -->
        <div class="mt-6 mb-12 w-full overflow-hidden rounded-lg bg-white p-6 shadow-md dark:bg-gray-900">
          <form method="POST" action="{{ route('password.store') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}" />

            <!-- Email address -->
            <div class="mb-4">
              <x-input-label for="email" :value="__('Email')" class="mb-2" />
              <x-text-input id="email" class="block w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
              <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mb-4">
              <x-input-label for="password" :value="__('Password')" class="mb-2" />
              <x-text-input id="password" class="block w-full" type="password" name="password" required autocomplete="new-password" passwordrules="minlength: 20; required: lower; required: upper; required: digit; required: [-];" />
              <x-input-error :messages="$errors->get('password')" class="mt-2" />
              <x-help>{{ __('Mininum 3 characters.') }}</x-help>
            </div>

            <!-- Confirm password -->
            <div class="mb-4">
              <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="mb-2" />
              <x-text-input id="password_confirmation" class="block w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
              <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="mt-6">
              <x-button.primary class="w-full">
                {{ __('Reset Password') }}
              </x-button.primary>
            </div>
          </form>
        </div>

        <!-- Login link -->
        <div class="mb-8 rounded-md border border-gray-200 bg-white p-4 text-center text-sm text-gray-600">
          {{ __('Remember your password?') }}
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
