<x-marketing-layout>
  <!-- breadcrumb -->
  <div class="border-b border-gray-200 py-3 text-sm">
    <div class="mx-auto flex max-w-7xl items-center gap-x-2 px-6 lg:px-0">
      <a href="{{ route('marketing.index') }}" class="text-blue-500 hover:underline">{{ __('Home') }}</a>
      <span class="text-gray-500">&gt;</span>
      <span class="text-gray-600">{{ __('Documentation') }}</span>
    </div>
  </div>

  <div class="relative mx-auto max-w-7xl px-6 lg:px-0">
    <div class="grid grid-cols-1 gap-x-16 lg:grid-cols-[250px_1fr]">
      <!-- Sidebar -->
      <div class="hidden w-full flex-shrink-0 flex-col justify-self-end sm:border-r sm:border-gray-200 sm:pr-3 lg:flex">
        <div x-data="{ openApiDocumentation: true }" class="bg-light dark:bg-dark z-10 pt-16">
          <!-- api documentation -->
          <div @click="open = !open" class="mb-2 flex items-center justify-between rounded-md border border-transparent px-2 py-1 hover:border-gray-200">
            <h3>{{ __('Person management') }}</h3>
            <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
          </div>

          <div @click="open = !open" class="mb-2 flex items-center justify-between rounded-md border border-transparent px-2 py-1 hover:border-gray-200">
            <h3>{{ __('Journal management') }}</h3>
            <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
          </div>

          <!-- api documentation -->
          <div @click="openApiDocumentation = !openApiDocumentation" class="mb-2 flex cursor-pointer items-center justify-between rounded-md border border-transparent px-2 py-1 hover:border-gray-200">
            <h3>{{ __('API documentation') }}</h3>
            <x-lucide-chevron-right x-bind:class="openApiDocumentation ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
          </div>

          <!-- sub menu -->
          <div x-show="openApiDocumentation" class="mb-10 ml-3">
            <div class="mb-3 flex flex-col gap-y-2">
              <div>
                <a href="{{ route('marketing.docs.api.introduction') }}" class="{{ request()->routeIs('marketing.docs.api.introduction') ? 'border-l-blue-400' : 'border-l-transparent' }} border-l-3 pl-3 hover:border-l-blue-400 hover:underline">{{ __('Introduction') }}</a>
              </div>
              <div>
                <a href="{{ route('marketing.docs.api.authentication') }}" class="{{ request()->routeIs('marketing.docs.api.authentication') ? 'border-l-blue-400' : 'border-l-transparent' }} border-l-3 pl-3 hover:border-l-blue-400 hover:underline">{{ __('Authentication') }}</a>
              </div>
              <div>
                <a href="{{ route('marketing.docs.api.errors') }}" class="{{ request()->routeIs('marketing.docs.api.errors') ? 'border-l-blue-400' : 'border-l-transparent' }} border-l-3 pl-3 hover:border-l-blue-400 hover:underline">{{ __('Errors') }}</a>
              </div>
            </div>

            <!-- account management -->
            <p class="mb-1 border-l-2 border-l-transparent pl-3 text-xs text-gray-500 uppercase">{{ __('Account management') }}</p>
            <div class="flex flex-col gap-y-2">
              <div>
                <a href="{{ route('marketing.docs.api.profile') }}" class="{{ request()->routeIs('marketing.docs.api.profile') ? 'border-l-blue-400' : 'border-l-transparent' }} border-l-3 pl-3 hover:border-l-blue-400 hover:underline">{{ __('Profile') }}</a>
              </div>
              <div>
                <a href="{{ route('marketing.docs.api.introduction') }}" class="{{ request()->routeIs('marketing.docs.api.introduction') ? 'border-l-blue-400' : 'border-l-transparent' }} border-l-3 pl-3 hover:border-l-blue-400 hover:underline">{{ __('Profile') }}</a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Main content -->
      <div class="py-16">
        {{ $slot }}
      </div>
    </div>
  </div>
</x-marketing-layout>
