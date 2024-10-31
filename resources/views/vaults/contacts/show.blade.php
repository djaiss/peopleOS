<x-app-layout :vault="$vault">
  <main class="relative sm:mt-12">
    <div class="mx-auto max-w-7xl px-2 py-2 sm:px-0 sm:py-0">
      <div class="contact-vault-list grid grid-cols-3 gap-6">
        <!-- left -->
        @include('vaults.contacts.partials.contacts', ['contacts' => $contacts])

        <!-- middle -->
        <div>
          <!-- name -->
          <div class="mb-8 rounded-lg border border-gray-200 bg-gray-50 p-3 text-sm dark:border-gray-700 dark:bg-gray-900">
            <!-- name and avatar -->
            <div class="flex">
              <!-- avatar -->
              <div class="flex justify-center px-3">
                <div class="h-12 w-12 rounded-full">
                  {!! $contact['avatar']['content'] !!}
                </div>
              </div>

              <div class="flex-grow">
                <!-- name -->
                <div class="mb-3 text-xl">
                  {{ $contact['name'] }}
                  <span class="text-sm text-gray-500">29</span>
                </div>

                <!-- work information -->
                @include('vaults.contacts.partials.job_information', ['vault' => $vault, 'contact' => $contact, 'companies' => $companies])

                <!-- background info -->
                @include('vaults.contacts.partials.background_information', ['vault' => $vault, 'contact' => $contact])

                <!-- tags -->
                <div>
                  <span class="me-2 rounded bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800 dark:bg-blue-900 dark:text-blue-300">Default</span>
                  <span class="me-2 rounded bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-800 dark:bg-gray-700 dark:text-gray-300">Dark</span>
                  <span class="me-2 rounded bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800 dark:bg-red-900 dark:text-red-300">Red</span>
                  <span class="me-2 rounded bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800 dark:bg-green-900 dark:text-green-300">Green</span>
                  <span class="me-2 rounded bg-yellow-100 px-2.5 py-0.5 text-xs font-medium text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300">Yellow</span>
                  <span class="me-2 rounded bg-indigo-100 px-2.5 py-0.5 text-xs font-medium text-indigo-800 dark:bg-indigo-900 dark:text-indigo-300">Indigo</span>
                  <span class="me-2 rounded bg-purple-100 px-2.5 py-0.5 text-xs font-medium text-purple-800 dark:bg-purple-900 dark:text-purple-300">Purple</span>
                  <span class="me-2 rounded bg-pink-100 px-2.5 py-0.5 text-xs font-medium text-pink-800 dark:bg-pink-900 dark:text-pink-300">Pink</span>
                </div>
              </div>
            </div>
          </div>

          <div class="contact-note grid grid-cols-2 gap-6">
            <div>
              <!-- spouse -->
              <div class="relative mb-8 rounded-lg border border-gray-200 bg-gray-50 p-3 dark:border-gray-700 dark:bg-gray-900">
                <div class="absolute -top-4 w-full">
                  <div class="flex justify-between">
                    <div class="flex items-center rounded-full border bg-white py-1 pl-2 pr-3 text-sm">
                      <svg class="mr-2 text-gray-500" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 3h12l4 6-10 13L2 9Z" />
                        <path d="M11 3 8 9l4 13 4-13-3-6" />
                        <path d="M2 9h20" />
                      </svg>
                      <div>Love</div>
                    </div>

                    <div class="button -left-6 flex cursor-pointer items-center rounded border bg-white text-sm">
                      <x-lucide-plus class="h-4 w-4" />
                    </div>
                  </div>
                </div>

                <ul class="mt-2">
                  <li>
                    Regis
                    <span class="text-xs text-gray-600">(8)</span>
                  </li>
                  <li>
                    Lorraine
                    <span class="text-xs text-gray-600">(8)</span>
                  </li>
                </ul>
              </div>

              <!-- kids -->
              @include('vaults.contacts.partials.kids')

              <!-- extended family -->
              <div class="group mb-8 flex items-center rounded-lg border border-gray-200 bg-gray-50 p-3 dark:border-gray-700 dark:bg-gray-900">
                <div class="-rotate-12 rounded border border-gray-200 bg-white p-1 transition group-hover:rotate-0">
                  <svg class="text-gray-500 group-hover:text-blue-300" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 18a2 2 0 0 0-2-2H9a2 2 0 0 0-2 2" />
                    <rect width="18" height="18" x="3" y="4" rx="2" />
                    <circle cx="12" cy="10" r="2" />
                    <line x1="8" x2="8" y1="2" y2="4" />
                    <line x1="16" x2="16" y1="2" y2="4" />
                  </svg>
                </div>
                <span class="ml-3 text-gray-500 group-hover:text-gray-800">Add extended family</span>
              </div>
            </div>

            <!-- notes -->
            <livewire:contacts.manage-notes lazy :contact-id="$contact['id']" />
          </div>
        </div>

        <!-- right -->
        <div class="">
          <!-- tasks -->
          <div class="relative mb-8 rounded-lg border border-gray-200 bg-gray-50 p-3 dark:border-gray-700 dark:bg-gray-900">
            <div class="absolute -top-4 w-full">
              <div class="flex justify-between">
                <div class="flex items-center rounded-full border bg-white py-1 pl-2 pr-3 text-sm">
                  {{-- <x-heroicon-o-clipboard-document-check class="mr-2 h-4 w-4 text-gray-500" /> --}}
                  <div>Tasks</div>
                </div>

                <div class="button -left-6 flex cursor-pointer items-center rounded border bg-white text-sm">
                  <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z" />
                    <path d="m15 5 4 4" />
                  </svg>
                </div>
              </div>
            </div>

            <div class="mt-2 text-sm">
              <div class="mb-2 flex">
                <input type="checkbox" class="focus:ring-3 relative top-1 h-4 w-4 rounded border border-gray-300 bg-gray-50 focus:ring-blue-300 dark:border-gray-700 dark:bg-gray-900 dark:ring-offset-gray-800 focus:dark:ring-blue-700" />
                <label class="ms-2 flex cursor-pointer text-gray-900 dark:text-gray-300">Commodo aliqua ipsum ullamco occaecat Lorem.</label>
              </div>
              <div class="flex">
                <input type="checkbox" class="focus:ring-3 relative top-1 h-4 w-4 rounded border border-gray-300 bg-gray-50 focus:ring-blue-300 dark:border-gray-700 dark:bg-gray-900 dark:ring-offset-gray-800 focus:dark:ring-blue-700" />
                <label class="ms-2 flex cursor-pointer text-gray-900 dark:text-gray-300">Commodo aliqua ipsum ullamco occaecat Lorem.</label>
              </div>
            </div>
          </div>

          <!-- information -->
          <div class="relative mb-3 rounded-lg border border-gray-200 bg-gray-50 p-3 dark:border-gray-700 dark:bg-gray-900">
            <div class="absolute -top-4 w-full">
              <div class="flex justify-between">
                <div class="flex items-center rounded-full border bg-white py-1 pl-2 pr-3 text-sm">
                  {{-- <x-lucide-clipboard-document-check class="mr-2 h-4 w-4 text-gray-500" /> --}}
                  <div>Personal info</div>
                </div>

                <div class="button -left-6 flex cursor-pointer items-center rounded border bg-white text-sm">
                  {{-- <x-heroicon-o-plus class="h-4 w-4" /> --}}
                </div>
              </div>
            </div>

            <ul class="mt-2 text-sm">
              <li class="mb-2">
                <x-link href="">lolo@gmail.com</x-link>
                <span class="text-sm text-gray-500">work</span>
              </li>
              <li class="mb-2">
                343-343-1244
                <span class="text-sm text-gray-500">cell</span>
              </li>
              <li>
                <p class="text-xs text-gray-500">Address</p>
                <p>123 rue Madeleine</p>
                <p>Montreal, QC</p>
              </li>
            </ul>
          </div>

          <!-- delete contact -->
          <form id="deleteContactForm" action="{{ route('vaults.contacts.destroy', ['vault' => $vault, 'slug' => $contact['slug']]) }}" method="POST" class="mb-1 px-5 py-2 text-center">
            @csrf
            @method('DELETE')

            <a onclick="event.preventDefault(); if(confirm('{{ __('Are you sure? This can not be undone.') }}')) document.getElementById('deleteContactForm').submit();" class="cursor-pointer text-sm text-red-600 underline hover:no-underline" dusk="link-delete-contact">
              {{ __('Delete contact') }}
            </a>
          </form>
        </div>
      </div>
    </div>
  </main>
</x-app-layout>
