<?php
/*
 * @var int $totalAccounts
 * @var int $last30DaysAccounts
 * @var int $last7DaysAccounts
 * @var array $accounts
 */
?>

<x-app-layout>
  <!-- Admin Panel Indicator -->
  <div class="border-b border-yellow-200 bg-yellow-50">
    <div class="mx-auto flex max-w-7xl items-center justify-center gap-x-3 px-4 py-2 sm:px-6 lg:px-8">
      <x-lucide-shield class="h-4 w-4 text-yellow-600" />
      <span class="text-sm font-medium text-yellow-800">{{ __('Instance administration area') }}</span>
    </div>
  </div>

  <!-- Breadcrumb -->
  <nav class="border-b border-gray-200 bg-white">
    <div class="mx-auto flex max-w-7xl items-center gap-x-3 px-4 py-3 sm:px-6 lg:px-8">
      <div class="flex items-center gap-x-3 text-sm text-gray-500">
        <a href="{{ route('dashboard.index') }}" class="hover:text-gray-700">{{ __('Dashboard') }}</a>
        <x-lucide-chevron-right class="h-4 w-4" />
        <span class="text-gray-700">{{ __('Instance administration') }}</span>
      </div>
    </div>
  </nav>

  <div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
      <!-- Stats -->
      <div class="mb-8 grid grid-cols-1 gap-4 sm:grid-cols-3">
        <!-- Total Accounts -->
        <div class="rounded-lg border border-gray-200 bg-white p-4">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm text-gray-600">{{ __('Total Accounts') }}</p>
              <p class="text-2xl font-semibold">{{ $totalAccounts }}</p>
            </div>
            <div class="rounded-sm bg-green-100 p-2">
              <x-lucide-building class="h-5 w-5 text-green-600" />
            </div>
          </div>
        </div>

        <!-- New Accounts This Month -->
        <div class="rounded-lg border border-gray-200 bg-white p-4">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm text-gray-600">{{ __('New accounts last 30 days') }}</p>
              <p class="text-2xl font-semibold">{{ $last30DaysAccounts }}</p>
            </div>
            <div class="rounded-sm bg-blue-100 p-2">
              <x-lucide-calendar class="h-5 w-5 text-blue-600" />
            </div>
          </div>
        </div>

        <!-- New Accounts This Week -->
        <div class="rounded-lg border border-gray-200 bg-white p-4">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm text-gray-600">{{ __('New accounts last 7 days') }}</p>
              <p class="text-2xl font-semibold">{{ $last7DaysAccounts }}</p>
            </div>
            <div class="rounded-sm bg-purple-100 p-2">
              <x-lucide-trending-up class="h-5 w-5 text-purple-600" />
            </div>
          </div>
        </div>
      </div>

      <!-- Accounts List -->
      <div class="mb-8 overflow-hidden rounded-lg border border-gray-200 bg-white" x-data="{
        search: '',
        accounts: {{ \Illuminate\Support\Js::from($accounts) }},
      }">
        <!-- Search -->
        <div class="border-b border-gray-200 p-4">
          <div class="flex items-center justify-end">
            <div class="relative w-full sm:w-64">
              <x-lucide-search class="pointer-events-none absolute top-1/2 left-2 h-4 w-4 -translate-y-1/2 text-gray-500" />
              <x-text-input type="text" placeholder="{{ __('Search accounts...') }}" class="w-full border border-gray-300 bg-gray-100 py-1 pr-3 pl-8 text-sm focus:bg-white" x-model="search" />
            </div>
          </div>
        </div>

        <!-- Table Header -->
        <div class="hidden grid-cols-12 gap-4 border-b border-gray-200 bg-gray-50 p-4 text-sm font-semibold text-gray-600 sm:grid">
          <div class="col-span-1">{{ __('ID') }}</div>
          <div class="col-span-5">{{ __('Administrator') }}</div>
          <div class="col-span-3">{{ __('Last activity') }}</div>
          <div class="col-span-3">{{ __('Contacts') }}</div>
        </div>

        <!-- Table Body -->
        <div class="divide-y divide-gray-200">
          <template x-for="account in accounts" :key="account.id">
            <a :href="account.url" class="grid cursor-pointer grid-cols-1 gap-2 p-4 text-sm hover:bg-blue-50 sm:grid-cols-12 sm:gap-4 sm:p-3" x-show="
              search === '' ||
                account.name.toLowerCase().includes(search.toLowerCase()) ||
                account.email.toLowerCase().includes(search.toLowerCase()) ||
                account.id.toString().includes(search)
            ">
              <!-- Mobile Labels + Content -->
              <div class="col-span-1 flex items-center justify-between sm:block">
                <span class="font-semibold sm:hidden">ID:</span>
                <span class="font-mono" x-text="account.id"></span>
              </div>

              <div class="col-span-5">
                <div class="flex items-center gap-2">
                  <div class="h-6 w-6 rounded-full bg-gray-200 sm:h-8 sm:w-8">
                    <img class="h-8 w-8 rounded-full object-cover p-[0.1875rem] shadow-sm ring-1 ring-slate-900/10" :src="account.avatar" />
                  </div>
                  <div class="min-w-0 flex-1">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:gap-2">
                      <p class="truncate font-semibold" x-text="account.name"></p>
                      <p class="truncate text-gray-600" x-text="account.email"></p>
                      <p class="text-xs text-gray-500" x-text="`ID: ${account.id}`"></p>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-span-3 flex items-center justify-between sm:justify-start">
                <span class="font-semibold sm:hidden">Last Activity:</span>
                <div class="flex items-center gap-2">
                  <x-lucide-clock class="h-4 w-4 text-gray-500" />
                  <span x-text="account.last_activity_at"></span>
                </div>
              </div>

              <div class="col-span-3 flex items-center justify-between sm:justify-start">
                <span class="font-semibold sm:hidden">Contacts:</span>
                <div class="flex items-center gap-2">
                  <x-lucide-users class="h-4 w-4 text-gray-500" />
                  <span x-text="`${account.persons_count} contacts`"></span>
                </div>
              </div>
            </a>
          </template>

          <!-- Empty State -->
          <div class="p-8 text-center" x-show="
            ! accounts.some(
              (account) =>
                account.name.toLowerCase().includes(search.toLowerCase()) ||
                account.email.toLowerCase().includes(search.toLowerCase()) ||
                account.id.toString().includes(search),
            )
          ">
            <x-lucide-search class="mx-auto h-12 w-12 text-gray-400" />
            <h3 class="mt-2 text-sm font-semibold text-gray-900">{{ __('No results found') }}</h3>
            <p class="mt-1 text-sm text-gray-500">{{ __('We could not find anything with that term. Try searching for something else.') }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
