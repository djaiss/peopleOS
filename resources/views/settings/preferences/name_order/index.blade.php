<div class="mb-16">
  <!-- title + cta -->
  <div class="mb-3 mt-8 items-center justify-between sm:mt-0 sm:flex">
    <h3 class="mb-4 flex font-semibold sm:mb-0">
      <span class="mr-2">👉</span>
      <span>
        {{ __('Customize how contacts should be displayed') }}
      </span>
    </h3>

    <x-button.secondary hx-get="{{ route('settings.preferences.name.edit') }}" hx-target="#edit-name-order" dusk="edit-name-order">
      {{ __('Edit') }}
    </x-button.secondary>
  </div>

  <!-- help text -->
  <div class="mb-6 flex rounded border bg-slate-50 px-3 py-2 text-sm dark:border-gray-700 dark:bg-slate-900">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 grow pe-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>

    <div>
      <p>
        {{ __('You can customize how contacts are displayed to suit your preferences or cultural norms. For instance, you might prefer James Bond instead of Bond, James.') }}
      </p>
    </div>
  </div>

  <div id="edit-name-order">
    @fragment('show')
      <div class="mb-6 rounded-lg border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-900">
        <p class="border-b border-gray-200 px-5 py-2 dark:border-gray-700">
          <span class="mb-2 block">{{ __('Current way of displaying contact names:') }}</span>
          <span class="mb-2 block rounded bg-slate-100 px-5 py-2 text-sm dark:bg-slate-900">{{ $view['name_order']['name_order'] }}</span>
        </p>
        <p class="example bg-orange-50 px-5 py-2 text-sm font-medium dark:bg-orange-900">
          <span class="font-light">{{ __('Contacts will be shown as follow:') }}</span>
          {{ $view['name_order']['name_example'] }}
        </p>
      </div>
    @endfragment
  </div>
</div>
