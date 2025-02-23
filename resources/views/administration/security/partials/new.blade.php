<form id="add-api-key-form" x-target="api-key-list add-api-key-form api-key-notification notifications" x-target.back="add-api-key-form" action="{{ route('administration.security.store') }}" method="POST" class="space-y-5 border-b border-gray-200 p-4 hover:bg-blue-50">
  @csrf

  <div class="relative">
    <x-input-label for="label" :value="__('Label for the API key')" />
    <x-text-input class="mt-1 block w-full" id="label" name="label" type="text" required autofocus />
    <x-input-error class="mt-2" :messages="$errors->get('label')" />
  </div>

  <div class="flex justify-between">
    <x-button.secondary href="{{ route('administration.security.index') }}" x-target="add-api-key-form">
      {{ __('Cancel') }}
    </x-button.secondary>

    <x-button.primary class="mr-2">
      {{ __('Save') }}
    </x-button.primary>
  </div>
</form>
