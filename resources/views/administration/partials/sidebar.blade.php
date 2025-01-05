<div class="border-r border-gray-300 bg-gray-100">
  <div class="flex flex-col px-6 pt-8">
    <!-- back to dashboard -->
    <a href="{{ route('dashboard') }}" class="mb-4">
      <div class="flex h-8 items-center justify-between gap-3 rounded-lg px-2 text-sm leading-5 text-zinc-600 hover:bg-zinc-950/5 hover:text-zinc-800 dark:text-zinc-400 dark:hover:bg-white/5 dark:hover:text-white">
        <div class="flex items-center gap-2">
          <x-lucide-chevron-left class="size-3 min-w-3" />
          <span>
            {{ __('Back to dashboard') }}
          </span>
        </div>
      </div>
    </a>

    <div class="flex flex-col gap-4">
      <div class="flex flex-col gap-0.5">
        <span class="tpx-2 py-1.5 text-xs font-semibold text-zinc-950/40 dark:text-white/40">
          {{ __('Your account') }}
        </span>
        <a wire:navigate href="{{ route('administration.index') }}">
          <div class="{{ request()->routeIs('administration.index') ? 'text-green-600 hover:bg-green-600/5 dark:text-green-500 dark:hover:bg-green-500/5' : 'text-zinc-600 hover:bg-zinc-950/5 hover:text-zinc-800 dark:text-zinc-400' }} flex h-8 items-center justify-between gap-3 rounded-lg px-2 text-sm leading-5 dark:hover:bg-white/5 dark:hover:text-white">
            <div class="flex items-center gap-2">
              <x-lucide-user class="size-4 min-w-3" />
              <span>
                {{ __('Profile') }}
              </span>
            </div>
          </div>
        </a>
        <a wire:navigate href="{{ route('administration.security.index') }}">
          <div class="{{ request()->routeIs('administration.security.index') ? 'text-green-600 hover:bg-green-600/5 dark:text-green-500 dark:hover:bg-green-500/5' : 'text-zinc-600 hover:bg-zinc-950/5 hover:text-zinc-800 dark:text-zinc-400 dark:hover:bg-white/5 dark:hover:text-white' }} flex h-8 items-center justify-between gap-3 rounded-lg px-2 text-sm leading-5">
            <div class="flex items-center gap-2">
              <x-lucide-shield-alert class="size-4 min-w-3" />
              <span>
                {{ __('Security & access') }}
              </span>
            </div>
          </div>
        </a>
      </div>
    </div>
  </div>
</div>
