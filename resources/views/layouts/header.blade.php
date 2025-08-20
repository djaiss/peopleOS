<div class="w-full">
  <!-- main nav -->
  <nav class="max-w-8xl mx-auto flex h-12 items-center justify-between border-b border-gray-300 bg-zinc-100 px-3 sm:px-6 dark:border-slate-600 dark:bg-gray-800 dark:text-slate-200">
    <div class="flex items-center gap-x-10">
      <!-- Logo and brand -->
      <a href="{{ route('dashboard.index') }}" class="group flex items-center gap-x-2 transition-transform ease-in-out">
        <div class="flex h-7 w-7 items-center justify-center transition-all duration-400 group-hover:-translate-y-0.5 group-hover:-rotate-3">
          <x-image src="{{ asset('marketing/logo.webp') }}" alt="PeopleOS logo" width="25" height="25" srcset="{{ asset('marketing/logo.webp') }} 1x, {{ asset('marketing/logo@2x.webp') }} 2x" />
        </div>
        <span class="text-lg font-semibold text-gray-900 dark:text-white">{{ config('app.name') }}</span>
      </a>

      <!-- Main navigation -->
      <div class="flex items-center gap-x-6">
        <a href="{{ route('dashboard.index') }}" class="group flex items-center gap-x-2 rounded-sm border border-b-3 border-transparent px-2 py-1 transition-colors duration-150 hover:border-gray-400 hover:bg-white">
          <x-lucide-home class="h-4 w-4 text-gray-700 group-hover:text-purple-500" />
          <p class="text-sm text-gray-700">
            {{ __('Dashboard') }}
          </p>
        </a>

        <a href="{{ route('person.index') }}" class="group flex items-center gap-x-2 rounded-sm border border-b-3 border-transparent px-2 py-1 transition-colors duration-150 hover:border-gray-400 hover:bg-white">
          <x-lucide-users-round class="h-4 w-4 text-gray-700 group-hover:text-blue-500" />
          <p class="text-sm text-gray-700">
            {{ __('People') }}
          </p>
        </a>

        <!-- upgrade -->
        @if (Auth::user()->account->isInTrial())
          <div class="ml-12 flex items-center gap-x-2" x-data="{ showTooltip: false }" @mouseenter="showTooltip = true" @mouseleave="showTooltip = false">
            <div class="flex items-center gap-x-2 rounded-lg bg-[#F7BE38]/70 px-3 py-1 text-center text-sm font-medium text-gray-900 hover:bg-[#F7BE38]/90 focus:ring-4 focus:ring-[#F7BE38]/50 focus:outline-none dark:focus:ring-[#F7BE38]/50">
              <x-lucide-hourglass class="h-4 w-4 text-yellow-800" />
              <p class="text-sm text-yellow-800">{{ __(':days days left in your trial', ['days' => round(now()->diffInDays(Auth::user()->account->trial_ends_at))]) }}</p>
            </div>
            <div class="relative">
              <a href="{{ route('upgrade.index') }}" class="text-sm text-blue-500">
                {{ __('Unlock') }}
              </a>
              <div x-cloak x-show="showTooltip" x-transition:enter="transition duration-200 ease-out" x-transition:enter-start="translate-y-1 opacity-0" x-transition:enter-end="translate-y-0 opacity-100" x-transition:leave="transition duration-150 ease-in" x-transition:leave-start="translate-y-0 opacity-100" x-transition:leave-end="translate-y-1 opacity-0" class="absolute top-full right-0 z-50 mt-2 flex w-96 items-center gap-x-3 rounded-lg bg-white p-4 shadow-lg ring-1 ring-black/5">
                <x-image src="{{ asset('marketing/vandamme.webp') }}" alt="One-time fee" width="80" height="80" class="h-20 w-20 rounded-full" srcset="{{ asset('marketing/vandamme.webp') }} 1x, {{ asset('marketing/vandamme@2x.webp') }} 2x" />
                <div class="flex flex-col">
                  <p class="text-sm text-gray-600">{{ __("It's a one-time fee, and will unlock everything!") }}</p>
                  <p class="text-sm text-gray-600">{{ __('It kicks ass.') }}</p>
                  <p class="text-sm font-semibold text-gray-600">{{ __('Van Damme would be proud of you.') }}</p>
                </div>
              </div>
            </div>
          </div>
        @endif
      </div>
    </div>

    <div class="relative ms-3 flex items-center gap-x-3">
      <x-dropdown align="right" width="48">
        <x-slot name="trigger">
          <button class="flex cursor-pointer rounded-full border-2 border-transparent text-sm transition focus:border-gray-300 focus:outline-hidden">
            <x-image class="h-8 w-8 rounded-full object-cover p-[0.1875rem] shadow-sm ring-1 ring-slate-900/10" width="32" height="32" src="{{ Auth::user()->getAvatar(32) }}" srcset="{{ Auth::user()->getAvatar(32) }} 1x, {{ Auth::user()->getAvatar(64) }} 2x" alt="{{ Auth::user()->name }}" />
          </button>
        </x-slot>

        <x-slot name="content">
          <!-- Account Management -->
          <div class="block px-4 py-2 text-xs text-gray-400">
            {{ __('Manage account') }}
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

          <!-- Account Management -->
          <div class="block px-4 py-2 text-xs text-gray-400">
            {{ __('External links') }}
          </div>

          <x-dropdown-link href="{{ route('marketing.docs.index') }}">
            {{ __('Documentation') }}
          </x-dropdown-link>

          <x-dropdown-link href="{{ route('marketing.docs.api.introduction') }}">
            {{ __('API documentation') }}
          </x-dropdown-link>

          <div class="border-t border-gray-200 dark:border-gray-600"></div>

          <!-- Authentication -->
          <form method="POST" action="{{ route('logout') }}" x-data>
            @csrf

            <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
              {{ __('Log out') }}
            </x-dropdown-link>
          </form>
        </x-slot>
      </x-dropdown>
    </div>
  </nav>
</div>
