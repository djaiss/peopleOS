<?php
/*
 * @var array $gender
 */
?>

<form x-target="gender-{{ $gender['id'] }}" x-target.422="gender-{{ $gender['id'] }}" id="gender-{{ $gender['id'] }}" action="{{ route('administration.personalization.genders.update', $gender['id']) }}" method="POST" class="space-y-5 p-4 hover:bg-blue-50">
  @csrf
  @method('PUT')

  <div class="relative">
    <x-input-label for="name" :value="__('Name of the gender')" />
    <x-text-input value="{{ $gender['name'] }}" class="mt-1 block w-full" id="name" name="name" type="text" required />
    <x-input-error class="mt-2" :messages="$errors->get('name')" />
  </div>

  <div class="flex justify-between">
    <x-button.secondary x-target="gender-{{ $gender['id'] }}" href="{{ route('administration.personalization.index') }}">
      {{ __('Cancel') }}
    </x-button.secondary>

    <x-button.primary class="mr-2">
      {{ __('Save') }}
    </x-button.primary>
  </div>
</form>
