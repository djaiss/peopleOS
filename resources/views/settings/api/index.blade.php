<x-settings>
  <div class="border-b border-gray-200 pb-4">
    <h3 class="text-lg font-medium">{{ __('Manage your API keys') }}</h3>
    <p class="text-sm">{{ __('This is a list of all the keys that let you access your data through the API.') }}</p>
  </div>
  <div>
    <div class="mb-4 flex justify-end">
      <x-button.secondary hover href="{{ route('settings.api.new') }}">
        <span>{{ __('New key') }}</span>
      </x-button.secondary>
    </div>

    <!-- new key added, only displayed once -->
    @if (session('key'))
      <div class="mb-3 rounded-lg border-l-2 border-green-300 bg-green-50 p-4 dark:border-green-500 dark:bg-green-900">
        <div>
          <div class="mb-2 text-sm">
            {{ __('This is the key you just added. Make sure to copy it now, you won\'t be able to see it again.') }}
          </div>

          <div x-data="{
            link: '{{ session('key') }}',
            copied: false,
            timeout: null,
            copy() {
              $clipboard(this.link)
              this.copied = true
              clearTimeout(this.timeout)
              this.timeout = setTimeout(() => {
                this.copied = false
              }, 3000)
            },
          }" class="relative z-20 flex items-center">
            <button x-on:click="copy" x-on:click="copy" x-text="copied ? `Copied!` : `{{ session('key') }}`" class="group flex h-8 w-auto cursor-pointer items-center justify-center rounded-md border border-neutral-200/60 bg-white px-3 py-1 text-xs text-neutral-500 hover:bg-neutral-100 hover:text-neutral-600 focus:bg-white focus:outline-none active:bg-white">
              {{ session('key') }}
            </button>
          </div>
        </div>
      </div>
    @endif

    <div class="mb-4 rounded-lg border border-gray-200">
      @forelse ($tokens as $token)
        <div class="flex flex-col border-b border-b-gray-200 py-3 last:border-b-0 hover:bg-blue-50 first:hover:rounded-t-lg last:hover:rounded-b-lg sm:flex-row sm:items-center sm:justify-between sm:px-3 dark:hover:bg-gray-600">
          <div class="mb-2 flex items-center sm:mb-0">
            <x-lucide-key class="mr-1 h-4 w-4 text-gray-400 dark:text-gray-500" />
            <span class="font-mono text-sm">{{ $token['name'] }}</span>
          </div>

          <!-- actions -->
          <div class="flex text-sm">
            <div class="mr-2 text-gray-400">{{ $token['last_used'] }}</div>

            <div>
              <span id="bar" class="cursor-pointer text-red-600 underline hover:no-underline">{{ __('Revoke') }}</span>
            </div>
          </div>
        </div>
      @empty
        <div class="mb-4 rounded-md border border-gray-200 p-4">
          <p>{{ __('There are no API keys defined at the moment.') }}</p>
        </div>
      @endforelse
    </div>
  </div>
</x-settings>
