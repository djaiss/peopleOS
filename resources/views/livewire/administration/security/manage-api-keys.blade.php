<div>
  <!-- header -->
  <div class="mb-8 border border-gray-200 bg-white sm:rounded-lg">
    <div class="flex items-center justify-between rounded-t-lg border-b border-gray-200 p-3 last:rounded-b-lg last:border-b-0 hover:bg-blue-50">
      @if ($apiKeys->isEmpty())
        <p class="text-sm text-zinc-500">{{ __('No API keys created') }}</p>
      @else
        <p class="text-sm text-zinc-500">{{ __(':count API key(s) created', ['count' => $apiKeys->count()]) }}</p>
      @endif

      <x-button.secondary wire:click="toggleAddMode" class="mr-2 text-sm">
        {{ __('New API key') }}
      </x-button.secondary>
    </div>

    @foreach ($apiKeys as $apiKey)
      @if (! $apiKey['just_added'])
        <div class="group flex items-center justify-between border-b border-gray-200 p-3 last:rounded-b-lg last:border-b-0">
          <div class="flex items-center justify-between gap-3">
            <div class="rounded bg-zinc-100 p-2">
              <x-lucide-key class="h-4 w-4 text-zinc-500" />
            </div>

            <div class="flex flex-col">
              <p class="text-sm font-semibold">{{ $apiKey['name'] }}</p>
              <p class="font-mono text-xs text-zinc-500">{{ $apiKey['last_used'] }}</p>
            </div>
          </div>

          <x-button.invisible wire:click="delete({{ $apiKey['id'] }})" wire:confirm="{{ __('Are you sure you want to proceed? This can not be undone.') }}" class="hidden text-sm group-hover:block">
            {{ __('Delete') }}
          </x-button.invisible>
        </div>
      @else
        <div class="flex items-center justify-between border-b border-gray-200 p-3 last:rounded-b-lg last:border-b-0">
          <div class="flex items-center justify-between gap-3">
            <div class="rounded bg-zinc-100 p-2">
              <x-lucide-key class="h-4 w-4 text-zinc-500" />
            </div>

            <div class="flex flex-col">
              <div x-data="{
                copyToClipboard() {
                  const el = document.createElement('textarea')
                  el.value = '{{ $apiKey['token'] }}'
                  document.body.appendChild(el)
                  el.select()
                  document.execCommand('copy')
                  document.body.removeChild(el)
                },
              }">
                <button @click="copyToClipboard()" class="group flex h-8 w-auto cursor-pointer items-center justify-center rounded-md border border-neutral-200/60 bg-white px-3 py-1 text-xs text-neutral-500 hover:bg-neutral-100 hover:text-neutral-600 focus:bg-white focus:outline-none active:bg-white">
                  {{ $apiKey['token'] }}

                  <x-lucide-copy class="ml-1 h-4 w-4" />
                </button>
              </div>

              <p class="text-sm text-zinc-500">{{ __('You should copy this key now, as it will not be shown again.') }}</p>
            </div>
          </div>
        </div>
      @endif
    @endforeach

    <!-- add new API key -->
    @if ($addMode)
      <form wire:submit="store" class="space-y-5 p-4 hover:bg-blue-50">
        <div class="relative">
          <x-input-label for="label" :value="__('Label for the API key')" />
          <x-text-input wire:model="label" wire:keydown.escape="toggleAddMode" class="mt-1 block w-full" id="label" name="label" type="text" required autofocus />
          <x-input-error class="mt-2" :messages="$errors->get('label')" />
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
