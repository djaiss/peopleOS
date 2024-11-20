<div x-data="{ addMode: false, selected: 'boy' }">
  @if ($addMode)
    <!-- add kid form -->
    <form wire:submit="store" class="mb-8 items-center rounded-lg border border-gray-200 bg-white p-3 shadow-md hover:border-gray-300 dark:border-gray-700 dark:bg-gray-900" x-data="{
      showName: false,
      showAge: false,
      showSchool: false,
      showGradeLevel: false,
    }">
      <!-- choose gender -->
      <div class="mb-2 grid grid-cols-3 space-x-2">
        <div wire:click="selectGender('boy')" class="flex cursor-pointer flex-col items-center rounded-lg border border-gray-200 py-3 hover:bg-gray-100">
          <input wire:model="gender" name="gender" value="boy" type="radio" class="mb-2" />
          <span class="mb-1 text-2xl">
            <x-icons.boy />
          </span>
          <span class="text-xs text-gray-600">{{ __('Boy') }}</span>
        </div>
        <div wire:click="selectGender('girl')" class="flex cursor-pointer flex-col items-center rounded-lg border border-gray-200 py-3 hover:bg-gray-100">
          <input wire:model="gender" name="gender" value="girl" type="radio" class="mb-2" />
          <span class="mb-1 text-2xl">
            <x-icons.girl />
          </span>
          <span class="text-xs text-gray-600">{{ __('Girl') }}</span>
        </div>
        <div wire:click="selectGender('other')" class="flex cursor-pointer flex-col items-center rounded-lg border border-gray-200 py-3 hover:bg-gray-100">
          <input wire:model="gender" name="gender" value="other" type="radio" class="mb-2" />
          <span class="mb-1 text-2xl">
            <x-icons.other />
          </span>

          <span class="text-xs text-gray-600">{{ __('Other') }}</span>
        </div>

        <x-input-error class="mt-2" :messages="$errors->get('gender')" />
      </div>

      <!-- add optional fields -->
      <div class="flex flex-wrap text-xs">
        <span x-cloak x-show="! showName" class="mb-2 me-2 flex cursor-pointer flex-wrap rounded-lg border bg-slate-200 px-1 py-1 hover:bg-slate-300 dark:bg-slate-500" x-on:click="
          showName = true
          $nextTick(() => {
            $refs.showName.focus()
          })
        ">
          {{ __('+ name') }}
        </span>

        <span x-cloak x-show="! showAge" class="mb-2 me-2 flex cursor-pointer flex-wrap rounded-lg border bg-slate-200 px-1 py-1 hover:bg-slate-300 dark:bg-slate-500" x-on:click="
          showAge = true
          $nextTick(() => {
            $refs.showAge.focus()
          })
        ">
          {{ __('+ age') }}
        </span>

        <span x-cloak x-show="! showGradeLevel" class="mb-2 me-2 flex cursor-pointer flex-wrap rounded-lg border bg-slate-200 px-1 py-1 hover:bg-slate-300 dark:bg-slate-500" x-on:click="
          showGradeLevel = true
          $nextTick(() => {
            $refs.showGradeLevel.focus()
          })
        ">
          {{ __('+ grade level') }}
        </span>

        <span x-cloak x-show="! showSchool" class="mb-2 me-2 flex cursor-pointer flex-wrap rounded-lg border bg-slate-200 px-1 py-1 hover:bg-slate-300 dark:bg-slate-500" x-on:click="
          showSchool = true
          $nextTick(() => {
            $refs.showSchool.focus()
          })
        ">
          {{ __('+ school') }}
        </span>
      </div>

      <!-- name -->
      <div x-cloak x-show="showName" class="relative mb-4">
        <x-input-label for="name" :optional="true" :value="__('Name')" />

        <x-text-input x-ref="showName" wire:model="name" wire:keydown.escape="toggleAddMode" class="mt-1 block w-full" id="name" name="name" type="text" />

        <x-input-error class="mt-2" :messages="$errors->get('name')" />
      </div>

      <!-- age -->
      <div x-cloak x-show="showAge" class="relative mb-4">
        <x-input-label for="age" :optional="true" :value="__('Age')" />

        <x-text-input x-ref="showAge" wire:model="age" wire:keydown.escape="toggleAddMode" class="mt-1 block w-full" id="age" name="age" type="text" />

        <x-input-error class="mt-2" :messages="$errors->get('age')" />
      </div>

      <!-- grade level -->
      <div x-cloak x-show="showGradeLevel" class="relative mb-4">
        <x-input-label for="grade_level" :optional="true" :value="__('Grade level')" />

        <x-text-input x-ref="showGradeLevel" wire:model="gradeLevel" wire:keydown.escape="toggleAddMode" class="mt-1 block w-full" id="grade_level" name="grade_level" type="text" />

        <x-input-error class="mt-2" :messages="$errors->get('grade_level')" />
      </div>

      <!-- school -->
      <div x-cloak x-show="showSchool" class="relative mb-4">
        <x-input-label for="school" :optional="true" :value="__('School')" />

        <x-text-input x-ref="showSchool" wire:model="school" wire:keydown.escape="toggleAddMode" class="mt-1 block w-full" id="school" name="school" type="text" />

        <x-input-error class="mt-2" :messages="$errors->get('school')" />
      </div>

      <div class="flex justify-between">
        <x-button.secondary wire:click="toggleAddMode" class="mr-2">
          {{ __('Cancel') }}
        </x-button.secondary>

        <x-button.primary type="submit">
          {{ __('Save') }}
        </x-button.primary>
      </div>
    </form>
  @endif

  @if ($children->count() > 0)
    <div class="relative mb-8 rounded-lg border border-gray-200 bg-white p-3 pt-7 shadow-md hover:border-gray-300 dark:border-gray-700 dark:bg-gray-900">
      <div class="absolute -top-3 w-full">
        <div class="flex justify-between">
          <div class="flex items-center rounded-full border bg-white py-1 pl-2 pr-3 text-sm">
            <x-lucide-baby class="mr-2 h-4 w-4 text-gray-500" />
            <div>{{ __('Kids') }}</div>
          </div>

          <div class="absolute -top-1 right-6 cursor-pointer rounded-full border border-gray-300 bg-white p-2 hover:bg-gray-100">
            <span wire:click="toggleAddMode">
              <x-lucide-plus class="h-4 w-4 text-gray-500" />
            </span>
          </div>
        </div>
      </div>

      <!-- kid -->
      <div class="space-y-0">
        @foreach ($children as $child)
          <div class="rounded-lg border border-transparent px-2 py-1 hover:cursor-pointer hover:border-gray-200 hover:bg-gray-50">
            <!-- name + age -->
            <div class="flex items-end">
              <div class="flex items-center">
                @if ($child['gender'] === 'boy')
                  <x-icons.boy class="mr-2 h-4 w-4" />
                @elseif ($child['gender'] === 'girl')
                  <x-icons.girl class="mr-2 h-4 w-4" />
                @else
                  <x-icons.other class="mr-2 h-4 w-4" />
                @endif

                <span>{{ $child['name'] }}</span>
              </div>

              <div class="mx-1 mb-1 flex-grow border-b border-dotted border-gray-600"></div>

              @if ($child['age'])
                <span>{{ $child['age'] }} yo</span>
              @endif
            </div>

            <!-- grade + school -->
            @if ($child['school'] || $child['grade_level'])
              <div class="ml-6 mt-1 flex flex-col space-y-1 text-xs">
                @if ($child['school'])
                  <div class="mr-2 flex items-center text-gray-500">
                    <x-lucide-school class="mr-1 h-3 w-3" />

                    <span>{{ $child['school'] }}</span>
                  </div>
                @endif

                @if ($child['grade_level'])
                  <div class="flex items-center text-gray-500">
                    <x-lucide-graduation-cap class="mr-1 h-3 w-3" />

                    <span>{{ $child['grade_level'] }}</span>
                  </div>
                @endif
              </div>
            @endif
          </div>
        @endforeach
      </div>
    </div>

    <div class="relative mb-8 rounded-lg border border-gray-200 bg-gray-50 p-3 dark:border-gray-700 dark:bg-gray-900">
      <!-- plus button when there are kids -->
      <div class="absolute -top-3 w-full">
        <div class="flex justify-between">
          <div class="flex items-center rounded-full border bg-white py-1 pl-2 pr-3 text-sm">
            <x-lucide-baby class="mr-2 h-4 w-4 text-gray-500" />
            <div>{{ __('Kids') }}</div>
          </div>

          <div x-on:click="addMode = true" class="button -left-6 flex cursor-pointer items-center rounded border bg-white text-sm">
            {{-- <x-heroicon-o-plus class="h-4 w-4" /> --}}
          </div>
        </div>
      </div>
    </div>
  @else
    @if (! $addMode)
      <div wire:click="toggleAddMode" class="group mb-8 flex cursor-pointer items-center rounded-lg border border-gray-200 bg-white p-3 shadow-md hover:border-gray-300 dark:border-gray-700 dark:bg-gray-900">
        <div class="-rotate-12 rounded border border-gray-200 bg-white p-1 transition group-hover:rotate-0 group-hover:border-blue-500">
          <x-lucide-baby class="h-4 w-4 text-gray-500 group-hover:text-blue-500" />
        </div>
        <span class="ml-3 text-gray-500 group-hover:text-gray-800">{{ __('Add kids') }}</span>
      </div>
    @endif
  @endif

  <div class="relative mb-8 rounded-lg border border-gray-200 bg-white p-3 pt-7 shadow-md hover:border-gray-300 dark:border-gray-700 dark:bg-gray-900">
    <div class="absolute -top-3 w-full">
      <div class="flex justify-between">
        <div class="flex items-center rounded-full border bg-white py-1 pl-2 pr-3 text-sm">
          <x-lucide-baby class="mr-2 h-4 w-4 text-gray-500" />
          <div>{{ __('Kids') }}</div>
        </div>

        <div class="absolute -top-1 right-6 cursor-pointer rounded-full border border-gray-300 bg-white p-2 hover:bg-gray-100">
          <x-link hover>
            <x-lucide-pencil class="h-4 w-4 text-gray-500" />
          </x-link>
        </div>
      </div>
    </div>

    <!-- kid -->
    <div class="">
      <!-- name + age -->
      <div class="flex items-end">
        <div class="flex items-center">
          <svg class="mr-2 h-5 w-5" viewBox="0 0 36 36" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" preserveAspectRatio="xMidYMid meet" fill="#000000">
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

          <span>Héloïse</span>
        </div>

        <div class="mx-1 mb-1 flex-grow border-b border-dotted border-gray-600"></div>

        <span>6 yo</span>
      </div>

      <!-- grade + school -->
      <div class="ml-6 mt-1 flex flex-col space-y-1 text-xs">
        <div class="mr-2 flex items-center text-gray-500">
          <x-lucide-school class="mr-1 h-3 w-3" />

          <span>Ecole Saint-Joseph</span>
        </div>

        <div class="flex items-center text-gray-500">
          <x-lucide-graduation-cap class="mr-1 h-3 w-3" />

          <span>CE1</span>
        </div>
      </div>
    </div>
  </div>
</div>
