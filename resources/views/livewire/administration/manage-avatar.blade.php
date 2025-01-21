<div class="mb-8">
  <div
    x-data="{
      isFlipped: false,
      frontHeight: 0,
      backHeight: 0,
      containerHeight: 0,
      init() {
        this.updateHeights()
        this.$watch('isFlipped', () => this.updateHeights())

        // Listen for the custom event from Livewire
        Livewire.on('avatar-updated', () => {
          this.isFlipped = false
        })
      },
      updateHeights() {
        this.frontHeight = this.$refs.frontFace.offsetHeight
        this.backHeight = this.$refs.backFace.offsetHeight
        this.containerHeight = this.isFlipped ? this.backHeight : this.frontHeight
      },
    }"
    class="perspective-1000 relative"
    :style="`height: ${containerHeight}px`">
    <div
      class="relative w-full transition-all duration-500"
      :class="{
        '[transform:rotateY(-180deg)_scale(1.0)]': isFlipped,
        '[transform:rotateY(0deg)_scale(1)]': !isFlipped
      }"
      style="transform-style: preserve-3d">
      <!-- Front face -->
      <div x-ref="frontFace" class="absolute w-full border border-gray-200 bg-white [backface-visibility:hidden] sm:rounded-lg">
        <div class="grid grid-cols-3 items-center rounded-t-lg p-3 last:rounded-b-lg hover:bg-blue-50">
          <img width="58" height="58" class="col-span-2 h-16 w-16 rounded-full object-cover p-[0.1875rem] shadow ring-1 ring-slate-900/10" src="{{ $avatarUrl }}" alt="{{ $user->name }}" wire:key="avatar-{{ $user->id }}" />
          <div class="justify-self-end">
            <x-button.invisible @click="isFlipped = true" class="text-sm">
              {{ __('Upload a new photo') }}
            </x-button.invisible>
          </div>
        </div>
      </div>

      <!-- Back face -->
      <div x-cloak x-ref="backFace" class="absolute w-full border border-gray-200 bg-white [backface-visibility:hidden] [transform:rotateY(-180deg)] sm:rounded-lg">
        <form wire:submit.prevent="store">
          <div class="flex flex-col justify-between">
            <div class="items-center rounded-t-lg p-3 hover:bg-blue-50">
              <input type="file" wire:model="photo" x-ref="photo" accept="image/jpeg,image/png,image/gif,image/webp,image/avif" />
              @error('photo')
                <div class="mt-2 space-y-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</div>
              @enderror
            </div>

            <div class="flex justify-between border-t border-gray-200 p-3">
              <x-button.secondary @click="isFlipped = false" class="mr-2">
                {{ __('Cancel') }}
              </x-button.secondary>

              <x-button.primary>
                {{ __('Save') }}
              </x-button.primary>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
