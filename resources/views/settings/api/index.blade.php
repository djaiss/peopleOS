<x-app-layout>
  <x-slot name="breadcrumb">
    <div class="flex text-sm">
      <p class="mr-2">{{ __('You are here:') }}</p>
      <ul class="text-sm">
        <li class="inline after:text-xs after:text-gray-500 after:content-['>']">
          <x-link href="{{ route('settings.index') }}">
            {{ __('Settings') }}
          </x-link>
        </li>
        <li class="inline">
          {{ __('API') }}
        </li>
      </ul>
    </div>
  </x-slot>

  <main class="relative sm:mt-10">
    <div class="mx-auto max-w-7xl px-2 py-2 sm:px-0">
      <div class="hidden space-y-6 pb-16 md:block">
        <div class="space-y-0.5">
          <h2 class="text-2xl font-bold tracking-tight">{{ __('Settings') }}</h2>
          <p class="">{{ __('Manage your account settings.') }}</p>
        </div>

        <div class="flex flex-col space-y-8 bg-white shadow sm:rounded-lg lg:flex-row lg:space-x-12 lg:space-y-0">
          <aside class="px-4 lg:w-1/5">
            @include('settings.partials.navigation')
          </aside>
          <div class="flex-1 py-3 lg:max-w-2xl">
            <div class="space-y-6">
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
                        copyToClipboard() {
                          const el = document.createElement('textarea')
                          el.value = '{{ session('key') }}'
                          document.body.appendChild(el)
                          el.select()
                          document.execCommand('copy')
                          document.body.removeChild(el)
                        },
                      }">
                        <button @click="copyToClipboard()" class="group flex h-8 w-auto cursor-pointer items-center justify-center rounded-md border border-neutral-200/60 bg-white px-3 py-1 text-xs text-neutral-500 hover:bg-neutral-100 hover:text-neutral-600 focus:bg-white focus:outline-none active:bg-white">
                          {{ session('key') }}

                          <x-lucide-copy class="ml-1 h-4 w-4" />
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

                        <!-- revoke key -->
                        <form id="revokeKeyForm" action="{{ route('settings.api.destroy', ['key' => $token['id']]) }}" method="POST">
                          @csrf
                          @method('DELETE')

                          <a onclick="event.preventDefault(); if(confirm('{{ __('Are you sure? This can not be undone.') }}')) document.getElementById('revokeKeyForm').submit();" class="cursor-pointer text-sm text-red-600 underline hover:no-underline">
                            {{ __('Revoke key') }}
                          </a>
                        </form>
                      </div>
                    </div>
                  @empty
                    <div class="p-4">
                      <p>{{ __('There are no API keys defined at the moment.') }}</p>
                    </div>
                  @endforelse
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</x-app-layout>
