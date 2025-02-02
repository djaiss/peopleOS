<div class="pointer-events-none fixed bottom-0 z-50 flex w-full flex-col items-end p-4 sm:p-6 rtl:items-start">
  <div x-sync id="notifications" class="pointer-events-auto relative w-full max-w-xs transform transition duration-300 ease-in-out">
    @if ($message = Session::get('status'))
      <div x-data="{ show: true }" x-transition.duration.300ms x-show="show" x-init="setTimeout(() => (show = false), 3000)" x-transition:enter-start="translate-y-12 opacity-0" x-transition:enter-end="translate-y-0 opacity-100" x-transition:leave-end="scale-90 opacity-0" class="flex items-center gap-3 rounded-lg border border-green-100 bg-white p-4 text-green-700 shadow-lg">
        <div class="flex-shrink-0">
          <x-lucide-check-circle class="h-5 w-5 text-green-500" />
        </div>

        <div class="min-w-0 flex-1">
          <p class="text-sm font-medium">
            {{ $message }}
          </p>
        </div>
      </div>
    @endif
  </div>
</div>
