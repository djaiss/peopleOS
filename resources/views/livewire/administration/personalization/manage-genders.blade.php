<div x-data="{ shouldFocus: false }">
  <!-- header -->
  <div class="mb-8 border border-gray-200 bg-white sm:rounded-lg">
    <div class="flex items-center justify-between rounded-t-lg border-b border-gray-200 p-3 last:rounded-b-lg last:border-b-0 hover:bg-blue-50">
      @if ($genders->isEmpty())
        <p class="text-sm text-zinc-500">{{ __('No genders created') }}</p>
      @else
        <p class="text-sm text-zinc-500">{{ __(':count gender(s)', ['count' => $genders->count()]) }}</p>
      @endif

      <x-button.secondary wire:click="toggleAddMode" @click="shouldFocus = true" class="mr-2 text-sm">
        {{ __('New gender') }}
      </x-button.secondary>
    </div>

    @foreach ($genders as $gender)
      @if ($gender['id'] !== $editedGenderId)
        <div class="group flex items-center justify-between border-b border-gray-200 p-3 last:rounded-b-lg last:border-b-0">
          <div class="flex items-center justify-between gap-3">
            <div class="rounded bg-zinc-100 p-2">
              <x-lucide-building class="h-4 w-4 text-zinc-500" />
            </div>

            <div class="flex flex-col">
              <p class="text-sm font-semibold">{{ $gender['name'] }}</p>
            </div>
          </div>

          <div class="flex gap-2">
            <x-button.invisible wire:click="toggleEditMode({{ $gender['id'] }})" class="hidden text-sm group-hover:block">
              {{ __('Edit') }}
            </x-button.invisible>

            <x-button.invisible wire:click="delete({{ $gender['id'] }})" wire:confirm="{{ __('Are you sure you want to proceed? This can not be undone.') }}" class="hidden text-sm group-hover:block">
              {{ __('Delete') }}
            </x-button.invisible>
          </div>
        </div>
      @else
        <form wire:submit="update" class="space-y-5 p-4 hover:bg-blue-50">
          <div class="relative">
            <x-input-label for="name" :value="__('Name of the gender')" />
            <x-text-input wire:model="name" wire:keydown.escape="resetEdit" class="mt-1 block w-full" id="name" name="name" type="text" required autofocus data-1p-ignore />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
          </div>

          <div class="flex justify-between">
            <x-button.secondary wire:click="resetEdit">
              {{ __('Cancel') }}
            </x-button.secondary>

            <x-button.primary class="mr-2">
              {{ __('Save') }}
            </x-button.primary>
          </div>
        </form>
      @endif
    @endforeach

    <!-- add new gender -->
    @if ($addMode)
      <form wire:submit="store" class="space-y-5 p-4 hover:bg-blue-50">
        <div class="relative">
          <x-input-label for="name" :value="__('Name of the gender')" />
          <x-text-input wire:model="name" wire:keydown.escape="toggleAddMode" x-effect="if (shouldFocus) { $el.focus(); shouldFocus = false }" class="mt-1 block w-full" id="name" name="name" type="text" required data-1p-ignore />
          <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div class="flex justify-between">
          <x-button.secondary wire:click="toggleAddMode">
            {{ __('Cancel') }}
          </x-button.secondary>

          <x-button.primary class="mr-2">
            {{ __('Save') }}
          </x-button.primary>
        </div>
      </form>
    @endif
  </div>
</div>
