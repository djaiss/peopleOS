<?php
/*
 * @var Person $person
 * @var Collection $addresses
 */
?>

<section class="mb-8">
  <div class="mb-4 flex items-center justify-between">
    <div class="flex items-center gap-2">
      <x-lucide-map-pin class="h-5 w-5 text-blue-500" />
      <h2 class="text-lg font-semibold text-gray-900">{{ __('Addresses') }}</h2>
    </div>
    <a x-target="new-address" href="{{ route('person.address.new', $person) }}" class="inline-flex items-center gap-1 rounded-md border border-transparent bg-blue-50 px-2 py-1 text-sm font-medium text-blue-600 hover:border-blue-300 hover:bg-blue-100">
      <x-lucide-plus class="h-4 w-4" />
      {{ __('Add address') }}
    </a>
  </div>

  <div id="new-address"></div>

  <div id="addresses-listing" class="rounded-lg border border-gray-200 bg-white">
    <div class="divide-y divide-gray-200">
      @forelse ($addresses as $address)
        <div id="address-{{ $address['id'] }}" class="group p-4">
          <div class="group flex items-center justify-between gap-3">
            <div class="min-w-0 flex-1">
              <div class="flex items-center gap-1 border border-transparent py-1 text-sm">
                @if ($address['address_line_1'])
                  <p class="truncate font-medium text-gray-900">{{ $address['address_line_1'] }}</p>
                @endif

                @if ($address['address_line_2'])
                  <span class="text-gray-500">•</span>
                  <span class="truncate text-gray-500">{{ $address['address_line_2'] }}</span>
                @endif

                @if ($address['city'])
                  <span class="text-gray-500">•</span>
                  <span class="truncate text-gray-500">{{ $address['city'] }}</span>
                @endif

                @if ($address['state'])
                  <span class="text-gray-500">•</span>
                  <span class="truncate text-gray-500">{{ $address['state'] }}</span>
                @endif

                @if ($address['postal_code'])
                  <span class="text-gray-500">•</span>
                  <span class="truncate text-gray-500">{{ $address['postal_code'] }}</span>
                @endif

                @if ($address['country'])
                  <span class="text-gray-500">•</span>
                  <span class="truncate text-gray-500">{{ $address['country'] }}</span>
                @endif

                @if (! $address['is_active'])
                  <span class="text-gray-500">•</span>
                  <span class="truncate text-gray-400 italic">{{ __('Inactive') }}</span>
                @endif
              </div>
            </div>
            <div class="flex items-center gap-2">
              <a x-target="address-{{ $address['id'] }}" href="{{ route('person.address.edit', ['slug' => $person->slug, 'address' => $address['id']]) }}" class="hidden text-sm group-hover:block">
                <x-button.invisible>
                  {{ __('Edit') }}
                </x-button.invisible>
              </a>
              <form x-target="current-address-{{ $address['id'] }} addresses-listing addresses-status" x-on:ajax:before="
                confirm('Are you sure you want to proceed? This can not be undone.') ||
                  $event.preventDefault()
              " action="{{ route('person.address.destroy', ['slug' => $person->slug, 'address' => $address['id']]) }}" method="POST">
                @csrf
                @method('DELETE')

                <x-button.invisible class="hidden text-sm group-hover:block">
                  {{ __('Delete') }}
                </x-button.invisible>
              </form>
            </div>
          </div>
        </div>
      @empty
        <div class="flex flex-col items-center justify-center p-8 text-center">
          <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-blue-100">
            <x-lucide-map-pin class="h-6 w-6 text-blue-600" />
          </div>

          <h3 class="mt-4 text-sm font-semibold text-gray-900">{{ __('No addresses recorded') }}</h3>
          <p class="mt-1 text-sm text-gray-500">{{ __('Keep track of addresses, past and present.') }}</p>

          <div class="mt-6">
            <a x-target="new-address" href="{{ route('person.address.new', $person) }}" class="inline-flex items-center gap-1 rounded-md bg-blue-50 px-3 py-2 text-sm font-medium text-blue-600 hover:bg-blue-100">
              <x-lucide-plus class="h-4 w-4" />
              {{ __('Add first address') }}
            </a>
          </div>
        </div>
      @endforelse
    </div>
  </div>
</section>
