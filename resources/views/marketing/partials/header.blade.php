<div class="w-full" x-data="{ mobileMenuOpen: false }">
  <!-- main nav -->
  <nav class="max-w-8xl mx-auto flex h-12 items-center justify-between border-b border-gray-300 bg-zinc-100 px-3 sm:px-6 dark:border-slate-600 dark:bg-gray-800 dark:text-slate-200">
    <!-- Logo -->
    <div class="flex items-center">
      <a href="{{ route('marketing.index') }}" class="group flex items-center gap-x-2 transition-transform ease-in-out">
        <div class="flex h-7 w-7 items-center justify-center transition-all duration-400 group-hover:-translate-y-0.5 group-hover:-rotate-3">
          <img src="{{ asset('marketing/logo.png') }}" alt="PeopleOS logo" width="25" height="25" srcset="{{ asset('marketing/logo.png') }} 1x, {{ asset('marketing/logo@2x.png') }} 2x" />
        </div>
        <span class="text-lg font-semibold text-gray-900 dark:text-white">{{ config('app.name') }}</span>
      </a>
    </div>

    <!-- Mobile menu button -->
    <div class="flex lg:hidden">
      <button type="button" @click="mobileMenuOpen = !mobileMenuOpen" class="inline-flex items-center justify-center rounded-md p-2 text-gray-700">
        <span class="sr-only">Open main menu</span>
        <x-lucide-menu class="h-6 w-6" x-show="!mobileMenuOpen" />
        <x-lucide-x class="h-6 w-6" x-show="mobileMenuOpen" />
      </button>
    </div>

    <!-- Main navigation - centered (hidden on mobile) -->
    <div class="hidden flex-1 justify-center lg:flex">
      <div class="flex items-center gap-x-2">
        <a href="{{ route('marketing.why.index') }}" class="group flex items-center gap-x-2 rounded-sm border border-b-3 border-transparent px-2 py-1 transition-colors duration-150 hover:border-gray-400 hover:bg-white">
          <x-lucide-message-circle-question class="h-4 w-4 text-blue-600 group-hover:text-blue-700" />
          <p class="text-sm text-gray-700 group-hover:text-gray-900">
            {{ __('Why PeopleOS') }}
          </p>
        </a>

        <a href="{{ route('persons.index') }}" class="group flex items-center gap-x-2 rounded-sm border border-b-3 border-transparent px-2 py-1 transition-colors duration-150 hover:border-gray-400 hover:bg-white">
          <x-lucide-layout-grid class="h-4 w-4 text-purple-600 group-hover:text-purple-700" />
          <p class="text-sm text-gray-700 group-hover:text-gray-900">
            {{ __('Features') }}
          </p>
        </a>

        <a href="{{ route('marketing.pricing.index') }}" class="group flex items-center gap-x-2 rounded-sm border border-b-3 border-transparent px-2 py-1 transition-colors duration-150 hover:border-gray-400 hover:bg-white">
          <x-lucide-credit-card class="h-4 w-4 text-green-600 group-hover:text-green-700" />
          <p class="text-sm text-gray-700 group-hover:text-gray-900">
            {{ __('Pricing') }}
          </p>
        </a>

        <a href="{{ route('marketing.docs.index') }}" class="group flex items-center gap-x-2 rounded-sm border border-b-3 border-transparent px-2 py-1 transition-colors duration-150 hover:border-gray-400 hover:bg-white">
          <x-lucide-book-open class="h-4 w-4 text-amber-600 group-hover:text-amber-700" />
          <p class="text-sm text-gray-700 group-hover:text-gray-900">
            {{ __('Docs') }}
          </p>
        </a>

        <a href="" class="group flex items-center gap-x-2 rounded-sm border border-b-3 border-transparent px-2 py-1 transition-colors duration-150 hover:border-gray-400 hover:bg-white">
          <x-lucide-users-2 class="h-4 w-4 text-rose-600 group-hover:text-rose-700" />
          <p class="text-sm text-gray-700 group-hover:text-gray-900">
            {{ __('Community') }}
          </p>
        </a>

        <a href="{{ route('marketing.company.index') }}" class="group flex items-center gap-x-2 rounded-sm border border-b-3 border-transparent px-2 py-1 transition-colors duration-150 hover:border-gray-400 hover:bg-white">
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
        <a href="{{ route('login') }}" class="group flex items-center gap-x-2 rounded-sm border border-b-3 px-2 py-1 transition-colors duration-150 border-gray-400 hover:bg-white">
          <x-lucide-door-open class="h-4 w-4 text-gray-500" />
          {{ __('Go to your account') }}
        </a>

        <x-lucide-bell class="h-4 w-4 text-gray-500" />

        <x-dropdown align="right" width="48">
          <x-slot name="trigger">
            <button class="flex rounded-full border-2 border-transparent text-sm transition focus:border-gray-300 focus:outline-hidden">
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
    @else
      <div class="flex items-center gap-x-5">
        <a href="{{ route('login') }}" class="text-sm text-gray-700">
          {{ __('Sign in') }}
        </a>
        <a href="{{ route('register') }}" class="rounded-md bg-blue-600 px-3.5 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-offset-2 focus-visible:outline-blue-600">
          {{ __('Get started') }}
        </a>
      </div>
    @endif
  </nav>

  <!-- Mobile menu (off-canvas) -->
  <div x-show="mobileMenuOpen" class="lg:hidden" style="display: none">
    <div class="fixed inset-0 z-50"></div>
    <div class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-white px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10">
      <!-- Add this button for closing -->
      <div class="mb-4 flex justify-end">
        <button @click="mobileMenuOpen = false" class="rounded-md p-2 text-gray-500 hover:bg-gray-100">
          <x-lucide-x class="h-6 w-6" />
          <span class="sr-only">Close menu</span>
        </button>
      </div>

      <div class="flex flex-col gap-y-4">
        @if (Auth::check())
          <a href="{{ route('login') }}" class="flex items-center gap-x-2 py-2 text-base leading-7 font-semibold text-gray-900">
            <x-lucide-user class="h-5 w-5 text-blue-600" />
            {{ __('Login to your account') }}
          </a>
        @endif

        <a href="{{ route('dashboard.index') }}" class="flex items-center gap-x-2 py-2 text-base leading-7 font-semibold text-gray-900">
          <x-lucide-message-circle-question class="h-5 w-5 text-blue-600" />
          {{ __('Why PeopleOS') }}
        </a>
        <a href="{{ route('persons.index') }}" class="flex items-center gap-x-2 py-2 text-base leading-7 font-semibold text-gray-900">
          <x-lucide-layout-grid class="h-5 w-5 text-purple-600" />
          {{ __('Products') }}
        </a>
        <a href="" class="flex items-center gap-x-2 py-2 text-base leading-7 font-semibold text-gray-900">
          <x-lucide-credit-card class="h-5 w-5 text-green-600" />
          {{ __('Pricing') }}
        </a>
        <a href="" class="flex items-center gap-x-2 py-2 text-base leading-7 font-semibold text-gray-900">
          <x-lucide-book-open class="h-5 w-5 text-amber-600" />
          {{ __('Docs') }}
        </a>
        <a href="" class="flex items-center gap-x-2 py-2 text-base leading-7 font-semibold text-gray-900">
          <x-lucide-users-2 class="h-5 w-5 text-rose-600" />
          {{ __('Community') }}
        </a>
        <a href="" class="flex items-center gap-x-2 py-2 text-base leading-7 font-semibold text-gray-900">
          <x-lucide-building class="h-5 w-5 text-indigo-600" />
          {{ __('Company') }}
        </a>
      </div>
    </div>
  </div>
</div>
