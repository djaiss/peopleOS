<div>
  <!-- header -->
  <div class="mb-8 border border-gray-200 bg-white sm:rounded-lg">
    <div class="flex items-center justify-between rounded-t-lg border-b border-gray-200 p-3 last:rounded-b-lg last:border-b-0 hover:bg-blue-50">
      @if ($offices->isEmpty())
        <p class="text-sm text-zinc-500">{{ __('No offices created') }}</p>
      @else
        <p class="text-sm text-zinc-500">{{ __(':count office(s)', ['count' => $offices->count()]) }}</p>
      @endif

      <x-button.secondary wire:click="toggleAddMode" class="mr-2 text-sm">
        {{ __('New office') }}
      </x-button.secondary>
    </div>

    @foreach ($offices as $office)
      @if ($office['id'] !== $editedOfficeId)
        <div class="group flex items-center justify-between border-b border-gray-200 p-3 last:rounded-b-lg last:border-b-0">
          <div class="flex items-center justify-between gap-3">
            <div class="rounded bg-zinc-100 p-2">
              <x-lucide-building class="h-4 w-4 text-zinc-500" />
            </div>

            <div class="flex flex-col">
              <p class="text-sm font-semibold">{{ $office['name'] }}</p>
            </div>
          </div>

          <div class="flex gap-2">
            <x-button.invisible wire:click="toggleEditMode({{ $office['id'] }})" class="hidden text-sm group-hover:block">
              {{ __('Edit') }}
            </x-button.invisible>

            <x-button.invisible wire:click="delete({{ $office['id'] }})" wire:confirm="{{ __('Are you sure you want to proceed? This can not be undone.') }}" class="hidden text-sm group-hover:block">
              {{ __('Delete') }}
            </x-button.invisible>
          </div>
        </div>
      @else
        <form wire:submit="update" class="space-y-5 p-4 hover:bg-blue-50">
          <div class="relative">
            <x-input-label for="name" :value="__('Name of the office')" />
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

    <!-- add new office -->
    @if ($addMode)
      <form wire:submit="store" class="space-y-5 p-4 hover:bg-blue-50">
        <div class="relative">
          <x-input-label for="name" :value="__('Name of the office')" />
          <x-text-input wire:model="name" wire:keydown.escape="toggleAddMode" class="mt-1 block w-full" id="name" name="name" type="text" required autofocus data-1p-ignore />
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
