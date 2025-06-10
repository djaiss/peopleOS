<div class="relative bg-white xl:mb-16" x-data="{ activeTab: 'overview' }">
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
            <div x-on:click="activeTab = 'overview'" class="group flex cursor-pointer items-center gap-3 px-4 py-3 hover:bg-gray-50" ::class="activeTab === 'overview' ? ' border-l-2 border-blue-500 bg-blue-50' : 'border-l-2 border-transparent'">
              <x-lucide-scan-face class="h-4 w-4" ::class="activeTab === 'overview' ? 'text-blue-500' : 'text-gray-500'" />
              <span class="text-sm font-medium" ::class="activeTab === 'overview' ? 'text-blue-700' : 'text-gray-600'">{{ __('Overview') }}</span>
            </div>
            <div x-on:click="activeTab = 'lifeEvents'" class="group flex cursor-pointer items-center gap-3 px-4 py-3 hover:bg-gray-50" ::class="activeTab === 'lifeEvents' ? 'border-l-2 border-blue-500 bg-blue-50' : 'border-l-2 border-transparent'">
              <x-lucide-radical class="h-4 w-4" ::class="activeTab === 'lifeEvents' ? 'text-blue-500' : 'text-gray-500'" />
              <span class="text-sm font-medium" ::class="activeTab === 'lifeEvents' ? 'text-blue-700' : 'text-gray-600'">{{ __('Life events') }}</span>
            </div>
            <div x-on:click="activeTab = 'notes'" class="group flex cursor-pointer items-center gap-3 border-l-2 border-transparent px-4 py-3 hover:bg-gray-50" ::class="activeTab === 'notes' ? 'border-l-2 border-blue-500 bg-blue-50' : 'border-l-2 border-transparent'">
              <x-lucide-book-open class="h-4 w-4" ::class="activeTab === 'notes' ? 'text-blue-500' : 'text-gray-500'" />
              <span class="text-sm font-medium" ::class="activeTab === 'notes' ? 'text-blue-700' : 'text-gray-600'">Notes</span>
            </div>

            <div class="group flex cursor-pointer items-center gap-3 border-l-2 border-transparent px-4 py-3 hover:bg-gray-50">
              <x-lucide-person-standing class="{{ request()->routeIs('person.family.index') ? 'text-blue-500' : 'text-gray-500' }} h-4 w-4 transition-all duration-400 grouphover:-translate-y-0.5 group-hover:-rotate-3" />
              <span class="{{ request()->routeIs('person.family.index') ? 'text-blue-700' : 'text-gray-600' }} text-sm font-medium">{{ __('Love & family') }}</span>
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
        <!-- overview -->
        <div x-show="activeTab === 'overview'" x-transition:enter="transition duration-200 ease-out" x-transition:enter-start="-translate-x-2 transform opacity-0" x-transition:enter-end="translate-x-0 transform opacity-100" x-transition:leave="transition duration-150 ease-in" x-transition:leave-start="translate-x-0 transform opacity-100" x-transition:leave-end="-translate-x-2 transform opacity-0" class="mx-auto max-w-3xl p-6">
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

        <!-- life events -->
        <div x-cloak x-show="activeTab === 'lifeEvents'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform translate-x-2" x-transition:enter-end="opacity-100 transform translate-x-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 transform translate-x-0" x-transition:leave-end="opacity-0 transform translate-x-2" class="mx-auto max-w-2xl p-6">
          <!-- title -->
          <div class="mb-4 flex items-center justify-between">
            <div class="flex items-center gap-2">
              <x-lucide-leaf class="h-5 w-5 text-amber-500" />
              <h2 class="text-lg font-semibold text-gray-900">Life events</h2>
            </div>

            <div class="flex items-center gap-2">
              <div class="inline-flex items-center gap-1 rounded-md bg-amber-200 px-2 py-1 text-sm font-medium text-amber-600 hover:bg-amber-300">
                <x-lucide-plus class="mr-1 h-3 w-3" />
                Add
              </div>
            </div>
          </div>

          <!-- description -->
          <p class="mb-8 text-sm text-zinc-500">Life events are important moments in a person's life that you want to remember.</p>

          <!-- add life event form -->
          <div id="add-life-event-form"></div>

          <!-- life events list -->
          <div id="life-events-list" class="ml-3 flex flex-col gap-y-7 border-l border-gray-300">
            <div id="life-event-2" class="relative flex gap-x-3">
              <!-- icon -->
              <div class="absolute -left-3 rounded-full bg-amber-300 p-1">
                <x-lucide-activity class="h-4 w-4 text-white" />
              </div>

              <!-- description -->
              <div class="relative flex flex-col gap-y-3 pl-6">
                <div class="group relative">
                  <div class="rounded px-1 group-hover:bg-amber-100">Put Dwight’s stapler in actual Jell-O again</div>
                  <span class="ml-1 inline-block text-xs text-gray-500">Jun 10, 2025</span>
                </div>
              </div>
            </div>
            <div id="life-event-1" class="relative flex gap-x-3">
              <!-- icon -->
              <div class="absolute -left-3 rounded-full bg-amber-300 p-1">
                <x-lucide-activity class="h-4 w-4 text-white" />
              </div>

              <!-- description -->
              <div class="relative flex flex-col gap-y-3 pl-6">
                <div class="group relative">
                  <div class="rounded px-1 group-hover:bg-amber-100">Got promoted to co-manager with Michael Scott</div>
                  <span class="ml-1 inline-block text-xs text-gray-500">Jun 10, 2025</span>
                  <div class="absolute top-0 -right-8">
                    <div x-data="{
                      tooltipVisible: false,
                      tooltipText: 'Reminder set',
                      tooltipArrow: true,
                      tooltipPosition: 'top',
                    }" x-init="
                      $refs.content.addEventListener('mouseenter', () => {
                        tooltipVisible = true
                      })
                      $refs.content.addEventListener('mouseleave', () => {
                        tooltipVisible = false
                      })
                    " class="relative">
                      <div x-ref="tooltip" x-show="tooltipVisible" :class="{ 'top-0 left-1/2 -translate-x-1/2 -mt-0.5 -translate-y-full' : tooltipPosition == 'top', 'top-1/2 -translate-y-1/2 -ml-0.5 left-0 -translate-x-full' : tooltipPosition == 'left', 'bottom-0 left-1/2 -translate-x-1/2 -mb-0.5 translate-y-full' : tooltipPosition == 'bottom', 'top-1/2 -translate-y-1/2 -mr-0.5 right-0 translate-x-full' : tooltipPosition == 'right' }" class="absolute top-0 left-1/2 -mt-0.5 w-auto -translate-x-1/2 -translate-y-full text-sm" style="display: none">
                        <div x-show="tooltipVisible" x-transition="" class="bg-opacity-90 relative rounded-sm bg-black px-2 py-1 text-white" style="display: none">
                          <p x-text="tooltipText" class="block shrink-0 text-xs whitespace-nowrap">Reminder set</p>
                          <div x-ref="tooltipArrow" x-show="tooltipArrow" :class="{ 'bottom-0 -translate-x-1/2 left-1/2 w-2.5 translate-y-full' : tooltipPosition == 'top', 'right-0 -translate-y-1/2 top-1/2 h-2.5 -mt-px translate-x-full' : tooltipPosition == 'left', 'top-0 -translate-x-1/2 left-1/2 w-2.5 -translate-y-full' : tooltipPosition == 'bottom', 'left-0 -translate-y-1/2 top-1/2 h-2.5 -mt-px -translate-x-full' : tooltipPosition == 'right' }" class="absolute bottom-0 left-1/2 inline-flex w-2.5 -translate-x-1/2 translate-y-full items-center justify-center overflow-hidden">
                            <div :class="{ 'origin-top-left -rotate-45' : tooltipPosition == 'top', 'origin-top-left rotate-45' : tooltipPosition == 'left', 'origin-bottom-left rotate-45' : tooltipPosition == 'bottom', 'origin-top-right -rotate-45' : tooltipPosition == 'right' }" class="bg-opacity-90 h-1.5 w-1.5 origin-top-left -rotate-45 transform bg-black"></div>
                          </div>
                        </div>
                      </div>

                      <div x-ref="content" class="">
                        <div class="rounded-full border border-gray-200 bg-white p-1">
                          <svg class="h-3 w-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"></path>
                            <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"></path>
                            <path d="M4 2C2.8 3.7 2 5.7 2 8"></path>
                            <path d="M22 8c0-2.3-.8-4.3-2-6"></path>
                          </svg>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div id="life-event-3" class="relative flex gap-x-3">
              <!-- icon -->
              <div class="absolute -left-3 rounded-full bg-amber-300 p-1">
                <x-lucide-activity class="h-4 w-4 text-white" />
              </div>

              <!-- description -->
              <div class="relative flex flex-col gap-y-3 pl-6">
                <div class="group relative">
                  <div class="rounded px-1 group-hover:bg-amber-100">Moved into a new house with Pam and the kids</div>
                  <span class="ml-1 inline-block text-xs text-gray-500">Jun 05, 2025</span>
                </div>
                <div class="rounded-lg border border-gray-300 bg-white p-3">A beautiful house in the suburbs of Scranton. Can't wait to visit it.</div>
              </div>
            </div>
            <div id="life-event-4" class="relative flex gap-x-3">
              <!-- icon -->
              <div class="absolute -left-3 rounded-full bg-amber-300 p-1">
                <x-lucide-activity class="h-4 w-4 text-white" />
              </div>

              <!-- description -->
              <div class="relative flex flex-col gap-y-3 pl-6">
                <div class="group relative">
                  <div class="rounded px-1 group-hover:bg-amber-100">Got stuck in a conversation with Toby for 47 minutes straight</div>
                  <span class="ml-1 inline-block text-xs text-gray-500">Jun 04, 2025</span>
                </div>
              </div>
            </div>
            <div id="life-event-5" class="relative flex gap-x-3">
              <!-- icon -->
              <div class="absolute -left-3 rounded-full bg-amber-300 p-1">
                <x-lucide-activity class="h-4 w-4 text-white" />
              </div>

              <!-- description -->
              <div class="relative flex flex-col gap-y-3 pl-6">
                <div class="group relative">
                  <div class="rounded px-1 group-hover:bg-amber-100">Pretended to be a regional manager for a day — no one noticed</div>
                  <span class="ml-1 inline-block text-xs text-gray-500">Jun 02, 2025</span>
                </div>
              </div>
            </div>
            <div id="life-event-6" class="relative flex gap-x-3">
              <!-- icon -->
              <div class="absolute -left-3 rounded-full bg-amber-300 p-1">
                <x-lucide-activity class="h-4 w-4 text-white" />
              </div>

              <!-- description -->
              <div class="relative flex flex-col gap-y-3 pl-6">
                <div class="group relative">
                  <div class="rounded px-1 group-hover:bg-amber-100">Bought his first serious pair of adult sneakers</div>
                  <span class="ml-1 inline-block text-xs text-gray-500">May 27, 2025</span>
                </div>
              </div>
            </div>
            <div id="life-event-7" class="relative flex gap-x-3">
              <!-- icon -->
              <div class="absolute -left-3 rounded-full bg-amber-300 p-1">
                <x-lucide-activity class="h-4 w-4 text-white" />
              </div>

              <!-- description -->
              <div class="relative flex flex-col gap-y-3 pl-6">
                <div class="group relative">
                  <div class="rounded px-1 group-hover:bg-amber-100">Accidentally wore Pam’s jeans to work. Didn’t notice until lunch</div>
                  <span class="ml-1 inline-block text-xs text-gray-500">Apr 08, 2025</span>
                </div>
              </div>
            </div>
            <div id="life-event-8" class="relative flex gap-x-3">
              <!-- icon -->
              <div class="absolute -left-3 rounded-full bg-amber-300 p-1">
                <x-lucide-activity class="h-4 w-4 text-white" />
              </div>

              <!-- description -->
              <div class="relative flex flex-col gap-y-3 pl-6">
                <div class="group relative">
                  <div class="rounded px-1 group-hover:bg-amber-100">Ate Kevin’s famous chili leftovers. Regretted it.</div>
                  <span class="ml-1 inline-block text-xs text-gray-500">Mar 04, 2025</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div x-cloak x-show="activeTab === 'notes'" x-transition:enter="transition duration-200 ease-out" x-transition:enter-start="translate-x-2 transform opacity-0" x-transition:enter-end="translate-x-0 transform opacity-100" x-transition:leave="transition duration-150 ease-in" x-transition:leave-start="translate-x-0 transform opacity-100" x-transition:leave-end="translate-x-2 transform opacity-0" class="mx-auto max-w-2xl p-6">
          <!-- Add note form -->
          <div class="mb-6 rounded-lg border border-gray-200 bg-white p-4">
            <form id="add-note-form" x-target="notes-list add-note-form">
              <div class="mb-4">
                <div class="w-full">
                  <textarea type="text" x-data="{
                    resize() {
                      $el.style.height = '0px'
                      $el.style.height = $el.scrollHeight + 'px'
                    },
                  }" x-init="resize()" @input="resize()" placeholder="Write your note here..." class="h-auto min-h-[80px] w-full rounded-lg rounded-md border border-gray-300 px-3 py-2 shadow-xs placeholder:text-neutral-400 focus:border-blue-500 focus:border-indigo-500 focus:ring-1 focus:ring-blue-500 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600" name="content" required="required" rows="3" style="height: 78px"></textarea>
                </div>
              </div>

              <div class="flex items-center justify-between">
                <button class="cursor-pointer rounded-md border border-indigo-700 bg-indigo-500 px-3 py-1 font-semibold text-white shadow-xs hover:bg-indigo-700">Save</button>
              </div>
            </form>
          </div>

          <!-- Notes list -->
          <div id="notes-list" data-source="https://peopleos.test/persons/63-lorauence/notes">
            <div id="note-344" class="group mb-4 overflow-hidden rounded-lg border border-gray-200 bg-white transition hover:border-gray-300 hover:shadow-sm">
              <div class="first:rounded-t-lg last:rounded-b-lg">
                <div class="flex items-center justify-between border-b border-gray-200 bg-gray-50/50 px-4 py-2">
                  <!-- note header -->
                  <div class="flex items-center gap-2">
                    <span class="flex h-6 w-6 items-center justify-center rounded-full bg-blue-100">
                      <x-lucide-book-open class="h-3 w-3 text-blue-600" />
                    </span>
                    <div>
                      <p class="text-xs text-gray-600">Jun 10, 2025</p>
                    </div>
                  </div>

                  <!-- note options -->
                  <div class="relative" x-data="{ open: false }">
                    <button type="button" class="flex items-center rounded-md p-1 text-gray-400 opacity-0 group-hover:opacity-100 hover:bg-gray-100 hover:text-gray-600">
                      <x-lucide-more-horizontal class="h-4 w-4" />
                    </button>
                  </div>
                </div>
                <div class="p-4">
                  <p class="whitespace-pre-wrap text-gray-700">Jim has this way of making you feel like your opinion matters, even if it’s a small thing. I mentioned something minor about a weekend plan once, and two weeks later he asked how it went. That level of attention makes people trust him. It’s subtle, but very effective. I think it’s part of what makes him such a strong informal leader.</p>
                </div>
              </div>
            </div>
            <div id="note-343" class="group mb-4 overflow-hidden rounded-lg border border-gray-200 bg-white transition hover:border-gray-300 hover:shadow-sm">
              <div class="first:rounded-t-lg last:rounded-b-lg">
                <div class="flex items-center justify-between border-b border-gray-200 bg-gray-50/50 px-4 py-2">
                  <!-- note header -->
                  <div class="flex items-center gap-2">
                    <span class="flex h-6 w-6 items-center justify-center rounded-full bg-blue-100">
                      <x-lucide-book-open class="h-3 w-3 text-blue-600" />
                    </span>
                    <div>
                      <p class="text-xs text-gray-600">Jun 10, 2025</p>
                    </div>
                  </div>

                  <!-- note options -->
                  <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" type="button" class="flex items-center rounded-md p-1 text-gray-400 opacity-0 group-hover:opacity-100 hover:bg-gray-100 hover:text-gray-600">
                      <x-lucide-more-horizontal class="h-4 w-4" />
                    </button>

                    <!-- Dropdown menu -->
                    <div x-show="open" @click.away="open = false" class="absolute right-0 z-100 mt-1 w-48 rounded-md border border-gray-200 bg-white py-1 shadow-lg" style="display: none">
                      <a href="https://peopleos.test/persons/63-lorauence/notes/343/edit" x-target="note-343" class="flex w-full items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                        <x-lucide-pencil class="h-4 w-4" />
                        Edit
                      </a>
                    </div>
                  </div>
                </div>
                <div class="p-4">
                  <p class="whitespace-pre-wrap text-gray-700">We talked about long-term goals the other day, and while he brushed it off at first, I got the sense that Jim is more ambitious than he lets on. He mentioned wanting more "flexibility" and hinted at starting something on the side, maybe a business. He’s clearly capable, but something — maybe a sense of loyalty or fear of disrupting the balance — is holding him back.</p>
                </div>
              </div>
            </div>
            <div id="note-342" class="group mb-4 overflow-hidden rounded-lg border border-gray-200 bg-white transition hover:border-gray-300 hover:shadow-sm">
              <div class="first:rounded-t-lg last:rounded-b-lg">
                <div class="flex items-center justify-between border-b border-gray-200 bg-gray-50/50 px-4 py-2">
                  <!-- note header -->
                  <div class="flex items-center gap-2">
                    <span class="flex h-6 w-6 items-center justify-center rounded-full bg-blue-100">
                      <x-lucide-book-open class="h-3 w-3 text-blue-600" />
                    </span>
                    <div>
                      <p class="text-xs text-gray-600">Jun 10, 2025</p>
                    </div>
                  </div>

                  <!-- note options -->
                  <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" type="button" class="flex items-center rounded-md p-1 text-gray-400 opacity-0 group-hover:opacity-100 hover:bg-gray-100 hover:text-gray-600">
                      <x-lucide-more-horizontal class="h-4 w-4" />
                    </button>

                    <!-- Dropdown menu -->
                    <div x-show="open" @click.away="open = false" class="absolute right-0 z-100 mt-1 w-48 rounded-md border border-gray-200 bg-white py-1 shadow-lg" style="display: none">
                      <a href="https://peopleos.test/persons/63-lorauence/notes/342/edit" x-target="note-342" class="flex w-full items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                        <x-lucide-pencil class="h-4 w-4" />
                        Edit
                      </a>
                    </div>
                  </div>
                </div>
                <div class="p-4">
                  <p class="whitespace-pre-wrap text-gray-700">Jim has a natural ability to read the room and adjust his tone accordingly. In tense situations, he’ll often inject just enough humor to break the ice without undermining the conversation. I’ve noticed he uses this as a tool to manage group dynamics — especially when Michael is around — but I sometimes wonder if it prevents him from being fully direct when he disagrees.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- image only on mobile -->
    <div class="relative mx-auto h-[200px] max-w-7xl px-6 py-0 sm:hidden">
      <img class="" src="{{ asset('marketing/jim.webp') }}" srcset="{{ asset('marketing/app.webp') }} 1x, {{ asset('marketing/app@2x.webp') }} 2x" alt="Jim Halpert" loading="lazy" />
    </div>
  </div>
</div>
