<x-app-layout>
  <!-- Admin Panel Indicator -->
  <div class="border-b border-yellow-200 bg-yellow-50">
    <div class="mx-auto flex max-w-7xl items-center justify-center gap-x-3 px-4 py-2 sm:px-6 lg:px-8">
      <x-lucide-shield class="h-4 w-4 text-yellow-600" />
      <span class="text-sm font-medium text-yellow-800">{{ __('Instance Administration Area') }}</span>
    </div>
  </div>

  <!-- Breadcrumb -->
  <nav class="border-b border-gray-200 bg-white">
    <div class="mx-auto flex max-w-7xl items-center gap-x-3 px-4 py-3 sm:px-6 lg:px-8">
      <div class="flex items-center gap-x-3 text-sm text-gray-500">
        <a wire:navigate href="{{ route('dashboard') }}" class="hover:text-gray-700">{{ __('Dashboard') }}</a>
        <x-lucide-chevron-right class="h-4 w-4" />
        <a wire:navigate href="{{ route('instance.index') }}" class="hover:text-gray-700">{{ __('Instance Administration') }}</a>
        <x-lucide-chevron-right class="h-4 w-4" />
        <span class="text-gray-700">{{ __('Account Details') }}</span>
      </div>
    </div>
  </nav>

  <x-slot name="header">
    <div class="flex items-center gap-x-3">
      <x-lucide-chevron-left class="h-5 w-5 text-gray-400" />
      <h2 class="text-xl leading-tight font-semibold text-gray-800 dark:text-gray-200">
        {{ __('Account Details') }}
      </h2>
    </div>
  </x-slot>

  <div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
      <!-- Account Information -->
      <div class="mb-6 overflow-hidden rounded-lg border border-gray-200 bg-white">
        <div class="flex items-center justify-between border-b border-gray-200 p-3">
          <span class="text-xs font-medium">{{ __('Account ID') }}</span>
          <span class="font-mono text-lg text-gray-900">{{ $account->id }}</span>
        </div>
        <div class="grid grid-cols-4 divide-x divide-gray-200">
          <!-- Created Date -->
          <div class="p-6">
            <div class="flex flex-col gap-2">
              <div class="flex items-center gap-2 text-gray-600">
                <x-lucide-calendar class="h-4 w-4" />
                <span class="text-xs font-medium">{{ __('Created On') }}</span>
              </div>
              <span class="font-mono text-gray-900">{{ $account->created_at->format('F d, Y') }}</span>
            </div>
          </div>

          <!-- Account Owner -->
          <div class="p-6">
            <div class="flex flex-col gap-3">
              <div class="flex items-center gap-2 text-gray-600">
                <x-lucide-user class="h-4 w-4" />
                <span class="text-xs font-medium">{{ __('Account Owner') }}</span>
              </div>
              <div class="flex items-center gap-3">
                <img class="h-10 w-10 rounded-full object-cover p-[0.1875rem] ring-1 shadow-sm ring-slate-900/10" src="{{ $firstUser->getAvatar(64) }}" alt="{{ $firstUser->name }}" />
                <div>
                  <p class="font-medium text-gray-900">{{ $firstUser->name }}</p>
                  <p class="text-sm text-gray-600">{{ $firstUser->email }}</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Last active -->
          <div class="p-6">
            <div class="flex flex-col gap-2">
              <div class="flex items-center gap-2 text-gray-600">
                <x-lucide-building class="h-4 w-4" />
                <span class="text-xs font-medium">{{ __('Last active date') }}</span>
              </div>
              <span class="font-mono text-gray-900">{{ $firstUser->last_activity_at->format('F d, Y') }}</span>
            </div>
          </div>

          <!-- Account Status -->
          <div class="p-6">
            <div class="flex flex-col gap-3">
              <div class="flex items-center gap-2 text-gray-600">
                <x-lucide-shield class="h-4 w-4" />
                <span class="text-xs font-medium">{{ __('Account Status') }}</span>
              </div>
              @if ($account->has_lifetime_access)
                <div>
                  <div class="inline-flex items-center gap-1.5 rounded-full bg-green-100 px-3 py-1">
                    <x-lucide-check-circle class="h-4 w-4 text-green-600" />
                    <span class="text-sm font-medium text-green-600">{{ __('Paid Account') }}</span>
                  </div>
                </div>
              @elseif ($firstUser->is_instance_admin)
                <div>
                  <div class="inline-flex items-center gap-1.5 rounded-full bg-green-100 px-3 py-1">
                    <x-lucide-check-circle class="h-4 w-4 text-green-600" />
                    <span class="text-sm font-medium text-green-600">{{ __('Instance administrator') }}</span>
                  </div>
                </div>
              @else
                <div class="space-y-1.5">
                  <div class="inline-flex items-center gap-1.5 rounded-full bg-yellow-100 px-3 py-1">
                    <x-lucide-clock class="h-4 w-4 text-yellow-600" />
                    <span class="text-sm font-medium text-yellow-600">{{ __('Trial account') }}</span>
                  </div>
                  <p class="text-sm text-gray-600">{{ $account->trial_ends_at->diffInDays() }} {{ __('days remaining') }}</p>
                </div>
              @endif
            </div>
          </div>
        </div>
      </div>

      <!-- Action Pane -->
      @if (! $firstUser->is_instance_admin && $firstUser->id !== Auth::id())
        <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-3">
          <!-- Delete Account -->
          <form onsubmit="return confirm('Are you absolutely sure? This action cannot be undone.')" action="{{ route('instance.destroy', $account) }}" method="post" class="w-full">
            @csrf
            @method('delete')
            <button type="submit" class="flex w-full cursor-pointer items-center justify-center gap-2 rounded-lg border border-red-200 bg-white px-4 py-3 text-sm font-medium text-red-600 shadow-xs transition hover:bg-red-50">
              <x-lucide-trash-2 class="h-4 w-4" />
              {{ __('Delete account') }}
            </button>
          </form>

          <!-- Give Free Account -->
          @if (! $account->has_lifetime_access)
            <button type="button" class="flex items-center justify-center gap-2 rounded-lg border border-green-200 bg-white px-4 py-3 text-sm font-medium text-green-600 shadow-xs transition hover:bg-green-50">
              <x-lucide-gift class="h-4 w-4" />
              {{ __('Give Free Account') }}
            </button>
          @endif

          <!-- Deactivate Account -->
          <button type="button" class="flex items-center justify-center gap-2 rounded-lg border border-yellow-200 bg-white px-4 py-3 text-sm font-medium text-yellow-600 shadow-xs transition hover:bg-yellow-50">
            <x-lucide-ban class="h-4 w-4" />
            {{ __('Deactivate Account') }}
          </button>
        </div>
      @else
        <div class="mb-6 rounded-lg border border-gray-200 bg-gray-50 p-4">
          <div class="flex items-center gap-x-3">
            <x-lucide-shield-alert class="h-5 w-5 text-gray-400" />
            <p class="text-sm text-gray-600">
              {{ __('No actions can be taken on this account as it belongs to an instance administrator or yourself.') }}
            </p>
          </div>
        </div>
      @endif

      <!-- Latest Actions -->
      <div class="overflow-hidden rounded-lg border border-gray-200 bg-white">
        <div class="border-b border-gray-200 px-4 py-3">
          <h3 class="text-lg font-semibold">{{ __('Latest actions') }}</h3>
        </div>

        <div class="divide-y divide-gray-200">
          @foreach ($logs as $log)
            <div class="flex items-center justify-between p-4">
              <div class="flex items-center gap-3">
                <x-lucide-activity class="h-4 w-4 text-gray-500" />
                <div>
                  <p class="flex items-center gap-1 text-sm">
                    <span class="font-semibold">{{ $log->user->name }}</span>
                    <span class="text-gray-500">|</span>
                    <span class="font-mono text-xs">{{ $log->action }}</span>
                  </p>
                  <p class="text-sm text-gray-600">{{ $log->description }}</p>
                </div>
              </div>
              <p class="font-mono text-xs text-gray-500">{{ $log->created_at->diffForHumans() }}</p>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
