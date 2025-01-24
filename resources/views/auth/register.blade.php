<x-guest-layout>
  <div class="mt-6 mb-12 w-full overflow-hidden bg-white shadow-md sm:max-w-md sm:rounded-lg dark:bg-gray-900">
    <div class="px-6 pt-6">
      <p class="mb-2 text-lg font-bold">{{ __('Sign up for an account') }}</p>
      <p class="text-sm text-gray-500">{{ __('You will be the administrator of this account.') }}</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="border-b border-gray-200 px-6 pt-6 pb-3">
      @csrf

      <!-- Name -->
      <div class="flex gap-4">
        <div class="mb-4">
          <x-input-label for="first_name" :value="__('First name')" />
          <x-text-input id="first_name" class="block w-full" type="text" name="first_name" :value="old('first_name')" required autofocus autocomplete="first_name" />
          <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
        </div>

        <div class="mb-4">
          <x-input-label for="last_name" :value="__('Last name')" />
          <x-text-input id="last_name" class="block w-full" type="text" name="last_name" :value="old('last_name')" required autofocus autocomplete="last_name" />
          <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
        </div>
      </div>

      <!-- Email Address -->
      <div class="mb-4">
        <x-input-label for="email" :value="__('Email')" />
        <x-text-input id="email" class="block w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
        <x-help>{{ __('We will never, ever send you marketing emails.') }}</x-help>
      </div>

      <!-- Password -->
      <div class="flex gap-4">
        <div class="mb-4">
          <x-input-label for="password" :value="__('Password')" />
          <x-text-input id="password" class="block w-full" type="password" name="password" required autocomplete="password" passwordrules="minlength: 20; required: lower; required: upper; required: digit; required: [-];" />
          <x-input-error :messages="$errors->get('password')" class="mt-2" />
          <x-help>{{ __('Mininum 3 characters.') }}</x-help>
        </div>

        <!-- Confirm Password -->
        <div class="mb-4">
          <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
          <x-text-input id="password_confirmation" class="block w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
          <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>
      </div>

      <div class="flex items-center">
        <x-button.primary class="w-full">
          {{ __('Register') }}
        </x-button.primary>
      </div>
    </form>

    <div class="px-6 py-3 text-center">
      <x-link href="{{ route('login') }}">
        {{ __('Already registered? Sign in instead.') }}
      </x-link>
    </div>
  </div>
</x-guest-layout>
