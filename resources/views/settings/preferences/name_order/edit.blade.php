<form hx-put="{{ route('settings.preferences.name.update') }}" hx-target="#edit-name-order" method="POST" class="mb-6 rounded-lg border border-gray-200 bg-gray-50 dark:border-gray-700 dark:bg-gray-900">
  @csrf
  @method('PUT')

  <div x-data="{ selectedOption: false }" class="border-b border-gray-200 px-5 py-2 dark:border-gray-700">
    <div class="mb-2 flex items-center">
      <input id="first_name_last_name" x-model="selectedOption" @checked($view['name_order']['name_order'] == '%first_name% %last_name%') value="%first_name% %last_name%" name="name-order" type="radio" class="h-4 w-4 border-gray-300 text-sky-500 dark:border-gray-700" />
      <label for="first_name_last_name" class="ms-3 block cursor-pointer text-sm font-medium text-gray-700 dark:text-gray-300">
        {{ __('First name Last name') }}
        <span class="ms-4 font-normal text-gray-500">James Bond</span>
      </label>
    </div>
    <div class="mb-2 flex items-center">
      <input id="last_name_first_name" x-model="selectedOption" @checked($view['name_order']['name_order'] == '%last_name% %first_name%') value="%last_name% %first_name%" name="name-order" type="radio" class="h-4 w-4 border-gray-300 text-sky-500 dark:border-gray-700" />
      <label for="last_name_first_name" class="ms-3 block cursor-pointer text-sm font-medium text-gray-700 dark:text-gray-300">
        {{ __('Last name First name') }}

        <span class="ms-4 font-normal text-gray-500">Bond James</span>
      </label>
    </div>
    <div class="mb-2 flex items-center">
      <input id="first_name_last_name_nickname" x-model="selectedOption" @checked($view['name_order']['name_order'] == '%first_name% %last_name% (%nickname%)') value="%first_name% %last_name% (%nickname%)" name="name-order" type="radio" class="h-4 w-4 border-gray-300 text-sky-500 dark:border-gray-700" />
      <label for="first_name_last_name_nickname" class="ms-3 block cursor-pointer text-sm font-medium text-gray-700 dark:text-gray-300">
        {{ __('First name Last name (nickname)') }}
        <span class="ms-4 font-normal text-gray-500">James Bond (007)</span>
      </label>
    </div>
    <div class="mb-2 flex items-center">
      <input id="nickname" value="%nickname%" x-model="selectedOption" @checked($view['name_order']['name_order'] == '%nickname%') name="name-order" type="radio" class="h-4 w-4 border-gray-300 text-sky-500 dark:border-gray-700" />
      <label for="nickname" class="ms-3 block cursor-pointer text-sm font-medium text-gray-700 dark:text-gray-300">
        {{ __('nickname') }}
        <span class="ms-4 font-normal text-gray-500">007</span>
      </label>
    </div>
    <div class="mb-2 flex items-center">
      <input id="custom" value="custom" x-model="selectedOption" name="name-order" type="radio" class="h-4 w-4 border-gray-300 text-sky-500 dark:border-gray-700" />
      <label for="custom" class="ms-3 block cursor-pointer text-sm font-medium text-gray-700 dark:text-gray-300">
        {{ __('Custom name order') }}
      </label>
    </div>
    <div class="ml-8">
      <x-text-input x-bind:disabled="selectedOption !== 'custom'" class="mb-2 block w-full" name="name-order" :value="$view['name_order']['name_order']" />

      <p class="text-sm">
        <span class="mr-1">
          {{ __('Please read our documentation to know more about this feature, and which variables you have access to:') }}
          <x-link href="https://docs.monicahq.com/user-and-account-settings/manage-preferences#customize-contact-names">{{ __('link') }}</x-link>
        </span>
      </p>
    </div>
  </div>

  <!-- actions -->
  <div class="flex justify-between p-5">
    <x-button.secondary hx-get="{{ route('settings.preferences.name.index') }}" hx-target="#edit-name-order">
      {{ __('Cancel') }}
    </x-button.secondary>

    <x-button.primary dusk="name-order-save-form-button">
      {{ __('Save') }}
    </x-button.primary>
  </div>
</form>
