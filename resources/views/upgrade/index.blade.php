<x-app-layout>
  <div class="flex h-[calc(100vh-48px)] flex-col items-center justify-center bg-gray-50 px-4 text-center sm:px-6 lg:px-8">
    <div class="mx-auto mb-6 max-w-md overflow-hidden rounded-lg border border-gray-200 bg-white p-10 shadow-md dark:border-gray-700 dark:bg-gray-900">
      <!-- Text content -->
      <h3 class="text-2xl font-semibold text-gray-900">
        {{ __('We truly hope you’ve enjoyed your time with us.') }}
      </h3>

      <p class="mt-4 text-base text-gray-600">
        {{ __('Your trial is over. You can upgrade your account to continue using the app.') }}
      </p>

      <p class="mt-4 text-base text-gray-600">
        {{ __('There is good news, though: upgrading is not a subscription—it\'s a one-time payment.') }}
      </p>

      <!-- Call to action -->
      <div class="mt-8">
        <a href="{{ route('person.new') }}" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-6 py-3 text-base font-medium text-white shadow-xs hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:outline-hidden">
          <x-lucide-shield-check class="h-5 w-5" />
          {{ __('Upgrade now') }}
        </a>
      </div>

      <!-- Help text -->
      <p class="mt-4 mb-4 text-sm text-gray-500">
        {{ __('We use LemonSqueezy to handle payments. You can pay with credit card, Apple Pay, Google Pay, or PayPal.') }}
      </p>

      <!-- logo -->
      <a href="https://lemonsqueezy.com" target="_blank" class="flex justify-center">
        <img src="{{ asset('marketing/lemonsqueezy.svg') }}" alt="LemonSqueezy" class="h-6">
      </a>
    </div>
  </div>
</x-app-layout>
