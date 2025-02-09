<x-marketing-layout>
  <!-- Hero Section -->
  <div class="relative isolate bg-white">
    <div class="mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:px-8">
      <div class="mx-auto max-w-2xl text-center">
        <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">Remember what matters about the people you care about</h1>
        <p class="mt-6 text-lg leading-8 text-gray-600">
          {{ __('PeopleOS helps you be more intentional with your relationships by keeping track of the important details about people in your life.') }}
        </p>
        <div class="mt-10 flex items-center justify-center gap-x-6">
          <a href="{{ route('register') }}" class="rounded-md bg-blue-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
            {{ __('Get started for free') }}
          </a>
          <a href="#features" class="text-sm leading-6 font-semibold text-gray-900">
            {{ __('Learn more') }}
            <span aria-hidden="true">→</span>
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- Feature Section -->
  <div id="features" class="bg-gray-50 py-24 sm:py-32">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
      <div class="mx-auto max-w-2xl lg:text-center">
        <h2 class="text-base leading-7 font-semibold text-blue-600">{{ __('Your Personal CRM') }}</h2>
        <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
          {{ __('Everything you need to maintain meaningful relationships') }}
        </p>
      </div>
      <div class="mx-auto mt-16 max-w-2xl sm:mt-20 lg:mt-24 lg:max-w-none">
        <dl class="grid max-w-xl grid-cols-1 gap-x-8 gap-y-16 lg:max-w-none lg:grid-cols-3">
          <!-- Feature 1: Privacy -->
          <div class="flex flex-col">
            <dt class="flex items-center gap-x-3 text-base leading-7 font-semibold text-gray-900">
              <x-lucide-shield-check class="h-5 w-5 flex-none text-blue-600" />
              {{ __('Privacy-First Design') }}
            </dt>
            <dd class="mt-4 flex flex-auto flex-col text-base leading-7 text-gray-600">
              <p class="flex-auto">{{ __('Your data is fully encrypted at rest. We prioritize your privacy and security above all else.') }}</p>
            </dd>
          </div>

          <!-- Feature 2: Simplicity -->
          <div class="flex flex-col">
            <dt class="flex items-center gap-x-3 text-base leading-7 font-semibold text-gray-900">
              <x-lucide-sparkles class="h-5 w-5 flex-none text-blue-600" />
              {{ __('Beautifully Simple') }}
            </dt>
            <dd class="mt-4 flex flex-auto flex-col text-base leading-7 text-gray-600">
              <p class="flex-auto">{{ __('No bloat, no complexity. Just the features you need to maintain meaningful relationships.') }}</p>
            </dd>
          </div>

          <!-- Feature 3: Self-hosted -->
          <div class="flex flex-col">
            <dt class="flex items-center gap-x-3 text-base leading-7 font-semibold text-gray-900">
              <x-lucide-server class="h-5 w-5 flex-none text-blue-600" />
              {{ __('Self-Hosted Option') }}
            </dt>
            <dd class="mt-4 flex flex-auto flex-col text-base leading-7 text-gray-600">
              <p class="flex-auto">{{ __('Host it yourself for complete control over your data. Perfect for privacy-conscious users.') }}</p>
            </dd>
          </div>
        </dl>
      </div>
    </div>
  </div>

  <!-- CTA Section -->
  <div class="bg-white">
    <div class="mx-auto max-w-7xl py-24 sm:px-6 sm:py-32 lg:px-8">
      <div class="relative isolate overflow-hidden bg-gray-900 px-6 py-24 text-center shadow-2xl sm:rounded-3xl sm:px-16">
        <h2 class="mx-auto max-w-2xl text-3xl font-bold tracking-tight text-white sm:text-4xl">
          {{ __('Start building better relationships today') }}
        </h2>
        <p class="mx-auto mt-6 max-w-xl text-lg leading-8 text-gray-300">
          {{ __('Join thousands of users who use PeopleOS to maintain meaningful connections with the people who matter most.') }}
        </p>
        <div class="mt-10 flex items-center justify-center gap-x-6">
          <a href="{{ route('register') }}" class="rounded-md bg-white px-3.5 py-2.5 text-sm font-semibold text-gray-900 shadow-sm hover:bg-gray-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">
            {{ __('Get started for free') }}
          </a>
          <a href="{{ route('login') }}" class="text-sm leading-6 font-semibold text-white">
            {{ __('Sign in') }}
            <span aria-hidden="true">→</span>
          </a>
        </div>
      </div>
    </div>
  </div>
</x-marketing-layout>
