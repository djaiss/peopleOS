<div class="w-full">
  <!-- main nav -->
  <nav class="max-w-8xl mx-auto flex h-12 items-center justify-between border-b border-gray-300 bg-gray-200 px-3 sm:px-6 dark:border-slate-600 dark:bg-gray-800 dark:text-slate-200">
    <div class="flex items-center gap-x-5">
      <!-- search -->
      <div class="relative items-center text-sm sm:flex">
        <x-lucide-search class="pointer-events-none absolute left-2 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-500" />
        <x-text-input type="text" placeholder="{{ __('Search') }}" class="w-30 border border-gray-300 bg-gray-100 py-1 pl-8 pr-3 text-sm focus:bg-white" />
      </div>

      <!-- upgrade -->
      @if (! Auth::user()->has_paid && config('peopleos.enable_paid_version'))
        <div class="flex items-center gap-x-2">
          <div class="rounded-md border border-yellow-300 bg-yellow-50 px-3 py-1">
            <p class="text-sm text-yellow-800">{{ max(0, round(30 - Auth::user()->created_at->diffInDays(now()))) }} days left in your trial</p>
          </div>
          <a wire:navigate href="{{ route('upgrade.index') }}" class="text-sm text-blue-500">
            {{ __('Upgrade') }}
          </a>
        </div>
      @endif
    </div>

    <div class="relative ms-3 flex items-center gap-x-3">
      <x-lucide-bell class="h-4 w-4 text-gray-500" />

      <x-dropdown align="right" width="48">
        <x-slot name="trigger">
          <button class="flex rounded-full border-2 border-transparent text-sm transition focus:border-gray-300 focus:outline-none">
            <img class="h-8 w-8 rounded-full object-cover p-[0.1875rem] shadow ring-1 ring-slate-900/10" src="{{ Auth::user()->getAvatar(64) }}" alt="{{ Auth::user()->name }}" />
          </button>
        </x-slot>

        <x-slot name="content">
          <!-- Account Management -->
          <div class="block px-4 py-2 text-xs text-gray-400">
            {{ __('Manage Account') }}
          </div>

          <x-dropdown-link href="{{ route('administration.index') }}">
            {{ __('Administration') }}
          </x-dropdown-link>

          <x-dropdown-link href="{{ route('instance.index') }}">
            {{ __('Instance Administration') }}
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
