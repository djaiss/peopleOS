<?php
/*
 * @var array $maritalStatus
 */
?>

<form x-target="marital-status-{{ $maritalStatus['id'] }}" x-target.422="marital-status-{{ $maritalStatus['id'] }}" id="marital-status-{{ $maritalStatus['id'] }}" action="{{ route('administration.personalization.marital-statuses.update', $maritalStatus['id']) }}" method="POST" class="space-y-5 p-4 hover:bg-blue-50">
  @csrf
  @method('PUT')

  <div class="relative">
    <x-input-label for="name" :value="__('Name of the marital status')" />
    <x-text-input value="{{ $maritalStatus['name'] }}" class="mt-1 block w-full" id="name" name="name" type="text" required />
    <x-input-error class="mt-2" :messages="$errors->get('name')" />
  </div>

  <div class="flex justify-between">
    <x-button.secondary x-target="marital-status-{{ $maritalStatus['id'] }}" href="{{ route('administration.personalization.index') }}">
      {{ __('Cancel') }}
    </x-button.secondary>

    <x-button.primary class="mr-2">
      {{ __('Save') }}
    </x-button.primary>
  </div>
</form>
