<div class="relative bg-white xl:mb-16">
  <div class="relative mx-auto hidden h-[400px] max-w-7xl px-6 py-0 sm:block sm:py-12 md:h-[700px] lg:px-8 xl:px-0 xl:py-32">
    <div class="absolute top-0 left-1/2 grid w-[1300px] -translate-x-1/2 scale-50 rotate-[-5deg] skew-x-[5deg] grid-cols-[320px_1fr] divide-x divide-gray-200 rounded-lg border sm:top-8 md:scale-50 lg:scale-75 xl:scale-100">
      <!-- Section B: Contact Overview -->
      <div class="flex flex-col overflow-hidden rounded-tl-lg rounded-bl-lg bg-white">
        <!-- Contact header -->
        <div class="border-b border-gray-200 p-6">
          <!-- name + title + age -->
          <div id="profile-header" class="mb-6 flex items-center gap-4">
            <div class="h-16 w-16 shrink-0">
              <img class="h-16 w-16 rounded-full object-cover p-[0.1875rem] shadow-sm ring-1 ring-slate-900/10" src="{{ asset('marketing/quotes/jim.webp') }}" srcset="{{ asset('marketing/quotes/jim.webp') }} 1x, {{ asset('marketing/quotes/jim@2x.webp') }} 2x" height="48" width="48" alt="Jim Halpert" loading="lazy" />
            </div>
            <div class="flex min-w-0 flex-col gap-1">
              <!-- name -->
              <h1 class="truncate text-xl font-semibold">Jim Halpert</h1>
              <!-- job -->
              <span class="text-sm text-gray-600">Project manager</span>
              <!-- age -->
              <span class="text-sm text-gray-600">Probably 36 years old</span>
            </div>
          </div>

          <!-- Personal details -->
          <div class="space-y-2">
            <!-- Relationship status -->
            <div class="flex items-center gap-2">
              <x-lucide-heart class="h-4 w-4 flex-shrink-0 text-rose-500" />
              <span id="marital-status" class="text-sm">In a relationship with Pam</span>
            </div>

            <!-- Children -->
            <div class="flex items-center gap-2">
              <x-lucide-baby class="h-4 w-4 text-blue-500" />
              <span class="text-sm">Cecelia (3) and Philip (1)</span>
            </div>

            <!-- Pets -->
            <div class="flex items-center gap-2">
              <x-lucide-dog class="h-4 w-4 text-amber-500" />
              <span class="text-sm">Max (Golden Retriever)</span>
            </div>
          </div>
        </div>

        <!-- Navigation menu -->
        <nav class="border-b border-gray-200">
          <div class="flex flex-col">
            <div class="group flex cursor-pointer items-center gap-3 border-l-2 border-blue-500 bg-blue-50 px-4 py-3 hover:bg-gray-50">
              <x-lucide-scan-face class="{{ request()->routeIs('person.show') ? 'text-blue-500' : 'text-gray-500' }} h-4 w-4 transition-all duration-400 grouphover:-translate-y-0.5 group-hover:-rotate-3" />
              <span class="{{ request()->routeIs('person.show') ? 'text-blue-700' : 'text-gray-600' }} text-sm font-medium">{{ __('Overview') }}</span>
            </div>
            <div class="group flex cursor-pointer items-center gap-3 border-l-2 border-transparent px-4 py-3 hover:bg-gray-50">
              <x-lucide-radical class="h-4 w-4 text-gray-500" />
              <span class="text-sm font-medium text-gray-600">{{ __('Life events') }}</span>
            </div>
            <div class="group flex cursor-pointer items-center gap-3 border-l-2 border-transparent px-4 py-3 hover:bg-gray-50">
              <x-lucide-book-open class="{{ request()->routeIs('person.note.index') ? 'text-blue-500' : 'text-gray-500' }} h-4 w-4 transition-all duration-400 grouphover:-translate-y-0.5 group-hover:-rotate-3" />
              <span class="{{ request()->routeIs('person.note.index') ? 'text-blue-700' : 'text-gray-600' }} text-sm font-medium">Notes</span>
            </div>

            <div class="group flex cursor-pointer items-center gap-3 border-l-2 border-transparent px-4 py-3 hover:bg-gray-50">
              <x-lucide-person-standing class="{{ request()->routeIs('person.family.index') ? 'text-blue-500' : 'text-gray-500' }} h-4 w-4 transition-all duration-400 grouphover:-translate-y-0.5 group-hover:-rotate-3" />
              <span class="{{ request()->routeIs('person.family.index') ? 'text-blue-700' : 'text-gray-600' }} text-sm font-medium">{{ __('Love, family & friends') }}</span>
            </div>

            <div class="group flex cursor-pointer items-center gap-3 border-l-2 border-transparent px-4 py-3 hover:bg-gray-50">
              <x-lucide-bell class="{{ request()->routeIs('person.reminder.index') ? 'text-blue-500' : 'text-gray-500' }} h-4 w-4 transition-all duration-400 grouphover:-translate-y-0.5 group-hover:-rotate-3" />
              <span class="{{ request()->routeIs('person.reminder.index') ? 'text-blue-700' : 'text-gray-600' }} text-sm font-medium">{{ __('Tasks and reminders') }}</span>
            </div>
            <div class="group flex cursor-pointer items-center gap-3 border-l-2 border-transparent px-4 py-3 hover:bg-gray-50">
              <x-lucide-gift class="{{ request()->routeIs('person.gift.index') ? 'text-blue-500' : 'text-gray-500' }} h-4 w-4 transition-all duration-400 grouphover:-translate-y-0.5 group-hover:-rotate-3" />
              <span class="{{ request()->routeIs('person.gift.index') ? 'text-blue-700' : 'text-gray-600' }} text-sm font-medium">Gifts</span>
            </div>
            <div class="group flex cursor-pointer items-center gap-3 border-l-2 border-transparent px-4 py-3 hover:bg-gray-50">
              <x-lucide-briefcase class="{{ request()->routeIs('person.work.index') ? 'text-blue-500' : 'text-gray-500' }} h-4 w-4 transition-all duration-400 grouphover:-translate-y-0.5 group-hover:-rotate-3" />
              <span class="{{ request()->routeIs('person.work.index') ? 'text-blue-700' : 'text-gray-600' }} text-sm font-medium">{{ __('Work') }}</span>
            </div>
            <div class="group flex cursor-pointer items-center gap-3 border-l-2 border-transparent px-4 py-3 hover:bg-gray-50">
              <x-lucide-settings class="{{ request()->routeIs('person.settings.index') ? 'text-blue-500' : 'text-gray-500' }} h-4 w-4 transition-all duration-400 grouphover:-translate-y-0.5 group-hover:-rotate-3" />
              <span class="{{ request()->routeIs('person.settings.index') ? 'text-blue-700' : 'text-gray-600' }} text-sm font-medium">{{ __('Edit information') }}</span>
            </div>
          </div>
        </nav>
      </div>

      <!-- Section C: Detail View -->
      <div class="h-[650px] overflow-y-auto bg-gray-50">
        <div class="mx-auto max-w-3xl p-6">
          <h1 class="font-semi-bold mb-4 text-2xl">Overview</h1>

          <section id="information" class="mb-8">
            <div class="mb-4 flex items-center justify-between">
              <div class="flex items-center gap-2">
                <x-lucide-user class="h-5 w-5 text-blue-500" />
                <h2 class="text-lg font-semibold text-gray-900">{{ __('Information') }}</h2>
              </div>

              <div class="flex items-center gap-2">
                <div class="inline-flex items-center gap-1 rounded-md bg-blue-50 px-2 py-1 text-sm font-medium text-blue-600 hover:bg-blue-100">
                  <x-lucide-pencil class="mr-1 h-3 w-3" />
                  {{ __('Edit') }}
                </div>
              </div>
            </div>

            <div id="information-details" class="rounded-lg border border-gray-200 bg-white">
              <div class="grid grid-cols-3 gap-0">
                <div class="flex flex-col border-r border-gray-200 px-4 py-2">
                  <span class="text-xs text-gray-500">{{ __('Local time') }}</span>
                  <span class="font-medium">GMT</span>
                </div>

                <div class="flex flex-col border-r border-gray-200 px-4 py-2">
                  <span class="text-xs text-gray-500">{{ __('Nationalities') }}</span>
                  <span class="font-medium">Dutch</span>
                </div>

                <div class="flex flex-col px-4 py-2">
                  <span class="text-xs text-gray-500">{{ __('Languages') }}</span>
                  <span class="font-medium">Dutch, French and German</span>
                </div>
              </div>
            </div>
          </section>

          <section id="encounters-section" class="mb-8">
            <div class="mb-4 flex items-center justify-between">
              <div class="flex items-center gap-2">
                <x-lucide-eye class="h-5 w-5 text-amber-500" />
                <h2 class="text-lg font-semibold text-gray-900">{{ __('Encounters') }}</h2>
              </div>
              <div class="flex items-center gap-2">
                <div class="inline-flex cursor-pointer items-center gap-1 rounded-md bg-gray-50 px-2 py-1 text-sm font-medium text-gray-600 hover:bg-gray-200">
                  <span>Show more</span>
                  <x-lucide-chevron-down class="h-4 w-4" />
                </div>
              </div>
            </div>

            <!-- summary + actions -->
            <div class="flex gap-4 rounded-lg border border-gray-200 bg-white">
              <div class="flex flex-col gap-4 border-r border-gray-200 p-4">
                <p class="text-sm text-gray-600">{{ __('Times seen') }}</p>
                <div class="flex items-baseline gap-2">
                  <p class="text-2xl font-semibold">34</p>
                  <p class="text-sm text-gray-500">in 2025</p>
                  <span class="text-gray-400">·</span>
                  <p class="text-sm text-gray-500">47 in 2024</p>
                </div>
              </div>
              <div class="p-4">
                <p class="mb-3 text-sm text-gray-600">Have you seen Jim lately?</p>

                <div class="flex flex-wrap gap-2">
                  <div class="inline">
                    <input type="hidden" name="seen_at" value="{{ now() }}" />
                    <button type="submit" class="inline-flex cursor-pointer items-center gap-1 rounded-md bg-white px-3 py-2 text-sm font-medium text-gray-600 ring-1 ring-gray-300 ring-inset hover:bg-gray-50">
                      {{ __('Today') }}
                    </button>
                  </div>

                  <div class="inline">
                    <input type="hidden" name="seen_at" value="{{ now()->subDay() }}" />
                    <button type="submit" class="inline-flex cursor-pointer items-center gap-1 rounded-md bg-white px-3 py-2 text-sm font-medium text-gray-600 ring-1 ring-gray-300 ring-inset hover:bg-gray-50">
                      {{ __('Yesterday') }}
                    </button>
                  </div>

                  <div class="inline">
                    <input type="hidden" name="seen_at" value="{{ now()->subDays(2) }}" />
                    <button type="submit" class="inline-flex cursor-pointer items-center gap-1 rounded-md bg-white px-3 py-2 text-sm font-medium text-gray-600 ring-1 ring-gray-300 ring-inset hover:bg-gray-50">
                      {{ __('2 days ago') }}
                    </button>
                  </div>

                  <div type="button" class="inline-flex cursor-pointer items-center gap-1 rounded-md bg-white px-3 py-2 text-sm font-medium text-gray-600 ring-1 ring-gray-300 ring-inset hover:bg-gray-50">
                    <x-lucide-calendar-plus class="h-4 w-4" />
                    {{ __('Custom date') }}
                  </div>
                </div>
              </div>
            </div>

            <!-- Recent encounters -->
            <div class="mt-4 rounded-lg border border-gray-200 bg-white">
              <h3 class="border-b border-gray-200 px-4 py-3 text-sm font-medium text-gray-700">{{ __('Recent encounters') }}</h3>
              <div class="divide-y divide-gray-200">
                <div class="group flex items-center justify-between p-4">
                  <div class="flex items-center gap-3">
                    <div class="rounded-full bg-indigo-50 p-2">
                      <x-lucide-eye class="h-4 w-4 text-indigo-600" />
                    </div>
                    <div>
                      <a class="border-b border-dashed border-gray-600 text-sm font-medium text-gray-600">{{ __('Add context') }}</a>
                      <p class="text-sm text-gray-500">4 days ago</p>
                    </div>
                  </div>

                  <!-- actions -->
                  <div class="flex gap-2">
                    <x-button.invisible class="hidden text-sm group-hover:block">
                      {{ __('Edit') }}
                    </x-button.invisible>

                    <x-button.invisible class="hidden text-sm group-hover:block">
                      {{ __('Delete') }}
                    </x-button.invisible>
                  </div>
                </div>
              </div>
            </div>
          </section>

          <!-- Physical appearance -->
          <section id="physical-appearance" class="mb-8">
            <div class="mb-4 flex items-center justify-between">
              <div class="flex items-center gap-2">
                <x-lucide-smile class="h-5 w-5 text-green-500" />
                <h2 class="text-lg font-semibold text-gray-900">{{ __('Physical appearance') }}</h2>
              </div>

              <div class="flex items-center gap-2">
                <div class="inline-flex items-center gap-1 rounded-md bg-green-50 px-2 py-1 text-sm font-medium text-green-600 hover:bg-green-100">
                  <x-lucide-pencil class="mr-1 h-3 w-3" />
                  {{ __('Edit') }}
                </div>
              </div>
            </div>

            <div class="grid grid-cols-3 gap-0">
              <!-- this is super barbaric. i'm almost ashamed of it. -->

              <div class="flex flex-col rounded-tl-lg border-t border-r border-b border-l border-gray-200 bg-white px-4 py-2">
                <span class="text-xs text-gray-500">Height</span>
                <span class="font-medium">6"0</span>
              </div>

              <div class="flex flex-col border-t border-r border-b border-gray-200 bg-white px-4 py-2">
                <span class="text-xs text-gray-500">Weight</span>
                <span class="font-medium">210 lbs</span>
              </div>

              <div class="flex flex-col rounded-tr-lg rounded-br-lg border-t border-r border-b border-gray-200 bg-white px-4 py-2">
                <span class="text-xs text-gray-500">Hair color</span>
                <span class="font-medium">Blue eyes</span>
              </div>
            </div>
          </section>

          <!-- how we met -->
          <section id="edit-how-we-met-form" class="mb-8">
            <div class="mb-4 flex items-center justify-between">
              <div class="flex items-center gap-2">
                <x-lucide-footprints class="h-5 w-5 text-purple-500" />
                <h2 class="text-lg font-semibold text-gray-900">{{ __('How we met') }}</h2>
              </div>
              <div class="flex items-center gap-2">
                <div class="inline-flex cursor-pointer items-center gap-1 rounded-md bg-gray-50 px-2 py-1 text-sm font-medium text-gray-600 hover:bg-gray-200">
                  <span>Show less</span>
                  <x-lucide-chevron-up class="h-4 w-4" />
                </div>
                <div class="inline-flex items-center gap-1 rounded-md bg-purple-50 px-2 py-1 text-sm font-medium text-purple-600 hover:bg-purple-100">
                  <x-lucide-pencil class="mr-1 h-3 w-3" />
                  {{ __('Edit') }}
                </div>
              </div>
            </div>

            <div class="rounded-lg border border-gray-200 bg-white p-4">
              <div class="space-y-4">
                <!-- Meeting Details Grid -->
                <div class="grid grid-cols-2 gap-4">
                  <!-- Date -->
                  <div class="flex items-center gap-2">
                    <x-lucide-calendar class="h-4 w-4 text-gray-400" />
                    <x-tooltip text="13 years ago">
                      <span class="text-sm text-gray-600">May 12, 2012</span>
                    </x-tooltip>
                  </div>

                  <!-- Location -->
                  <div class="flex items-center gap-2">
                    <x-lucide-map-pin class="h-4 w-4 text-gray-400" />
                    <span class="text-sm text-gray-600">Dunder Mifflin, Scranton Branch</span>
                  </div>
                </div>

                <!-- Reminder -->
                <div class="border-t pt-4">
                  <p class="text-sm text-gray-600">A reminder will be sent to you on May 12, {{ now()->year }}.</p>
                </div>

                <!-- First Impressions -->
                <div class="border-t pt-4">
                  <h3 class="mb-2 text-sm font-medium text-gray-900">{{ __('First Impressions') }}</h3>
                  <p class="text-sm text-gray-600">Jim was easygoing, funny, and always seemed to know how to make me laugh. He was genuinely kind and made the workday feel lighter. I felt comfortable around him right away.</p>
                </div>

                <!-- Story -->
                <div class="border-t pt-4">
                  <h3 class="mb-2 text-sm font-medium text-gray-900">{{ __('The Story') }}</h3>
                  <p class="text-sm whitespace-pre-wrap text-gray-600">I met Jim when we both started working at Dunder Mifflin’s Scranton branch. I was the receptionist, and he worked in sales. We became fast friends, spending our days joking around and pulling harmless pranks on Dwight. Our friendship grew naturally, filled with laughter and inside jokes. Even though I was engaged at the time, Jim was always supportive and caring. Over time, our bond deepened, and he became one of the most important people in my life.</p>
                </div>
              </div>
            </div>
          </section>
        </div>
      </div>
    </div>
  </div>

  <!-- image only on mobile -->
  <div class="relative mx-auto h-[200px] max-w-7xl px-6 py-0 sm:hidden">
    <img class="" src="{{ asset('marketing/jim.webp') }}" srcset="{{ asset('marketing/app.webp') }} 1x, {{ asset('marketing/app@2x.webp') }} 2x" alt="Jim Halpert" loading="lazy" />
  </div>
</div>
