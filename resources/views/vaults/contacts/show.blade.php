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
                      <x-heroicon-o-plus class="h-4 w-4" />
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
              <div class="relative mb-8 rounded-lg border border-gray-200 bg-gray-50 p-3 dark:border-gray-700 dark:bg-gray-900">
                <!-- plus button -->
                <div class="absolute -top-4 w-full">
                  <div class="flex justify-between">
                    <div class="flex items-center rounded-full border bg-white py-1 pl-2 pr-3 text-sm">
                      <svg class="mr-2 text-gray-500" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 12h.01" />
                        <path d="M15 12h.01" />
                        <path d="M10 16c.5.3 1.2.5 2 .5s1.5-.2 2-.5" />
                        <path d="M19 6.3a9 9 0 0 1 1.8 3.9 2 2 0 0 1 0 3.6 9 9 0 0 1-17.6 0 2 2 0 0 1 0-3.6A9 9 0 0 1 12 3c2 0 3.5 1.1 3.5 2.5s-.9 2.5-2 2.5c-.8 0-1.5-.4-1.5-1" />
                      </svg>
                      <div>Kids</div>
                    </div>

                    <div class="button -left-6 flex cursor-pointer items-center rounded border bg-white text-sm">
                      <x-heroicon-o-plus class="h-4 w-4" />
                    </div>
                  </div>
                </div>

                <!-- add kid form -->
                <div>
                  <!-- choose gender -->
                  <div class="mb-2 mt-4 grid grid-cols-3 space-x-2">
                    <div class="flex flex-col items-center rounded-lg border border-gray-200 py-3">
                      <input type="radio" class="mb-1" />
                      <span class="text-2xl">
                        <svg class="h-6 w-6" viewBox="0 0 36 36" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" preserveAspectRatio="xMidYMid meet" fill="#000000">
                          <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                          <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                          <g id="SVGRepo_iconCarrier">
                            <path fill="#e0f9cb" d="M6 20c0 2.209-1.119 4-2.5 4S1 22.209 1 20s1.119-4 2.5-4S6 17.791 6 20zm29 0c0 2.209-1.119 4-2.5 4S30 22.209 30 20s1.119-4 2.5-4s2.5 1.791 2.5 4z"></path>
                            <path fill="#e0f9cb" d="M4 20.562c0-8.526 6.268-15.438 14-15.438s14 6.912 14 15.438S25.732 35 18 35S4 29.088 4 20.562z"></path>
                            <path fill="#335e32" d="M12 22a1 1 0 0 1-1-1v-2a1 1 0 0 1 2 0v2a1 1 0 0 1-1 1zm12 0a1 1 0 0 1-1-1v-2a1 1 0 1 1 2 0v2a1 1 0 0 1-1 1z"></path>
                            <path fill="#00b512" d="M18 30c-4.188 0-6.357-1.06-6.447-1.105a1 1 0 0 1 .89-1.791c.051.024 1.925.896 5.557.896c3.665 0 5.54-.888 5.559-.897a1.003 1.003 0 0 1 1.336.457a.997.997 0 0 1-.447 1.335C24.356 28.94 22.188 30 18 30zm1-5h-2a1 1 0 1 1 0-2h2a1 1 0 1 1 0 2z"></path>
                            <path fill="#44b042" d="M18 .354C8.77.354 3 6.816 3 12.2c0 5.385 1.154 7.539 2.308 5.385l2.308-4.308s3.791-.124 6.099-2.278c0 0-1.071 4 6.594.124c0 0-.166 3.876 5.191-.124c0 0 4.039 1.201 5.191 6.586c.32 1.494 2.309 0 2.309-5.385C33 6.816 28.385.354 18 .354z"></path>
                          </g>
                        </svg>
                      </span>
                      <span class="text-xs">{{ __('Boy') }}</span>
                    </div>
                    <div class="flex flex-col items-center rounded-lg border border-gray-200 py-3">
                      <input type="radio" class="mb-1" />
                      <span class="text-2xl">
                        <svg class="h-6 w-6" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" preserveAspectRatio="xMidYMid meet" fill="#000000">
                          <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                          <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                          <g id="SVGRepo_iconCarrier">
                            <path d="M57.9 40S61 34.4 61 26c0-11-8.1-24-29-24S3 15 3 26c0 8.4 3.1 14 3.1 14C2.5 44.1.3 52.4 3.4 57.8c1.3 2.2 14.1 10 15.3-3.9h26.4c1.3 13.8 14.1 6.1 15.3 3.9c3.2-5.4 1-13.7-2.5-17.8" fill="#f367a3"></path>
                            <path d="M32 6C16.7 6 5.5 14 5.5 24C5.5 24 9.6 9 32 9s25.5 15 25.5 15C57.5 14 47.3 6 32 6z" fill="#c28fef"></path>
                            <path d="M57.3 42c6.2 0 6.2-9 0-9v-3s-35-.9-43-13c2 12.2-7.7 16-7.7 16c-6.2 0-6.2 9 0 9c0 7 7.3 18 25.3 18s25.4-11 25.4-18" fill="#f9e9cf"></path>
                            <g fill="#ffffff">
                              <circle cx="44.5" cy="36.5" r="6.5"></circle>
                              <circle cx="19.5" cy="36.5" r="6.5"></circle>
                            </g>
                            <circle cx="44.5" cy="36.5" r="4.5" fill="#cd4460"></circle>
                            <circle cx="44.5" cy="36.5" r="1.5" fill="#231f20"></circle>
                            <circle cx="19.5" cy="36.5" r="4.5" fill="#cd4460"></circle>
                            <circle cx="19.5" cy="36.5" r="1.5" fill="#231f20"></circle>
                            <path d="M40.1 48.1c-5.2 3.6-11 3.6-16.2 0c-.6-.4-1.2.3-.8 1c1.6 2.6 4.8 4.9 8.9 4.9s7.3-2.3 8.9-4.9c.4-.7-.2-1.4-.8-1" fill="#d64426"></path>
                          </g>
                        </svg>
                      </span>

                      <span class="text-xs">{{ __('Girl') }}</span>
                    </div>
                    <div class="flex flex-col items-center rounded-lg border border-gray-200 py-3">
                      <input type="radio" class="mb-1" />
                      <span class="text-2xl">😶</span>
                      <span class="text-xs">{{ __('Unknown') }}</span>
                    </div>
                  </div>

                  <!-- name -->
                  <div class="relative mb-4">
                    <x-input-label for="job_title" :optional="true" :value="__('Name')" />

                    <x-text-input :value="old('job_title', $contact['job_title'])" @keyup.escape="editMode = false" class="mt-1 block w-full" id="job_title" name="job_title" type="text" />

                    <x-input-error class="mt-2" :messages="$errors->get('job_title')" />
                  </div>

                  <div class="flex justify-between">
                    <x-button.secondary x-on:click="editMode = false" class="mr-2">
                      {{ __('Cancel') }}
                    </x-button.secondary>

                    <x-button.primary type="submit" dusk="update-job-information">
                      {{ __('Save') }}
                    </x-button.primary>
                  </div>
                </div>
              </div>

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
            <div class="p-3 sm:p-0">
              <!-- add note -->
              <form hx-target="#notes-list" hx-post="{{ route('vaults.contacts.notes.store', ['vault' => $vault, 'slug' => $contact['slug']]) }}" class="mb-4 border-b border-gray-200" hx-on::after-request="this.reset()">
                @csrf

                <x-textarea id="body" name="body" class="mb-2 w-full" rows="3" required placeholder="{{ __('Add a note') }}" dusk="note-body"></x-textarea>
                <div class="mb-3 flex items-center justify-between">
                  <p class="text-xs text-gray-500">{{ __('Show options') }} (change date or add reminder)</p>

                  <x-button.secondary type="submit" dusk="submit-note">
                    {{ __('Add note') }}
                  </x-button.secondary>
                </div>
              </form>

              <!-- notes -->
              <div id="notes-list">
                @include('vaults.contacts.partials.notes', ['vault' => $vault, 'contact' => $contact, 'notes' => $notes])
              </div>
            </div>
          </div>
        </div>

        <!-- right -->
        <div class="p-3 sm:p-0">
          <!-- tasks -->
          <div class="relative mb-8 rounded-lg border border-gray-200 bg-gray-50 p-3 dark:border-gray-700 dark:bg-gray-900">
            <div class="absolute -top-4 w-full">
              <div class="flex justify-between">
                <div class="flex items-center rounded-full border bg-white py-1 pl-2 pr-3 text-sm">
                  <x-heroicon-o-clipboard-document-check class="mr-2 h-4 w-4 text-gray-500" />
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
                  <x-heroicon-o-clipboard-document-check class="mr-2 h-4 w-4 text-gray-500" />
                  <div>Personal info</div>
                </div>

                <div class="button -left-6 flex cursor-pointer items-center rounded border bg-white text-sm">
                  <x-heroicon-o-plus class="h-4 w-4" />
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
