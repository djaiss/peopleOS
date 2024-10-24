<x-app-layout :vault="$vault">
  <main class="relative sm:mt-12">
    <div class="mx-auto max-w-7xl px-2 py-2 sm:px-0 sm:py-0">
      <div class="contact-vault-list grid grid-cols-3 gap-6">
        <!-- left -->
        @include('vaults.contacts.partials.contacts', ['contacts' => $contacts])

        <!-- middle -->
        <div class="rounded-lg border border-gray-200 bg-gray-50 p-3 dark:border-gray-700 dark:bg-gray-900 sm:px-3 sm:py-0">sda</div>

        <!-- right -->
        <div class="p-3 sm:px-3 sm:py-0">we</div>
      </div>
    </div>
  </main>
</x-app-layout>
