<div class="w-full">
  <!-- main nav -->
  <nav class="max-w-8xl mx-auto flex h-12 items-center justify-between border-b border-gray-300 bg-zinc-100 px-3 sm:px-6 dark:border-slate-600 dark:bg-gray-800 dark:text-slate-200">
    <div class="flex items-center gap-x-10">
      <!-- Logo and brand -->
      <a href="{{ route('dashboard.index') }}" class="group flex items-center gap-x-2 transition-transform ease-in-out">
        <div class="flex h-7 w-7 items-center justify-center transition-all duration-400 group-hover:-translate-y-0.5 group-hover:-rotate-3">
          <img src="{{ asset('marketing/logo.png') }}" alt="PeopleOS logo" width="25" height="25" srcset="{{ asset('marketing/logo.png') }} 1x, {{ asset('marketing/logo@2x.png') }} 2x" />
        </div>
        <span class="text-lg font-semibold text-gray-900 dark:text-white">{{ config('app.name') }}</span>
      </a>

      <!-- Main navigation -->
      <div class="flex items-center gap-x-6">
        <a href="{{ route('dashboard.index') }}" class="flex items-center gap-x-2 rounded-sm border border-b-3 border-transparent px-2 py-1 transition-colors duration-150 hover:border-gray-400 hover:bg-white">
          <x-lucide-home class="h-4 w-4 text-gray-700" />
          <p class="text-sm text-gray-700">
            {{ __('Dashboard') }}
          </p>
        </a>

        <a href="{{ route('persons.index') }}" class="flex items-center gap-x-2 rounded-sm border border-b-3 border-transparent px-2 py-1 transition-colors duration-150 hover:border-gray-400 hover:bg-white">
          <x-lucide-users-round class="h-4 w-4 text-gray-700" />
          <p class="text-sm text-gray-700">
            {{ __('People') }}
          </p>
        </a>

        <a href="" class="flex items-center gap-x-2 rounded-sm border border-b-3 border-transparent px-2 py-1 transition-colors duration-150 hover:border-gray-400 hover:bg-white">
          <x-lucide-book-open-text class="h-4 w-4 text-gray-700" />
          <p class="text-sm text-gray-700">
            {{ __('Journal') }}
          </p>
        </a>

        <!-- upgrade -->
        @if (Auth::user()->account->isInTrial())
          <div class="ml-12 flex items-center gap-x-2">
            <div class="rounded-md border border-yellow-300 bg-yellow-50 px-3 py-1">
              <p class="text-sm text-yellow-800">{{ round(now()->diffInDays(Auth::user()->account->trial_ends_at)) }} days left in your trial</p>
            </div>
            <a href="{{ route('upgrade.index') }}" class="text-sm text-blue-500">
              {{ __('Upgrade') }}
            </a>
          </div>
        @endif
      </div>
    </div>

    <div class="relative ms-3 flex items-center gap-x-3">
      <x-lucide-bell class="h-4 w-4 text-gray-500" />

      <x-dropdown align="right" width="48">
        <x-slot name="trigger">
          <button class="flex cursor-pointer rounded-full border-2 border-transparent text-sm transition focus:border-gray-300 focus:outline-hidden">
            <img class="h-8 w-8 rounded-full object-cover p-[0.1875rem] shadow-sm ring-1 ring-slate-900/10" src="{{ Auth::user()->getAvatar(64) }}" alt="{{ Auth::user()->name }}" />
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

          @if (Auth::user()->is_instance_admin)
            <x-dropdown-link href="{{ route('instance.index') }}">
              {{ __('Instance administration') }}
            </x-dropdown-link>
          @endif

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
