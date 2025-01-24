<div x-data="{
    shouldFocus: false,
    dragging: null,
    items: @entangle('genders'),
    init() {
        this.$watch('items', () => {
            this.updateOrder()
        })
    },
    updateOrder() {
        const positions = this.items.map((item, index) => ({
            id: item.id,
            order: index + 1
        }))
        @this.updatePosition(positions)
    }
}" class="mb-8 border border-gray-200 bg-white sm:rounded-lg">
  <!-- header -->
  <div class="flex items-center justify-between rounded-t-lg p-3 last:rounded-b-lg last:border-b-0 hover:bg-blue-50">
    @if ($genders->isEmpty())
      <p class="text-sm text-zinc-500">{{ __('No genders created') }}</p>
    @else
      <p class="text-sm text-zinc-500">{{ __(':count gender(s)', ['count' => $genders->count()]) }}</p>
    @endif

    <x-button.secondary wire:click="toggleAddMode" @click="shouldFocus = true" class="mr-2 text-sm">
      {{ __('New gender') }}
    </x-button.secondary>
  </div>

  <div class="divide-y divide-gray-200">
    <template x-if="items.length === 0">
      <div class="flex flex-col items-center justify-center p-6 text-center">
        <x-lucide-dna class="h-8 w-8 text-gray-400" />
        <h3 class="mt-2 text-sm font-semibold text-gray-900">{{ __('Genders represent the identify of a person.') }}</h3>
        <p class="mt-1 text-sm text-gray-500">{{ __('Get started by creating a new gender.') }}</p>
      </div>
    </template>

    <template x-for="(item, index) in items" :key="item.id">
      <div>
        <template x-if="item.id !== {{ $editedGenderId }}">
          <div
            draggable="true"
            @dragstart="dragging = index"
            @dragend="dragging = null"
            @dragover.prevent
            @dragenter.prevent="$el.classList.add('bg-blue-100', 'border-blue-300')"
            @dragleave.prevent="$el.classList.remove('bg-blue-100', 'border-blue-300')"
            @drop="
              if (dragging !== null) {
                const itemToMove = items[dragging];
                items.splice(dragging, 1);
                items.splice(index, 0, itemToMove);
                dragging = null;
                $el.classList.remove('bg-blue-100', 'border-blue-300');
              }
            "
            :class="{
              'opacity-50 bg-gray-50': dragging === index,
              'border-transparent': dragging !== index
            }"
            class="group flex items-center justify-between border-2 border-transparent p-3 transition-colors duration-200 last:rounded-b-lg">
            <div class="flex items-center justify-between gap-3">
              <div class="cursor-move rounded-sm bg-zinc-100 p-2">
                <x-lucide-grip-vertical class="h-4 w-4 text-zinc-500" />
              </div>
              <div class="flex flex-col">
                <p class="text-sm font-semibold" x-text="item.name"></p>
              </div>
            </div>

            <div class="flex gap-2">
              <x-button.invisible @click="$wire.toggleEditMode(item.id)" class="hidden text-sm group-hover:block">
                {{ __('Edit') }}
              </x-button.invisible>

              <x-button.invisible @click="confirm('{{ __('Are you sure you want to proceed? This can not be undone.') }}') ? $wire.delete(item.id) : false" class="hidden text-sm group-hover:block">
                {{ __('Delete') }}
              </x-button.invisible>
            </div>
          </div>
        </template>

        <template x-if="item.id === {{ $editedGenderId }}">
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
        </template>
      </div>
    </template>
  </div>

  <!-- add new gender -->
  @if ($addMode)
    <form wire:submit="store" class="space-y-5 border-t border-gray-200 p-4 hover:bg-blue-50">
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
