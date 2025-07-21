<x-app-layout>
  <div class="grid h-[calc(100vh-48px)] grid-cols-1 lg:grid-cols-[240px_1fr]">
    <!-- sidebar -->
    @include('administration.partials.sidebar')

    <!-- main content -->
    <div class="relative bg-gray-50 px-6 pt-8 lg:px-12">
      <div class="mx-auto max-w-2xl px-2 py-2 sm:px-0">
        <h1 class="font-semi-bold mb-4 text-2xl">
          {{ __('Export Account Data') }}
        </h1>

        <div class="mb-6">
          <h2 class="font-semi-bold mb-2 text-lg">{{ __('Data Export') }}</h2>
          <p class="mb-4 text-sm text-zinc-500">
            {{ __('Export all your account data including contacts, notes, tasks, journals, and more. The data will be exported in JSON format.') }}
          </p>
        </div>

        @if (session('status'))
          <div class="mb-4 rounded-md bg-green-50 p-4">
            <div class="flex">
              <div class="flex-shrink-0">
                <x-lucide-check-circle class="h-5 w-5 text-green-400" />
              </div>
              <div class="ml-3">
                <p class="text-sm font-medium text-green-800">
                  {{ session('status') }}
                </p>
                @if (session('download_path'))
                  <div class="mt-2">
                    <a href="{{ route('administration.export.download', ['file' => session('download_path')]) }}" 
                       class="text-sm text-green-600 hover:text-green-500">
                      {{ __('Download exported file') }}
                    </a>
                  </div>
                @endif
              </div>
            </div>
          </div>
        @endif

        @if (session('error'))
          <div class="mb-4 rounded-md bg-red-50 p-4">
            <div class="flex">
              <div class="flex-shrink-0">
                <x-lucide-x-circle class="h-5 w-5 text-red-400" />
              </div>
              <div class="ml-3">
                <p class="text-sm font-medium text-red-800">
                  {{ session('error') }}
                </p>
              </div>
            </div>
          </div>
        @endif

        <div class="mb-8 border border-gray-200 bg-white sm:rounded-lg">
          <div class="flex items-center justify-between rounded-t-lg border-b border-gray-200 p-3 last:rounded-b-lg last:border-b-0 hover:bg-blue-50">
            <div>
              <p class="text-sm font-medium text-gray-900">{{ __('Export Account Data') }}</p>
              <p class="text-sm text-zinc-500">{{ __('Generate a complete export of your account data') }}</p>
            </div>

            <form action="{{ route('administration.export.create') }}" method="post">
              @csrf
              <x-button.secondary type="submit" class="mr-2 text-sm">
                <x-lucide-download class="mr-2 h-4 w-4" />
                {{ __('Export Data') }}
              </x-button.secondary>
            </form>
          </div>
        </div>

        <div class="mb-6">
          <h3 class="font-semi-bold mb-2 text-lg">{{ __('What will be exported') }}</h3>
          <div class="grid grid-cols-1 gap-2 text-sm text-zinc-600">
            <div class="flex items-center gap-2">
              <x-lucide-check class="h-4 w-4 text-green-500" />
              <span>{{ __('Account information') }}</span>
            </div>
            <div class="flex items-center gap-2">
              <x-lucide-check class="h-4 w-4 text-green-500" />
              <span>{{ __('User profiles') }}</span>
            </div>
            <div class="flex items-center gap-2">
              <x-lucide-check class="h-4 w-4 text-green-500" />
              <span>{{ __('Contacts and their details') }}</span>
            </div>
            <div class="flex items-center gap-2">
              <x-lucide-check class="h-4 w-4 text-green-500" />
              <span>{{ __('Notes and comments') }}</span>
            </div>
            <div class="flex items-center gap-2">
              <x-lucide-check class="h-4 w-4 text-green-500" />
              <span>{{ __('Tasks and reminders') }}</span>
            </div>
            <div class="flex items-center gap-2">
              <x-lucide-check class="h-4 w-4 text-green-500" />
              <span>{{ __('Journal entries') }}</span>
            </div>
            <div class="flex items-center gap-2">
              <x-lucide-check class="h-4 w-4 text-green-500" />
              <span>{{ __('Encounters and interactions') }}</span>
            </div>
            <div class="flex items-center gap-2">
              <x-lucide-check class="h-4 w-4 text-green-500" />
              <span>{{ __('Addresses and locations') }}</span>
            </div>
            <div class="flex items-center gap-2">
              <x-lucide-check class="h-4 w-4 text-green-500" />
              <span>{{ __('Pets and children information') }}</span>
            </div>
            <div class="flex items-center gap-2">
              <x-lucide-check class="h-4 w-4 text-green-500" />
              <span>{{ __('Special dates and events') }}</span>
            </div>
            <div class="flex items-center gap-2">
              <x-lucide-check class="h-4 w-4 text-green-500" />
              <span>{{ __('Email history') }}</span>
            </div>
          </div>
        </div>

        <div class="rounded-md bg-blue-50 p-4">
          <div class="flex">
            <div class="flex-shrink-0">
              <x-lucide-info class="h-5 w-5 text-blue-400" />
            </div>
            <div class="ml-3">
              <h3 class="text-sm font-medium text-blue-800">{{ __('Important Notes') }}</h3>
              <div class="mt-2 text-sm text-blue-700">
                <ul class="list-disc space-y-1 pl-5">
                  <li>{{ __('The export process may take several minutes depending on the amount of data') }}</li>
                  <li>{{ __('Sensitive data is encrypted in the database and will be marked as such in the export') }}</li>
                  <li>{{ __('The exported file contains all your personal data - keep it secure') }}</li>
                  <li>{{ __('You can use this data for backup purposes or to migrate to another system') }}</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout> 