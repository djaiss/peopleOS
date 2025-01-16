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
      <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
        {{ __('Account Details') }}
      </h2>
    </div>
  </x-slot>

  <div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
      <!-- Account details - Paid version -->
      <div class="mb-6 overflow-hidden rounded-lg border border-gray-200 bg-white">
        <div class="flex items-start gap-6 p-6">
          <!-- Left column with account info -->
          <div class="flex-1">
            <div class="mb-4 flex items-center gap-2">
              <x-lucide-building class="h-5 w-5 text-gray-500" />
              <span class="font-mono text-sm text-gray-600">{{ __('Account ID:') }} 1234</span>
            </div>

            <div class="mb-4">
              <div class="flex items-center gap-3">
                <div class="h-8 w-8 rounded-full bg-gray-200">
                  <x-lucide-user class="h-8 w-8 p-1.5 text-gray-600" />
                </div>
                <div>
                  <p class="font-semibold">John Doe</p>
                  <p class="text-sm text-gray-600">john@example.com</p>
                  <p class="text-xs text-gray-500">{{ __('User ID:') }} 5678</p>
                </div>
              </div>
            </div>

            <div class="flex items-center gap-2 text-sm text-gray-600">
              <x-lucide-calendar class="h-4 w-4" />
              <span>{{ __('Created on March 15, 2024') }}</span>
            </div>
          </div>

          <!-- Right column with subscription status -->
          <div class="text-center">
            <div class="mb-2 inline-flex rounded-full bg-green-100 px-3 py-1">
              <div class="flex items-center gap-1">
                <x-lucide-check-circle class="h-4 w-4 text-green-600" />
                <span class="text-sm font-medium text-green-600">{{ __('Paid Account') }}</span>
              </div>
            </div>
            <p class="text-sm text-gray-600">{{ __('Next billing date:') }} April 15, 2024</p>
          </div>
        </div>
      </div>

      <!-- Account details - Unpaid version -->
      <div class="mb-6 overflow-hidden rounded-lg border border-gray-200 bg-white">
        <div class="flex items-start gap-6 p-6">
          <!-- Left column with account info -->
          <div class="flex-1">
            <div class="mb-4 flex items-center gap-2">
              <x-lucide-building class="h-5 w-5 text-gray-500" />
              <span class="font-mono text-sm text-gray-600">{{ __('Account ID:') }} 1234</span>
            </div>

            <div class="mb-4">
              <div class="flex items-center gap-3">
                <div class="h-12 w-12 rounded-full bg-gray-200">
                  <x-lucide-user class="h-12 w-12 p-2 text-gray-600" />
                </div>
                <div>
                  <p class="font-semibold">John Doe</p>
                  <p class="text-sm text-gray-600">john@example.com</p>
                  <p class="text-xs text-gray-500">{{ __('User ID:') }} 5678</p>
                </div>
              </div>
            </div>

            <div class="flex items-center gap-2 text-sm text-gray-600">
              <x-lucide-calendar class="h-4 w-4" />
              <span>{{ __('Created on March 15, 2024') }}</span>
            </div>
          </div>

          <!-- Right column with subscription status -->
          <div class="text-center">
            <div class="mb-2 inline-flex rounded-full bg-yellow-100 px-3 py-1">
              <div class="flex items-center gap-1">
                <x-lucide-alert-circle class="h-4 w-4 text-yellow-600" />
                <span class="text-sm font-medium text-yellow-600">{{ __('Trial Account') }}</span>
              </div>
            </div>
            <p class="text-sm text-gray-600">{{ __('Trial expires in:') }} 15 days</p>
          </div>
        </div>
      </div>

      <!-- Action Pane -->
      <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-3">
        <!-- Delete Account -->
        <button type="button" class="flex items-center justify-center gap-2 rounded-lg border border-red-200 bg-white px-4 py-3 text-sm font-medium text-red-600 shadow-sm transition hover:bg-red-50">
          <x-lucide-trash-2 class="h-4 w-4" />
          {{ __('Delete Account') }}
        </button>

        <!-- Give Free Account -->
        <button type="button" class="flex items-center justify-center gap-2 rounded-lg border border-green-200 bg-white px-4 py-3 text-sm font-medium text-green-600 shadow-sm transition hover:bg-green-50">
          <x-lucide-gift class="h-4 w-4" />
          {{ __('Give Free Account') }}
        </button>

        <!-- Deactivate Account -->
        <button type="button" class="flex items-center justify-center gap-2 rounded-lg border border-yellow-200 bg-white px-4 py-3 text-sm font-medium text-yellow-600 shadow-sm transition hover:bg-yellow-50">
          <x-lucide-ban class="h-4 w-4" />
          {{ __('Deactivate Account') }}
        </button>
      </div>

      <!-- Latest Actions -->
      <div class="overflow-hidden rounded-lg border border-gray-200 bg-white">
        <div class="border-b border-gray-200 px-6 py-4">
          <h3 class="text-lg font-semibold">{{ __('Latest Actions') }}</h3>
        </div>

        <div class="divide-y divide-gray-200">
          @for ($i = 0; $i < 10; $i++)
            <div class="flex items-center justify-between p-4">
              <div class="flex items-center gap-3">
                <x-lucide-activity class="h-4 w-4 text-gray-500" />
                <div>
                  <p class="flex items-center gap-1 text-sm">
                    <span class="font-semibold">John Doe</span>
                    <span class="text-gray-500">|</span>
                    <span class="font-mono text-xs">created_contact</span>
                  </p>
                  <p class="text-sm text-gray-600">Added a new contact: Jane Smith</p>
                </div>
              </div>
              <p class="font-mono text-xs text-gray-500">2 hours ago</p>
            </div>
          @endfor
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
