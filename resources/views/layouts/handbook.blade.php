<x-marketing-layout :marketing-page="$marketingPage" :view-name="$viewName">
  <div class="border-b border-gray-200 py-3 text-sm">
    <div class="mx-auto flex max-w-7xl items-center justify-center gap-x-4 px-6 lg:px-8 xl:px-0">
      <div class="group flex cursor-pointer flex-col items-center justify-center gap-x-2 gap-y-1 rounded-sm border border-b-3 border-transparent px-2 py-1 transition-colors duration-150 hover:border-gray-400 hover:bg-white">
        <x-lucide-book-open class="h-4 w-4 text-gray-500" />
        <span class="text-gray-600">{{ __('Handbook') }}</span>
      </div>
      <a href="{{ route('marketing.company.handbook.index') }}" class="{{ request()->routeIs('marketing.company.handbook.*') ? 'border-b-3 border-blue-400' : 'border-b-3 border-transparent' }} group flex cursor-pointer flex-col items-center justify-center gap-x-2 gap-y-1 rounded-sm border px-2 py-1 transition-colors duration-150 hover:border-gray-400 hover:bg-white">
        <x-lucide-book-open class="h-4 w-4 text-gray-500" />
        <span class="text-gray-600">{{ __('Handbook') }}</span>
      </a>
    </div>
  </div>

  <!-- breadcrumb -->
  <div class="border-b border-gray-200 py-3 text-sm">
    <div class="mx-auto flex max-w-7xl items-center gap-x-2 px-6 lg:px-8 xl:px-0">
      {!!
        $breadcrumb ??
          '
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              <a href="' .
            route('marketing.index') .
            '" class="text-blue-500 hover:underline">' .
            __('Home') .
            '</a>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              <span class="text-gray-500">&gt;</span>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              <a href="' .
            route('marketing.company.index') .
            '" class="text-blue-500 hover:underline">' .
            __('Company') .
            '</a>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              <span class="text-gray-500">&gt;</span>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              <span class="text-gray-600">' .
            __('Handbook') .
            '</span>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              '
      !!}
    </div>
  </div>

  <div class="relative mx-auto max-w-7xl px-6 lg:px-8 xl:px-0">
    <div class="grid grid-cols-1 gap-x-16 lg:grid-cols-[300px_1fr_250px]">
      <!-- Sidebar -->
      <div class="hidden w-full flex-shrink-0 flex-col justify-self-end sm:border-r sm:border-gray-200 sm:pr-3 lg:flex">
        <div
          x-data="{
            generalInformation:
              {{ request()->routeIs('marketing.company.handbook.*') ? 'true' : 'false' }},
            marketing:
              {{ request()->routeIs('marketing.company.handbook.marketing.*') ? 'true' : 'false' }},
            productManagement:
              {{ request()->routeIs('marketing.company.handbook.product-management') ? 'true' : 'false' }},
            support:
              {{ request()->routeIs('marketing.company.handbook.support') ? 'true' : 'false' }},
            sales:
              {{ request()->routeIs('marketing.company.handbook.sales') ? 'true' : 'false' }},
            development:
              {{ request()->routeIs('marketing.company.handbook.development') ? 'true' : 'false' }},
          }"
          class="bg-light dark:bg-dark z-10 pt-16">
          <!-- api documentation -->
          <div class="mb-2 flex items-center justify-between rounded-md px-2 py-1">
            <a href="{{ route('marketing.company.handbook.index') }}" class="hover:underline">{{ __('Table of contents') }}</a>
          </div>

          <div @click="generalInformation = !generalInformation" class="mb-2 flex cursor-pointer items-center justify-between rounded-md border border-transparent px-2 py-1 hover:border-gray-200 hover:bg-blue-50">
            <h3>{{ __('General information') }}</h3>
            <x-lucide-chevron-right x-bind:class="generalInformation ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
          </div>

          <div x-cloak x-show="generalInformation" class="mb-4 ml-3">
            <div class="mb-3 flex flex-col gap-y-2">
              <div>
                <a href="{{ route('marketing.company.handbook.project') }}" class="{{ request()->routeIs('marketing.company.handbook.project') ? 'border-l-blue-400' : 'border-l-transparent' }} block border-l-3 pl-3 hover:border-l-blue-400 hover:underline">{{ __('Who I am and what is this project') }}</a>
              </div>
              <div>
                <a href="{{ route('marketing.company.handbook.principles') }}" class="{{ request()->routeIs('marketing.company.handbook.principles') ? 'border-l-blue-400' : 'border-l-transparent' }} block border-l-3 pl-3 hover:border-l-blue-400 hover:underline">{{ __('Principles') }}</a>
              </div>
              <div>
                <a href="{{ route('marketing.company.handbook.shipping') }}" class="{{ request()->routeIs('marketing.company.handbook.shipping') ? 'border-l-blue-400' : 'border-l-transparent' }} block border-l-3 pl-3 hover:border-l-blue-400 hover:underline">{{ __('Shipping is better than not shipping') }}</a>
              </div>
              <div>
                <a href="{{ route('marketing.company.handbook.money') }}" class="{{ request()->routeIs('marketing.company.handbook.money') ? 'border-l-blue-400' : 'border-l-transparent' }} block border-l-3 pl-3 hover:border-l-blue-400 hover:underline">{{ __('How does this project make money') }}</a>
              </div>
              <div>
                <a href="{{ route('marketing.company.handbook.why-open-source') }}" class="{{ request()->routeIs('marketing.company.handbook.why-open-source') ? 'border-l-blue-400' : 'border-l-transparent' }} block border-l-3 pl-3 hover:border-l-blue-400 hover:underline">{{ __('Why open source') }}</a>
              </div>
              <div>
                <a href="{{ route('marketing.company.handbook.where') }}" class="{{ request()->routeIs('marketing.company.handbook.where') ? 'border-l-blue-400' : 'border-l-transparent' }} block border-l-3 pl-3 hover:border-l-blue-400 hover:underline">{{ __('Where am I going with this') }}</a>
              </div>
            </div>
          </div>

          <div @click="marketing = !marketing" class="mb-2 flex cursor-pointer items-center justify-between rounded-md border border-transparent px-2 py-1 hover:border-gray-200 hover:bg-blue-50">
            <h3>{{ __('Marketing') }}</h3>
            <x-lucide-chevron-right x-bind:class="marketing ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
          </div>

          <div x-cloak x-show="marketing" class="mb-4 ml-3">
            <div class="mb-3 flex flex-col gap-y-2">
              <div>
                <a href="{{ route('marketing.company.handbook.marketing.envision') }}" class="{{ request()->routeIs('marketing.company.handbook.marketing.envision') ? 'border-l-blue-400' : 'border-l-transparent' }} block border-l-3 pl-3 hover:border-l-blue-400 hover:underline">{{ __('How do I envision marketing') }}</a>
              </div>
              <div>
                <a href="{{ route('marketing.company.handbook.marketing.social-media') }}" class="{{ request()->routeIs('marketing.company.handbook.marketing.social-media') ? 'border-l-blue-400' : 'border-l-transparent' }} block border-l-3 pl-3 hover:border-l-blue-400 hover:underline">{{ __('Social media') }}</a>
              </div>
              <div>
                <a href="{{ route('marketing.company.handbook.marketing.writing') }}" class="{{ request()->routeIs('marketing.company.handbook.marketing.writing') ? 'border-l-blue-400' : 'border-l-transparent' }} block border-l-3 pl-3 hover:border-l-blue-400 hover:underline">{{ __('Writing for PeopleOS') }}</a>
              </div>
              <div>
                <a href="{{ route('marketing.company.handbook.marketing.product-philosophy') }}" class="{{ request()->routeIs('marketing.company.handbook.marketing.product-philosophy') ? 'border-l-blue-400' : 'border-l-transparent' }} block border-l-3 pl-3 hover:border-l-blue-400 hover:underline">{{ __('Product philosophy') }}</a>
              </div>
              <div>
                <a href="{{ route('marketing.company.handbook.marketing.prioritize') }}" class="{{ request()->routeIs('marketing.company.handbook.marketing.prioritize') ? 'border-l-blue-400' : 'border-l-transparent' }} block border-l-3 pl-3 hover:border-l-blue-400 hover:underline">{{ __('How do we prioritize features?') }}</a>
              </div>
            </div>
          </div>

          <div @click="open = !open" class="mb-2 flex items-center justify-between rounded-md border border-transparent px-2 py-1 hover:border-gray-200">
            <h3>{{ __('Product management') }}</h3>
            <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
          </div>

          <div @click="open = !open" class="mb-2 flex items-center justify-between rounded-md border border-transparent px-2 py-1 hover:border-gray-200">
            <h3>{{ __('Support') }}</h3>
            <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
          </div>

          <div @click="open = !open" class="mb-2 flex items-center justify-between rounded-md border border-transparent px-2 py-1 hover:border-gray-200">
            <h3>{{ __('Sales') }}</h3>
            <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
          </div>

          <div @click="open = !open" class="mb-10 flex items-center justify-between rounded-md border border-transparent px-2 py-1 hover:border-gray-200">
            <h3>{{ __('Development') }}</h3>
            <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
          </div>
        </div>
      </div>

      <!-- Main content -->
      <div class="py-16">
        {{ $slot }}
      </div>

      <!-- Sidebar -->
      <div class="hidden w-full flex-shrink-0 flex-col justify-self-end py-16 sm:border-l sm:border-gray-200 sm:pl-6 lg:flex">
        {{ $rightSidebar ?? '' }}
      </div>
    </div>
  </div>
</x-marketing-layout>
