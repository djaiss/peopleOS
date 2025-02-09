<div class="w-full">
  <!-- main nav -->
  <nav class="max-w-8xl mx-auto flex h-12 items-center justify-between border-b border-gray-300 bg-gray-200 px-3 sm:px-6 dark:border-slate-600 dark:bg-gray-800 dark:text-slate-200">
    <!-- Logo -->
    <div class="flex items-center">
      <a href="{{ route('marketing.index') }}" class="group flex items-center gap-x-2 transition-transform ease-in-out">
        <div class="flex h-7 w-7 items-center justify-center rounded-sm bg-blue-600 p-1 transition-all duration-400 group-hover:-translate-y-0.5 group-hover:-rotate-3">
          <x-lucide-users class="h-5 w-5 text-white" />
        </div>
        <span class="text-lg font-semibold text-gray-900 dark:text-white">{{ config('app.name') }}</span>
      </a>
    </div>

    <!-- Main navigation - centered -->
    <div class="flex flex-1 justify-center">
      <div class="flex items-center gap-x-2">
        <a href="{{ route('dashboard.index') }}" class="flex items-center gap-x-2 border border-b-3 px-2 py-1 rounded-sm hover:bg-white border-transparent hover:border-gray-400 transition-colors duration-150 group">
          <x-lucide-message-circle-question class="h-4 w-4 text-blue-600 group-hover:text-blue-700" />
          <p class="text-sm text-gray-700 group-hover:text-gray-900">
            {{ __('Why PeopleOS') }}
          </p>
        </a>

        <a href="{{ route('persons.index') }}" class="flex items-center gap-x-2 border border-b-3 px-2 py-1 rounded-sm hover:bg-white border-transparent hover:border-gray-400 transition-colors duration-150 group">
          <x-lucide-layout-grid class="h-4 w-4 text-purple-600 group-hover:text-purple-700" />
          <p class="text-sm text-gray-700 group-hover:text-gray-900">
            {{ __('Products') }}
          </p>
        </a>

        <a href="" class="flex items-center gap-x-2 border border-b-3 px-2 py-1 rounded-sm hover:bg-white border-transparent hover:border-gray-400 transition-colors duration-150 group">
          <x-lucide-credit-card class="h-4 w-4 text-green-600 group-hover:text-green-700" />
          <p class="text-sm text-gray-700 group-hover:text-gray-900">
            {{ __('Pricing') }}
          </p>
        </a>

        <a href="" class="flex items-center gap-x-2 border border-b-3 px-2 py-1 rounded-sm hover:bg-white border-transparent hover:border-gray-400 transition-colors duration-150 group">
          <x-lucide-book-open class="h-4 w-4 text-amber-600 group-hover:text-amber-700" />
          <p class="text-sm text-gray-700 group-hover:text-gray-900">
            {{ __('Docs') }}
          </p>
        </a>

        <a href="" class="flex items-center gap-x-2 border border-b-3 px-2 py-1 rounded-sm hover:bg-white border-transparent hover:border-gray-400 transition-colors duration-150 group">
          <x-lucide-users-2 class="h-4 w-4 text-rose-600 group-hover:text-rose-700" />
          <p class="text-sm text-gray-700 group-hover:text-gray-900">
            {{ __('Community') }}
          </p>
        </a>

        <a href="" class="flex items-center gap-x-2 border border-b-3 px-2 py-1 rounded-sm hover:bg-white border-transparent hover:border-gray-400 transition-colors duration-150 group">
          <x-lucide-building class="h-4 w-4 text-indigo-600 group-hover:text-indigo-700" />
          <p class="text-sm text-gray-700 group-hover:text-gray-900">
            {{ __('Company') }}
          </p>
        </a>
      </div>
    </div>

    <!-- Right side - user menu -->
    @if (Auth::check())
      <div class="relative ms-3 flex items-center gap-x-3">
        <x-lucide-bell class="h-4 w-4 text-gray-500" />

        <x-dropdown align="right" width="48">
          <x-slot name="trigger">
            <button class="flex rounded-full border-2 border-transparent text-sm transition focus:border-gray-300 focus:outline-hidden">
              <img class="h-8 w-8 rounded-full object-cover p-[0.1875rem] ring-1 shadow-sm ring-slate-900/10" src="{{ Auth::user()->getAvatar(64) }}" alt="{{ Auth::user()->name }}" />
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
    @else
      <div class="flex items-center gap-x-3">
        <a href="{{ route('login') }}" class="text-sm text-gray-700">
          {{ __('Sign in') }}
        </a>
      </div>
    @endif
  </nav>
</div>
