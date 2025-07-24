<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    @include('components.meta')

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- json-ld -->
    @yield('json-ld')
  </head>
  <body class="font-sans antialiased">
    <div class="min-h-screen bg-white dark:bg-gray-900">
      @include('marketing.partials.header')

      <!-- Page Content -->
      <main>
        {{ $slot }}
      </main>

      @include('marketing.partials.footer')
      @include('components.toaster')
    </div>
  </body>
</html>
