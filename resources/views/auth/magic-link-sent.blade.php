<x-guest-layout>
  <div class="min-h-screen w-screen">
    <div class="mx-auto flex w-full max-w-xl flex-1 flex-col justify-center px-5 py-10 sm:px-6">
      <div class="w-full">
        <p class="group mb-10 flex items-center gap-x-1 text-sm text-gray-600">
          <x-lucide-arrow-left class="h-4 w-4 transition-transform duration-150 group-hover:-translate-x-1" />
          <a href="{{ route('login') }}" class="group-hover:underline">Back to login</a>
        </p>

        <!-- Password reset form -->
        <div class="mt-6 mb-12 w-full overflow-hidden rounded-lg bg-white p-6 shadow-md dark:bg-gray-900">
          <p>We've sent you a temporary login link. This link is valid for 5 minutes. Please check your inbox.</p>
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
