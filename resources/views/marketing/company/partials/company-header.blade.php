<div class="border-b border-gray-200 py-3 text-sm">
  <div class="mx-auto flex max-w-7xl items-center justify-center gap-x-4 px-6 lg:px-8 xl:px-0">
    <a href="{{ route('marketing.company.index') }}" class="{{ request()->routeIs('marketing.company.index') ? 'border-b-3 border-blue-400' : 'border-b-3 border-transparent' }} group flex cursor-pointer flex-col items-center justify-center gap-x-2 gap-y-1 rounded-sm border px-2 py-1 transition-colors duration-150 hover:border-gray-400 hover:bg-white">
      <x-lucide-store class="h-4 w-4 text-gray-500" />
      <span class="text-gray-600">{{ __('About') }}</span>
    </a>
    <a href="{{ route('marketing.company.handbook.index') }}" class="{{ request()->routeIs('marketing.company.handbook.index') ? 'border-b-3 border-blue-400' : 'border-b-3 border-transparent' }} group flex cursor-pointer flex-col items-center justify-center gap-x-2 gap-y-1 rounded-sm border px-2 py-1 transition-colors duration-150 hover:border-gray-400 hover:bg-white">
      <x-lucide-book-open class="h-4 w-4 text-gray-500" />
      <span class="text-gray-600">{{ __('Handbook') }}</span>
    </a>
    <a href="{{ route('marketing.company.handbook.index') }}" class="{{ request()->routeIs('marketing.company.handbook.*') ? 'border-b-3 border-blue-400' : 'border-b-3 border-transparent' }} group flex cursor-pointer flex-col items-center justify-center gap-x-2 gap-y-1 rounded-sm border px-2 py-1 transition-colors duration-150 hover:border-gray-400 hover:bg-white">
      <x-lucide-mountain-snow class="h-4 w-4 text-gray-500" />
      <span class="text-gray-600">{{ __('Roadmap') }}</span>
    </a>
    <a href="{{ route('marketing.company.handbook.index') }}" class="{{ request()->routeIs('marketing.company.handbook.*') ? 'border-b-3 border-blue-400' : 'border-b-3 border-transparent' }} group flex cursor-pointer flex-col items-center justify-center gap-x-2 gap-y-1 rounded-sm border px-2 py-1 transition-colors duration-150 hover:border-gray-400 hover:bg-white">
      <x-lucide-scroll-text class="h-4 w-4 text-gray-500" />
      <span class="text-gray-600">{{ __('Changelog') }}</span>
    </a>
  </div>
</div>
