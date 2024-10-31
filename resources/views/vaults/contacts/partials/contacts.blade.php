<?php
/**
 * @var array $routes
 * @var array $contacts
 */
?>

<div x-data="{
  search: '',
  items: {{ $contacts }},
  get filteredItems() {
    return this.items.filter((contact) =>
      contact.name.toLowerCase().includes(this.search.toLowerCase()),
    )
  },
}" class="flex flex-col overflow-hidden rounded-lg border border-gray-200 bg-white shadow-md">
  <div class="border-b border-b-gray-100 px-2 py-2">
    <x-button.primary hover href="{{ $routes['contact']['new'] }}" class="flex w-full items-center" dusk="create-contact-button">
      <x-lucide-plus class="mr-2 h-4 w-4" />

      {{ __('Create a contact') }}
    </x-button.primary>
  </div>

  <div class="border-b border-b-gray-100 px-2 pb-1 pt-1">
    <x-text-input x-model="search" type="text" placeholder="{{ __('Search contacts') }}" class="w-full py-1 text-sm" />
  </div>

  <div class="flex-grow overflow-auto">
    <ul>
      <template x-for="item in filteredItems" :key="item.id">
        <li class="border-b border-b-gray-100 px-3 py-1 hover:bg-gray-50">
          <x-link @click="window.location.href = item.routes.show" x-text="item.name" x-bind:href="item.routes.show" class="block cursor-pointer text-blue-500 hover:text-blue-700"></x-link>
        </li>
      </template>
    </ul>
  </div>
</div>
