<x-guest-layout>
  <div class="mt-6 mb-12 w-full overflow-hidden bg-white px-6 py-6 shadow-md sm:max-w-md sm:rounded-lg dark:bg-gray-900">
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
      {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
      <div class="mb-4 text-sm font-medium text-green-600 dark:text-green-400">
        {{ __('A new verification link has been sent to the email address you provided during registration.') }}
      </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
      <form method="POST" action="{{ route('verification.send') }}">
        @csrf

        <div>
          <x-button.primary>
            {{ __('Resend verification email') }}
          </x-button.primary>
        </div>
      </form>

      <form method="POST" action="{{ route('logout') }}">
        @csrf

        <button type="submit" class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:outline-hidden dark:text-gray-400 dark:hover:text-gray-100 dark:focus:ring-offset-gray-800">
          {{ __('Log out') }}
        </button>
      </form>
    </div>
  </div>
</x-guest-layout>
