<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    @include('components.meta')

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
  </head>
  <body class="font-sans antialiased">
    <div class="{{ $classes }} min-h-screen dark:bg-gray-900">
      @include('layouts.header')

      <!-- Page Content -->
      <main>
        {{ $slot }}
      </main>

      @include('components.toaster')
    </div>
  </body>
</html>
