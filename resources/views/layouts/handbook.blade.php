<x-marketing-layout>
  <div class="border-b border-gray-200 py-3 text-sm">
    <div class="mx-auto flex max-w-7xl items-center gap-x-4 px-6 lg:px-8 xl:px-0">
      <div class="group flex cursor-pointer flex-col items-center justify-center gap-x-2 gap-y-1 rounded-sm border border-b-3 border-transparent px-2 py-1 transition-colors duration-150 hover:border-gray-400 hover:bg-white">
        <x-lucide-book-open class="h-4 w-4 text-gray-500" />
        <span class="text-gray-600">{{ __('Handbook') }}</span>
      </div>
      <div class="group flex cursor-pointer flex-col items-center justify-center gap-x-2 gap-y-1 rounded-sm border border-b-3 border-transparent px-2 py-1 transition-colors duration-150 hover:border-gray-400 hover:bg-white">
        <x-lucide-book-open class="h-4 w-4 text-gray-500" />
        <span class="text-gray-600">{{ __('Handbook') }}</span>
      </div>
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
        <div x-data="{
          generalInformation: true,
          marketing: true,
          productManagement: true,
          support: true,
          sales: true,
          development: true,
        }" class="bg-light dark:bg-dark z-10 pt-16">
          <!-- api documentation -->
          <div class="mb-2 flex items-center justify-between rounded-md px-2 py-1">
            <a href="{{ route('marketing.company.handbook.index') }}" class="hover:underline">{{ __('Table of contents') }}</a>
          </div>

          <div @click="generalInformation = !generalInformation" class="mb-2 flex items-center justify-between rounded-md border border-transparent px-2 py-1 hover:border-gray-200">
            <h3>{{ __('General information') }}</h3>
            <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
          </div>

          <div x-show="generalInformation" class="mb-10 ml-3">
            <div class="mb-3 flex flex-col gap-y-2">
              <div>
                <a href="{{ route('marketing.company.handbook.project') }}" class="{{ request()->routeIs('marketing.company.handbook.project') ? 'border-l-blue-400' : 'border-l-transparent' }} border-l-3 pl-3 hover:border-l-blue-400 hover:underline">{{ __('Who I am and what is this project') }}</a>
              </div>
              <div>
                <a href="{{ route('marketing.docs.api.authentication') }}" class="{{ request()->routeIs('marketing.docs.api.authentication') ? 'border-l-blue-400' : 'border-l-transparent' }} border-l-3 pl-3 hover:border-l-blue-400 hover:underline">{{ __('Principles') }}</a>
              </div>
              <div>
                <a href="{{ route('marketing.docs.api.errors') }}" class="{{ request()->routeIs('marketing.docs.api.errors') ? 'border-l-blue-400' : 'border-l-transparent' }} border-l-3 pl-3 hover:border-l-blue-400 hover:underline">{{ __('Shipping is better than not shipping') }}</a>
              </div>
              <div>
                <a href="{{ route('marketing.docs.api.errors') }}" class="{{ request()->routeIs('marketing.docs.api.errors') ? 'border-l-blue-400' : 'border-l-transparent' }} border-l-3 pl-3 hover:border-l-blue-400 hover:underline">{{ __('How does this project make money') }}</a>
              </div>
              <div>
                <a href="{{ route('marketing.docs.api.errors') }}" class="{{ request()->routeIs('marketing.docs.api.errors') ? 'border-l-blue-400' : 'border-l-transparent' }} border-l-3 pl-3 hover:border-l-blue-400 hover:underline">{{ __('Side project vs real company') }}</a>
              </div>
              <div>
                <a href="{{ route('marketing.docs.api.errors') }}" class="{{ request()->routeIs('marketing.docs.api.errors') ? 'border-l-blue-400' : 'border-l-transparent' }} border-l-3 pl-3 hover:border-l-blue-400 hover:underline">{{ __('Why open source') }}</a>
              </div>
              <div>
                <a href="{{ route('marketing.docs.api.errors') }}" class="{{ request()->routeIs('marketing.docs.api.errors') ? 'border-l-blue-400' : 'border-l-transparent' }} border-l-3 pl-3 hover:border-l-blue-400 hover:underline">{{ __('Thoughts on hiring') }}</a>
              </div>
              <div>
                <a href="{{ route('marketing.docs.api.errors') }}" class="{{ request()->routeIs('marketing.docs.api.errors') ? 'border-l-blue-400' : 'border-l-transparent' }} border-l-3 pl-3 hover:border-l-blue-400 hover:underline">{{ __('Where am I going with this') }}</a>
              </div>
            </div>
          </div>

          <div @click="open = !open" class="mb-2 flex items-center justify-between rounded-md border border-transparent px-2 py-1 hover:border-gray-200">
            <h3>{{ __('Marketing') }}</h3>
            <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
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
