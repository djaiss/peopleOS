<x-app-layout :vault="$vault">
  <main class="relative sm:mt-20">
    <div class="mx-auto max-w-7xl px-2 py-2 sm:px-0 sm:py-0">
      <div class="contact-vault-list grid grid-cols-3 gap-6">
        <!-- left -->
        <div x-data="{
          search: '',
          items: {{ $contacts }},
          get filteredItems() {
            return this.items.filter((contact) =>
              contact.name.toLowerCase().includes(this.search.toLowerCase()),
            )
          },
        }" class="flex flex-col overflow-hidden rounded-lg border border-gray-200">
          <div class="border-b border-b-gray-200 px-2 pb-1 pt-1">
            <x-text-input x-model="search" type="text" placeholder="Search contacts" class="w-full" />
          </div>

          <div class="flex-grow overflow-auto">
            <ul>
              <template x-for="item in filteredItems" :key="item.name">
                <li x-text="item.name" class="border-b border-b-gray-200 px-3 py-1"></li>
              </template>
            </ul>
          </div>
        </div>

        <!-- middle -->
        <div class="rounded-lg border border-gray-200 bg-gray-50 p-3 sm:px-3 sm:py-0 dark:border-gray-700 dark:bg-gray-900">sda</div>

        <!-- right -->
        <div class="p-3 sm:px-3 sm:py-0">we</div>
      </div>
    </div>
  </main>
</x-app-layout>
