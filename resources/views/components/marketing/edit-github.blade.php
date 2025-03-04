<div class="flex flex-col items-center justify-between rounded-lg border p-4 text-sm sm:flex-row">
  <div class="mb-4 sm:mb-0">
     @if ($lastModified = \App\Helpers\MarketingHelper::getLastModified(Route::current()->getName()))
    <p class="mb-1">{{ __('This page was last updated on :date.', ['date' => $lastModified->format('F j, Y')]) }}</p>
    @endif
    <a href="https://github.com/djaiss/peopleos" class="text-blue-600 hover:text-blue-500">Edit this page on Github</a>
  </div>

  <div class="flex flex-col gap-y-4 sm:flex-row sm:gap-x-4 sm:gap-y-0">
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
</div>
