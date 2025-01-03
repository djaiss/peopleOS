<div class="w-full">
  <!-- main nav -->
  <nav class="max-w-8xl mx-auto flex h-12 items-center justify-between border-b border-gray-300 bg-gray-200 px-3 sm:px-6 dark:border-slate-600 dark:bg-gray-800 dark:text-slate-200">
    <div class="items-center text-sm sm:flex relative">
      <x-lucide-search class="absolute left-2 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-500 pointer-events-none" />
      <x-text-input type="text" placeholder="{{ __('Search') }}" class="w-30 text-sm pl-8 pr-3 py-1 bg-gray-100 border border-gray-300 focus:bg-white" />
    </div>

    <div class="relative ms-3 flex items-center gap-x-3">
      <x-lucide-bell class="w-4 h-4 text-gray-500" />

      <x-dropdown align="right" width="48">
        <x-slot name="trigger">
          <button class="flex rounded-full border-2 border-transparent text-sm transition focus:border-gray-300 focus:outline-none">
            <img class="h-8 w-8 rounded-full object-cover p-[0.1875rem] shadow ring-1 ring-slate-900/10" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
          </button>
        </x-slot>

        <x-slot name="content">
          <!-- Account Management -->
          <div class="block px-4 py-2 text-xs text-gray-400">
            {{ __('Manage Account') }}
          </div>

          <x-dropdown-link href="{{ route('dashboard') }}">
            {{ __('Your profile') }}
          </x-dropdown-link>

          <div class="border-t border-gray-200 dark:border-gray-600"></div>

          <!-- Authentication -->
          <form method="POST" action="{{ route('logout') }}" x-data>
            @csrf

            <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
              {{ __('Log Out') }}
            </x-dropdown-link>
          </form>
        </x-slot>
      </x-dropdown>
    </div>
  </nav>
</div>
