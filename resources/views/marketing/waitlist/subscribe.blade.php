<x-guest-layout>
  <div class="grid min-h-screen w-screen grid-cols-1 lg:grid-cols-3">
    <!-- Left side - Registration form -->
    <div class="col-span-2 mx-auto flex w-full max-w-xl flex-1 flex-col justify-center px-5 py-10 sm:px-6">
      <div class="w-full">
        @if (config('peopleos.show_marketing_site'))
          <p class="group mb-10 flex items-center gap-x-1 text-sm text-gray-600">
            <x-lucide-arrow-left class="h-4 w-4 transition-transform duration-150 group-hover:-translate-x-1" />
            <a href="{{ route('marketing.index') }}" class="group-hover:underline">Back to the marketing website</a>
          </p>
        @endif

        <!-- Title -->
        <div class="mb-8">
          <div class="flex items-center gap-x-2">
            <a href="{{ route('marketing.index') }}" class="group flex items-center gap-x-2 transition-transform ease-in-out">
              <div class="flex h-7 w-7 items-center justify-center transition-all duration-400 group-hover:-translate-y-0.5 group-hover:-rotate-3">
                <x-image src="{{ asset('marketing/logo.webp') }}" alt="PeopleOS logo" width="25" height="25" srcset="{{ asset('marketing/logo.webp') }} 1x, {{ asset('marketing/logo@2x.webp') }} 2x" />
              </div>
            </a>
            <h1 class="text-2xl font-semibold text-gray-900">
              {{ __('Join waitlist') }}
            </h1>
          </div>
          <p class="mt-2 text-sm text-gray-500">{{ __('And thanks for your interest in PeopleOS.') }}</p>
        </div>

        <!-- Registration Form -->
        <div class="mt-6 mb-12 w-full overflow-hidden rounded-lg bg-white p-6 shadow-md dark:bg-gray-900">
          <form method="POST" action="{{ route('waitlist.store') }}">
            @csrf

            <!-- Email address -->
            <div class="mb-4">
              <x-input-label for="email" :value="__('Email')" class="mb-2" />
              <x-text-input id="email" class="block w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
              <x-input-error :messages="$errors->get('email')" class="mt-2" />
              <x-help>{{ __('We will never, ever send you marketing emails. We hate spam as much as you do.') }}</x-help>
            </div>

            @if (config('peopleos.enable_anti_spam'))
              <x-turnstile data-size="flexible" />

              <x-input-error :messages="$errors->get('cf-turnstile-response')" class="mt-2" />
            @endif

            <div class="mt-6">
              <x-button.primary class="w-full">
                {{ __('Join') }}
              </x-button.primary>
            </div>
          </form>
        </div>

        <!-- Login Link -->

        <ul class="text-xs text-gray-600">
          <li>© PeopleOS {{ now()->format('Y') }}</li>
        </ul>
      </div>
    </div>

    <!-- Right side - Background and quote -->
    <div class="login-image relative col-span-1 hidden lg:block">
      <!-- Quote Box -->
      <div class="absolute inset-0 flex items-center justify-center">
        <div class="relative rounded-lg border-2 border-white/70 bg-white/90 p-1 shadow-lg backdrop-blur-sm">
          <div class="max-w-md rounded-lg bg-white/90 p-8 shadow-lg backdrop-blur-sm">
            <p class="mb-4 text-xl font-medium text-gray-900">"I can not wait to use PeopleOS."</p>

            <div class="flex items-center gap-x-2">
              <x-image src="{{ asset('marketing/quotes/michael.webp') }}" srcset="{{ asset('marketing/quotes/michael.webp') }}, {{ asset('marketing/quotes/michael@2x.webp') }} 2x" height="48" width="48" alt="Michael Scott" class="h-12 w-12 rounded-full border border-gray-200" />
              <div class="flex flex-col gap-y-1">
                <p class="text-sm font-semibold text-gray-600">Michael Scott</p>
                <p class="text-sm text-gray-600">
                  <span class="italic">from</span>
                  The Office
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-guest-layout>
