<h2 class="font-semi-bold mb-1 text-lg">{{ __('Your testimonial') }}</h2>
<p class="mb-4 text-sm text-zinc-500">{{ __('Love PeopleOS? We’d be thrilled if you could write a testimonial for us. It will appear on our marketing site, and you have full control over what information is displayed. You can also remove the testimonial at any time. Please note that all testimonials are reviewed before being published online.') }}</p>

<div class="mb-8 border border-gray-200 bg-white sm:rounded-lg">
  <div class="flex flex-col items-center justify-center p-6 text-center">
    <div class="mb-3 rounded-full bg-gray-100 p-3">
      <x-lucide-hand-metal class="h-6 w-6 text-gray-400" />
    </div>
    <h3 class="mt-2 text-sm font-semibold text-gray-900">{{ __('No testimonial yet') }}</h3>
    <p class="mt-1 mb-4 text-sm text-gray-500">{{ __('If you like this software, it would be awesome to write a testimony. It can be completely anonymous if you want.') }}</p>

    <a href="" class="cursor-pointer inline-flex items-center rounded-md border border-gray-300 bg-white px-3 py-1 font-semibold text-gray-700 hover:shadow-xs transition duration-150 ease-in-out text-center hover:bg-gray-50 focus:outline-hidden focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 mr-2 text-sm">{{ __('Write a testimonial') }}</a>
  </div>
</div>

<div class="mb-8 border border-gray-200 bg-white sm:rounded-lg p-4">
  <div class="flex items-center justify-between group">
    <div class="flex items-center gap-3">
      <div class="rounded-full bg-indigo-50 p-2">
        <x-lucide-hand-metal class="h-4 w-4 text-indigo-600" />
      </div>
      <div>
        <p class="text-sm text-gray-500">Testimony written on {{ date('F j, Y') }}</p>
      </div>
    </div>

    <!-- actions -->
    <div class="flex gap-2">
      <x-button.invisible x-target="" href="" class="hidden text-sm group-hover:block">
        {{ __('Edit') }}
      </x-button.invisible>

      <form x-target="" x-on:ajax:before="
        confirm('Are you sure you want to proceed? This can not be undone.') ||
          $event.preventDefault()
      " action="" method="POST">
        @csrf
        @method('DELETE')

        <x-button.invisible class="hidden text-sm group-hover:block">
          {{ __('Delete') }}
        </x-button.invisible>
      </form>
    </div>
  </div>

  <!-- testimonial -->
  <div>

    safsf
  </div>
</div>
