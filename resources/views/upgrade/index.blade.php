<?php
/**
 * @var array $user
 */
?>

<x-app-layout>
  <div class="py-12">
    <div class="mx-auto max-w-3xl px-6 lg:px-8">
      <!-- Header -->
      <div class="text-center">
        <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-5xl">
          {{ __('Unlock Lifetime Access') }}
        </h1>
        <p class="mt-6 text-lg leading-8 text-gray-600">
          {{ __('One payment, unlimited access forever. No subscriptions, no recurring fees.') }}
        </p>
      </div>

      <!-- Main Card -->
      <div class="mt-12 rounded-2xl bg-white p-8 shadow-sm ring-1 ring-gray-200">
        <div class="flex items-center justify-between">
          <div>
            <h2 class="text-2xl font-bold tracking-tight text-gray-900">{{ __('Lifetime Access') }}</h2>
            <p class="mt-2 text-base text-gray-500">{{ __('One-time payment, forever yours') }}</p>
          </div>
          <div class="text-right">
            <p class="text-5xl font-bold tracking-tight text-gray-900">$120</p>
            <p class="mt-1 text-sm text-gray-500">{{ __('One-time payment') }}</p>
          </div>
        </div>

        <div class="mt-8 space-y-4">
          <div class="flex items-start gap-3">
            <x-lucide-check class="h-6 w-6 flex-shrink-0 text-green-500" />
            <div>
              <h3 class="font-medium text-gray-900">{{ __('Lifetime Access') }}</h3>
              <p class="text-gray-500">{{ __('Pay once, use forever. No monthly fees, no annual renewals.') }}</p>
            </div>
          </div>

          <div class="flex items-start gap-3">
            <x-lucide-check class="h-6 w-6 flex-shrink-0 text-green-500" />
            <div>
              <h3 class="font-medium text-gray-900">{{ __('All features included') }}</h3>
              <p class="text-gray-500">{{ __('Get access to all current and future features we release.') }}</p>
            </div>
          </div>

          <div class="flex items-start gap-3">
            <x-lucide-check class="h-6 w-6 flex-shrink-0 text-green-500" />
            <div>
              <h3 class="font-medium text-gray-900">{{ __('Priority support') }}</h3>
              <p class="text-gray-500">{{ __('Get help when you need it with our priority support channel.') }}</p>
            </div>
          </div>
        </div>

        <div class="mt-8">
          <a href="#" class="inline-flex w-full items-center justify-center rounded-lg bg-blue-600 px-6 py-3 text-center text-base font-medium text-white shadow-sm hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:outline-none">
            {{ __('Upgrade now') }}
          </a>
          <p class="mt-2 text-center text-sm text-gray-500">
            {{ __('Secure payment powered by Stripe') }}
          </p>
        </div>
      </div>

      <!-- FAQ Section -->
      <div class="mt-16">
        <h2 class="text-2xl font-bold tracking-tight text-gray-900">{{ __('Frequently Asked Questions') }}</h2>

        <dl class="mt-8 space-y-8">
          <div>
            <dt class="text-lg leading-8 font-semibold text-gray-900">
              {{ __('Is this really a one-time payment?') }}
            </dt>
            <dd class="mt-2 text-base leading-7 text-gray-600">
              {{ __('Yes! You pay $120 once and get lifetime access. There are no hidden fees, no subscriptions, and no recurring charges ever.') }}
            </dd>
          </div>

          <div>
            <dt class="text-lg leading-8 font-semibold text-gray-900">
              {{ __('What happens after I pay?') }}
            </dt>
            <dd class="mt-2 text-base leading-7 text-gray-600">
              {{ __('You get immediate access to all features. Your account is upgraded instantly and you can continue using the app without interruption.') }}
            </dd>
          </div>

          <div>
            <dt class="text-lg leading-8 font-semibold text-gray-900">
              {{ __('Can I get a refund?') }}
            </dt>
            <dd class="mt-2 text-base leading-7 text-gray-600">
              {{ __('No. We do not offer refunds since there was a 30 days trial period to fully test the app.') }}
            </dd>
          </div>

          <div>
            <dt class="text-lg leading-8 font-semibold text-gray-900">
              {{ __('Will I get access to new features?') }}
            </dt>
            <dd class="mt-2 text-base leading-7 text-gray-600">
              {{ __('Absolutely! Your lifetime access includes all future updates and new features we release.') }}
            </dd>
          </div>
        </dl>
      </div>
    </div>
  </div>
</x-app-layout>
