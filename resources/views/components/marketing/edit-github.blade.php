<div class="flex flex-col justify-between rounded-lg border text-sm">
  <div class="mb-2 flex flex-col items-center justify-center gap-y-4 border-b border-gray-200 p-4 pb-4 sm:flex-row sm:gap-x-4 sm:gap-y-0">
    <a href="" class="group inline-flex items-center gap-x-2 rounded-sm border border-b-3 border-gray-400 px-3 py-2 transition-colors duration-150 hover:bg-white">
      <x-lucide-thumbs-up class="h-4 w-4 transform text-green-600 transition-transform group-hover:-rotate-12 group-hover:text-green-700" />
      <span class="text-sm text-gray-700 group-hover:text-gray-900">
        {{ __('This page is useful') }}
      </span>
    </a>
    <a href="" class="group inline-flex items-center gap-x-2 rounded-sm border border-b-3 border-gray-400 px-3 py-2 transition-colors duration-150 hover:bg-white">
      <x-lucide-thumbs-down class="h-4 w-4 transform text-red-600 transition-transform group-hover:rotate-12 group-hover:text-red-700" />
      <span class="text-sm text-gray-700 group-hover:text-gray-900">
        {{ __('This page is not useful') }}
      </span>
    </a>
  </div>

  <div class="flex items-center justify-between gap-x-4 p-4">
    @if ($lastModified = \App\Helpers\MarketingHelper::getLastModified(Route::current()->getName()))
      <p class="mb-1 flex items-center gap-x-1">
        <x-lucide-calendar class="h-4 w-4 text-gray-500" />
        <span class="text-gray-500">Last updated on</span>
        {{ $lastModified->format('F j, Y') }}.
      </p>
    @endif

    <div class="flex items-center gap-x-2">
      <x-lucide-github class="h-4 w-4 text-gray-500" />
      <a href="https://github.com/djaiss/peopleos" class="text-blue-600 hover:text-blue-500">Edit this page on Github</a>
    </div>
  </div>
</div>
