<x-app-layout>
  <div class="grid h-[calc(100vh-48px)] grid-cols-[280px_320px_1fr] divide-x divide-gray-200">
    <!-- Section A: Contact List -->
    <livewire:persons.show-person-list :persons="$persons" :person="$person" />

    <!-- Section B: Contact Overview -->
    @include('persons.partials.profile')

    <!-- Section C: Detail View -->
    <div class="h-[calc(100vh-48px)] overflow-y-auto bg-gray-50">
      <div class="p-6">
        <!-- Add Gift Section -->
        <div class="mb-6 rounded-lg border border-gray-200 bg-white">
          <div class="border-b border-gray-200 p-4">
            <h2 class="text-lg font-semibold">{{ __('Add a gift idea') }}</h2>
          </div>
          <div class="p-4">
            <form wire:submit="store">
              <!-- Gift name -->
              <div class="mb-4">
                <x-input-label for="name" :value="__('Gift name')" />
                <x-text-input wire:model="name" class="mt-1 block w-full" type="text" required />
              </div>

              <!-- Price -->
              <div class="mb-4">
                <x-input-label for="price" :value="__('Estimated price')" />
                <div class="relative mt-1 rounded-md shadow-xs">
                  <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <span class="text-gray-500 sm:text-sm">$</span>
                  </div>
                  <x-text-input wire:model="price" class="block w-full pl-7" type="number" step="0.01" />
                </div>
              </div>

              <!-- URL -->
              <div class="mb-4">
                <x-input-label for="url" :value="__('Link')" />
                <x-text-input wire:model="url" class="mt-1 block w-full" type="url" placeholder="https://" />
              </div>

              <!-- Description -->
              <div class="mb-4">
                <x-input-label for="description" :value="__('Description')" />
                <textarea wire:model="description" class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-hidden" rows="2"></textarea>
              </div>

              <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                  <!-- Occasion dropdown -->
                  <select wire:model="occasion" class="rounded-md border-gray-300 text-sm">
                    <option value="">{{ __('Select occasion') }}</option>
                    <option value="birthday">{{ __('Birthday') }}</option>
                    <option value="christmas">{{ __('Christmas') }}</option>
                    <option value="anniversary">{{ __('Anniversary') }}</option>
                  </select>

                  <!-- Gift status -->
                  <select wire:model="status" class="rounded-md border-gray-300 text-sm">
                    <option value="idea">{{ __('Gift idea') }}</option>
                    <option value="will_give">{{ __('Will give') }}</option>
                    <option value="received">{{ __('Received') }}</option>
                  </select>

                  <!-- Recipient -->
                  <select wire:model="recipient" class="rounded-md border-gray-300 text-sm">
                    <option value="">{{ __('For whom?') }}</option>
                    <option value="contact">John Doe</option>
                    <option value="emma">Emma (daughter)</option>
                    <option value="lucas">Lucas (son)</option>
                  </select>
                </div>

                <x-button.primary>{{ __('Save') }}</x-button.primary>
              </div>
            </form>
          </div>
        </div>

        <!-- Gift List -->
        <div class="rounded-lg border border-gray-200 bg-white">
          <div class="border-b border-gray-200 p-4">
            <h2 class="text-lg font-semibold">{{ __('Gift ideas') }}</h2>
          </div>

          <div class="divide-y divide-gray-200">
            <!-- Will give -->
            <div class="p-4">
              <div class="mb-2 flex items-center justify-between">
                <div class="flex items-center gap-3">
                  <span class="flex h-8 w-8 items-center justify-center rounded-full bg-green-100">
                    <x-lucide-gift class="h-4 w-4 text-green-600" />
                  </span>
                  <div>
                    <h3 class="font-medium">Nintendo Switch OLED</h3>
                    <p class="text-sm text-gray-600">For: Emma (daughter) • Christmas • $349.99</p>
                  </div>
                </div>
                <span class="rounded-full bg-green-100 px-2 py-1 text-xs font-medium text-green-800">Will give</span>
              </div>
              <p class="mt-2 text-sm text-gray-600">She's been asking for this for months. The white version would be perfect.</p>
              <a href="https://www.nintendo.com" class="mt-2 text-sm text-blue-600 hover:underline">View on Nintendo →</a>
            </div>

            <!-- Gift ideas -->
            <div class="p-4">
              <div class="mb-2 flex items-center justify-between">
                <div class="flex items-center gap-3">
                  <span class="flex h-8 w-8 items-center justify-center rounded-full bg-purple-100">
                    <x-lucide-gift class="h-4 w-4 text-purple-600" />
                  </span>
                  <div>
                    <h3 class="font-medium">AirPods Pro</h3>
                    <p class="text-sm text-gray-600">For: John Doe • Birthday • $249.00</p>
                  </div>
                </div>
                <span class="rounded-full bg-yellow-100 px-2 py-1 text-xs font-medium text-yellow-800">Gift idea</span>
              </div>
            </div>

            <!-- Received -->
            <div class="p-4">
              <div class="mb-2 flex items-center justify-between">
                <div class="flex items-center gap-3">
                  <span class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-100">
                    <x-lucide-gift class="h-4 w-4 text-blue-600" />
                  </span>
                  <div>
                    <h3 class="font-medium">Coffee Machine</h3>
                    <p class="text-sm text-gray-600">From: John Doe • Christmas • $199.99</p>
                  </div>
                </div>
                <span class="rounded-full bg-blue-100 px-2 py-1 text-xs font-medium text-blue-800">Received</span>
              </div>
              <p class="mt-2 text-sm text-gray-600">A wonderful Nespresso machine that makes perfect coffee every time.</p>
            </div>

            <!-- More gift ideas -->
            <div class="p-4">
              <div class="mb-2 flex items-center justify-between">
                <div class="flex items-center gap-3">
                  <span class="flex h-8 w-8 items-center justify-center rounded-full bg-purple-100">
                    <x-lucide-gift class="h-4 w-4 text-purple-600" />
                  </span>
                  <div>
                    <h3 class="font-medium">Kindle Paperwhite</h3>
                    <p class="text-sm text-gray-600">For: Lucas (son) • Birthday • $139.99</p>
                  </div>
                </div>
                <span class="rounded-full bg-yellow-100 px-2 py-1 text-xs font-medium text-yellow-800">Gift idea</span>
              </div>
            </div>

            <div class="p-4">
              <div class="mb-2 flex items-center justify-between">
                <div class="flex items-center gap-3">
                  <span class="flex h-8 w-8 items-center justify-center rounded-full bg-purple-100">
                    <x-lucide-gift class="h-4 w-4 text-purple-600" />
                  </span>
                  <div>
                    <h3 class="font-medium">LEGO Star Wars Set</h3>
                    <p class="text-sm text-gray-600">For: Emma (daughter) • Birthday • $79.99</p>
                  </div>
                </div>
                <span class="rounded-full bg-yellow-100 px-2 py-1 text-xs font-medium text-yellow-800">Gift idea</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
