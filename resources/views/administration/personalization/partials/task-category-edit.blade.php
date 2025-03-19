<?php
/*
 * @var array $taskCategory
 */
?>

<form x-target="task-category-{{ $taskCategory['id'] }}" x-target.back="task-category-{{ $taskCategory['id'] }}" id="task-category-{{ $taskCategory['id'] }}" action="{{ route('administration.personalization.task-categories.update', $taskCategory['id']) }}" method="POST" class="space-y-5 p-4 hover:bg-blue-50">
  @csrf
  @method('PUT')

  <div class="relative">
    <x-input-label for="name" :value="__('Name of the task category')" />
    <x-text-input value="{{ $taskCategory['name'] }}" class="mt-1 block w-full" id="name" name="name" type="text" required />
    <x-input-error class="mt-2" :messages="$errors->get('name')" />
  </div>

  <div class="relative">
    <x-input-label for="color" :value="__('Color')" />
    <x-text-input value="{{ $taskCategory['color'] }}" class="mt-1 block w-full" id="color" name="color" type="text" required />
    <x-help class="mt-1 text-sm text-zinc-500">
      {!! __('The color of the category. Use the name of the color in <a href="https://tailwindcss.com/docs/colors" target="_blank" class="text-blue-500">Tailwind CSS</a>.') !!}
    </x-help>
    <x-input-error class="mt-2" :messages="$errors->get('color')" />
  </div>

  <div class="flex justify-between">
    <x-button.secondary x-target="task-category-{{ $taskCategory['id'] }}" href="{{ route('administration.personalization.index') }}">
      {{ __('Cancel') }}
    </x-button.secondary>

    <x-button.primary class="mr-2">
      {{ __('Save') }}
    </x-button.primary>
  </div>
</form>
