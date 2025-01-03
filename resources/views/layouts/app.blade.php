<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="shortcut icon" href="/logo.svg" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
  </head>
  <body class="font-sans antialiased">
    <div class="min-h-screen bg-slate-100 dark:bg-gray-900">
      @include('layouts.header')

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
      <x-toaster-hub />
    </div>

    @livewireScripts
  </body>
</html>
