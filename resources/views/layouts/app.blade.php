<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
  </head>
  <body class="font-sans antialiased">
    <div class="min-h-screen bg-white dark:bg-gray-900">
      @include('layouts.header')

      @if ($inVault)
        @include('layouts.navigation')
      @endif

      {{-- @include('layouts.navigation') --}}

      @isset($breadcrumb)
        <nav class="breadcrumb bg-white sm:border-b dark:bg-gray-900">
          <div class="max-w-8xl mx-auto hidden px-4 py-2 sm:px-6 md:block">
            <div class="flex items-baseline justify-between space-x-6">
              {{ $breadcrumb }}
            </div>
          </div>
        </nav>
      @endisset

      <!-- Page Content -->
      <main>
        {{ $slot }}
      </main>

      <!-- toaster -->
      @if (session('status'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => (show = false), 3000)" class="absolute bottom-12 right-10 mx-auto max-w-xl px-2 pt-6 sm:px-6 lg:px-8">
          <div class="flex items-center overflow-hidden rounded border border-green-600 bg-white pr-2 shadow-sm sm:rounded-lg dark:bg-gray-800">
            <div class="mr-2 bg-green-100 px-2 py-2">
              <x-heroicon-o-light-bulb class="h-5 w-5 text-green-500" />
            </div>

            <p>{{ session('status') }}</p>
          </div>
        </div>
      @endif
    </div>
  </body>
</html>
