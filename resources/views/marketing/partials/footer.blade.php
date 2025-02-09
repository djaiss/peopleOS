<footer class="bg-white py-16">
  <div class="mx-auto max-w-7xl px-6 lg:px-8">
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

    <!-- Bottom section -->
    <div class="mt-16 border-t border-gray-900/10 pt-8">
      <div class="flex items-center justify-between">
        <div class="flex items-center gap-x-2">
          <a href="{{ route('marketing.index') }}" class="group flex items-center gap-x-2 transition-transform ease-in-out">
            <div class="flex h-7 w-7 items-center justify-center rounded-sm bg-blue-600 p-1 transition-all duration-400 group-hover:-translate-y-0.5 group-hover:-rotate-3">
              <x-lucide-users class="h-5 w-5 text-white" />
            </div>
          </a>
          <p class="text-xs text-gray-600">&copy; {{ date('Y') }} {{ config('app.name') }}. {{ __('All rights reserved. Actually our trademark is not registerd but we probably should write that to do like the big boys.') }}</p>
        </div>
        <div class="flex gap-x-4">
          <a href="#" class="text-sm text-gray-600 hover:text-gray-900">{{ __('Privacy') }}</a>
          <a href="#" class="text-sm text-gray-600 hover:text-gray-900">{{ __('Terms') }}</a>
        </div>
      </div>
    </div>
  </div>
</footer>
