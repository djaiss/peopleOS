<?php
/*
 * @var MarketingPage $marketingPage
 * @var string $view
 */
?>

<footer class="border-t border-gray-200 bg-white pt-12 pb-8">
  <div class="mx-auto max-w-7xl px-6 lg:px-0">
    <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-5">
      <!-- Products Column -->
      <div>
        <h3 class="text-sm font-semibold text-gray-900">{{ __('Products') }}</h3>
        <ul class="mt-6 space-y-4">
          <li>
            <a href="#" class="text-sm text-gray-600 hover:text-gray-900">{{ __('All products') }}</a>
          </li>
          <li>
            <a href="#" class="text-sm text-gray-600 hover:text-gray-900">{{ __('Features') }}</a>
          </li>
          <li>
            <a href="#" class="text-sm text-gray-600 hover:text-gray-900">{{ __('Security') }}</a>
          </li>
          <li>
            <a href="#" class="text-sm text-gray-600 hover:text-gray-900">{{ __('Team') }}</a>
          </li>
          <li>
            <a href="#" class="text-sm text-gray-600 hover:text-gray-900">{{ __('Enterprise') }}</a>
          </li>
        </ul>
      </div>

      <!-- Resources Column -->
      <div>
        <h3 class="text-sm font-semibold text-gray-900">{{ __('Resources') }}</h3>
        <ul class="mt-6 space-y-4">
          <li>
            <a href="#" class="text-sm text-gray-600 hover:text-gray-900">{{ __('Documentation') }}</a>
          </li>
          <li>
            <a href="#" class="text-sm text-gray-600 hover:text-gray-900">{{ __('API Reference') }}</a>
          </li>
          <li>
            <a href="#" class="text-sm text-gray-600 hover:text-gray-900">{{ __('Guides') }}</a>
          </li>
        </ul>
      </div>

      <!-- Company Column -->
      <div>
        <h3 class="text-sm font-semibold text-gray-900">{{ __('Company') }}</h3>
        <ul class="mt-6 space-y-4">
          <li>
            <a href="#" class="text-sm text-gray-600 hover:text-gray-900">{{ __('About') }}</a>
          </li>
          <li>
            <a href="#" class="text-sm text-gray-600 hover:text-gray-900">{{ __('Blog') }}</a>
          </li>
          <li>
            <a href="#" class="text-sm text-gray-600 hover:text-gray-900">{{ __('Careers') }}</a>
          </li>
        </ul>
      </div>

      <!-- Support Column -->
      <div>
        <h3 class="text-sm font-semibold text-gray-900">{{ __('Support') }}</h3>
        <ul class="mt-6 space-y-4">
          <li>
            <a href="#" class="text-sm text-gray-600 hover:text-gray-900">{{ __('Help Center') }}</a>
          </li>
          <li>
            <a href="#" class="text-sm text-gray-600 hover:text-gray-900">{{ __('Community') }}</a>
          </li>
          <li>
            <a href="#" class="text-sm text-gray-600 hover:text-gray-900">{{ __('Status') }}</a>
          </li>
        </ul>
      </div>

      <!-- Social Column -->
      <div>
        <h3 class="text-sm font-semibold text-gray-900">{{ __('Social') }}</h3>
        <ul class="mt-6 space-y-4">
          <li>
            <a href="#" class="text-sm text-gray-600 hover:text-gray-900">{{ __('GitHub') }}</a>
          </li>
          <li>
            <a href="#" class="text-sm text-gray-600 hover:text-gray-900">{{ __('Twitter') }}</a>
          </li>
          <li>
            <a href="#" class="text-sm text-gray-600 hover:text-gray-900">{{ __('LinkedIn') }}</a>
          </li>
        </ul>
      </div>
    </div>
  </div>

  <!-- Bottom section -->
  <div class="mt-12 border-t border-gray-900/10 pt-8">
    <div class="mx-auto max-w-7xl px-6 lg:px-0">
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div class="flex flex-col gap-y-2">
          <div class="flex items-center gap-x-4 sm:gap-x-2">
            <a href="{{ route('marketing.index') }}" class="group flex items-center gap-x-2 transition-transform ease-in-out">
              <div class="flex h-7 w-7 items-center justify-center transition-all duration-400 group-hover:-translate-y-0.5 group-hover:-rotate-3">
                <img src="{{ asset('marketing/logo.webp') }}" alt="PeopleOS logo" width="25" height="25" srcset="{{ asset('marketing/logo.webp') }} 1x, {{ asset('marketing/logo@2x.webp') }} 2x" />
              </div>
            </a>
            <p class="text-xs text-gray-600">&copy; {{ date('Y') }} {{ config('app.name') }}. {{ __('All rights reserved. Actually, our trademark is not registered, but we probably should write that to do like the big boys.') }}</p>
          </div>

          <x-marketing.marketing-footer-data :marketing-page="$marketingPage" :view-name="$viewName" />
        </div>

        <div class="mt-6 sm:mt-0">
          <div class="mb-2 flex gap-x-4">
            <a href="#" class="text-sm text-gray-600 hover:text-gray-900">{{ __('Privacy') }}</a>
            <a href="#" class="text-sm text-gray-600 hover:text-gray-900">{{ __('Terms') }}</a>
          </div>

          <p class="flex gap-x-2 text-xs text-gray-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" width="48" height="48" viewBox="0 0 9600 4800">
              <title>Flag of Canada</title>
              <path fill="#f00" d="m0 0h2400l99 99h4602l99-99h2400v4800h-2400l-99-99h-4602l-99 99H0z" />
              <path fill="#fff" d="m2400 0h4800v4800h-4800zm2490 4430-45-863a95 95 0 0 1 111-98l859 151-116-320a65 65 0 0 1 20-73l941-762-212-99a65 65 0 0 1-34-79l186-572-542 115a65 65 0 0 1-73-38l-105-247-423 454a65 65 0 0 1-111-57l204-1052-327 189a65 65 0 0 1-91-27l-332-652-332 652a65 65 0 0 1-91 27l-327-189 204 1052a65 65 0 0 1-111 57l-423-454-105 247a65 65 0 0 1-73 38l-542-115 186 572a65 65 0 0 1-34 79l-212 99 941 762a65 65 0 0 1 20 73l-116 320 859-151a95 95 0 0 1 111 98l-45 863z" />
            </svg>
            {{ __('Proudly Canadian') }}
          </p>
        </div>
      </div>
    </div>
  </div>
</footer>
