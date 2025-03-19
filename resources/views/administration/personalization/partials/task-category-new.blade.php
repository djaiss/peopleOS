<form x-target="category-list add-category-form" x-target.back="add-category-form" id="add-category-form" action="{{ route('administration.personalization.task-categories.create') }}" method="POST" class="space-y-5 rounded-t-lg border-b border-gray-200 p-4 last:rounded-b-lg hover:bg-blue-50">
  @csrf
  @method('POST')

  <div class="relative">
    <x-input-label for="name" :value="__('Name of the category')" />
    <x-text-input class="mt-1 block w-full" id="name" name="name" type="text" required />
    <x-input-error class="mt-2" :messages="$errors->get('name')" />
  </div>

  <div class="relative">
    <x-input-label for="color" :value="__('Color of the category')" />
    <x-text-input class="mt-1 block w-full" id="color" name="color" type="text" placeholder="bg-blue-500" required />
    <x-help class="mt-1 text-sm text-zinc-500">
      {!! __('The color of the category. Use the name of the color in <a href="https://tailwindcss.com/docs/colors" target="_blank" class="text-blue-500">Tailwind CSS</a>.') !!}
    </x-help>
    <x-input-error class="mt-2" :messages="$errors->get('color')" />
  </div>

  <div class="flex justify-between">
    <x-button.secondary x-target="add-category-form" href="{{ route('administration.personalization.index') }}">
      {{ __('Cancel') }}
    </x-button.secondary>

    <x-button.primary class="mr-2">
      {{ __('Save') }}
    </x-button.primary>
  </div>
</form>
