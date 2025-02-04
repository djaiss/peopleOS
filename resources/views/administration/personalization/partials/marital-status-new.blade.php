<form x-target="marital-status-list add-marital-status-form" x-target.422="add-marital-status-form" id="add-marital-status-form" action="{{ route('administration.personalization.marital-statuses.store') }}" method="POST" class="space-y-5 rounded-lg p-4 hover:bg-blue-50">
  @csrf
  @method('POST')

  <div class="relative">
    <x-input-label for="name" :value="__('Name of the marital status')" />
    <x-text-input class="mt-1 block w-full" id="name" name="name" type="text" required />
    <x-input-error class="mt-2" :messages="$errors->get('name')" />
  </div>

  <div class="flex justify-between">
    <x-button.secondary x-target="add-marital-status-form" href="{{ route('administration.personalization.index') }}">
      {{ __('Cancel') }}
    </x-button.secondary>

    <x-button.primary class="mr-2">
      {{ __('Save') }}
    </x-button.primary>
  </div>
</form>
