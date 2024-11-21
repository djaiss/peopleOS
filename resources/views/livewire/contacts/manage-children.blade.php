<div>
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

        <x-text-input x-ref="showAge" wire:model="age" wire:keydown.escape="toggleAddMode" class="mt-1 block w-full" id="age" name="age" type="number" min="0" max="100" />

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
          @if ($child['id'] !== $editedChildId)
            <div wire:click="editMode({{ $child['id'] }})" class="rounded-lg border border-transparent px-2 py-1 hover:cursor-pointer hover:border-gray-200 hover:bg-gray-50">
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
          @else
            <!-- edit child form -->
            <form wire:submit="update" class="items-center rounded-lg border border-gray-200 bg-white p-3 hover:border-gray-300 dark:border-gray-700 dark:bg-gray-900" x-data="{
              showName: {{ $child['name'] ? 'true' : 'false' }},
              showAge: {{ $child['age'] ? 'true' : 'false' }},
              showSchool: {{ $child['school'] ? 'true' : 'false' }},
              showGradeLevel: {{ $child['grade_level'] ? 'true' : 'false' }},
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

                <x-text-input x-ref="showAge" wire:model="age" wire:keydown.escape="toggleAddMode" class="mt-1 block w-full" id="age" name="age" type="number" min="0" max="100" />

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

              <div class="flex flex-col">
                <div class="flex justify-between border-b border-gray-200 pb-2">
                  <x-button.secondary wire:click="resetEdit" class="mr-2">
                    {{ __('Cancel') }}
                  </x-button.secondary>

                  <x-button.primary type="submit">
                    {{ __('Save') }}
                  </x-button.primary>
                </div>

                <x-button.danger type="button" wire:confirm="{{ __('Are you sure you want to proceed? This can not be undone.') }}" wire:click="delete({{ $child['id'] }})">
                  {{ __('Delete') }}
                </x-button.danger>
              </div>
            </form>
          @endif
        @endforeach
      </div>
    </div>
  @else
    @if (! $addMode)
      <div wire:click="toggleAddMode" class="group mb-8 flex cursor-pointer items-center rounded-lg border border-gray-200 bg-white p-3 shadow-md hover:border-gray-300 dark:border-gray-700 dark:bg-gray-900">
        <div class="-rotate-12 rounded border border-gray-200 bg-white p-1 transition group-hover:rotate-0 group-hover:border-blue-500">
          <x-lucide-baby class="h-4 w-4 text-gray-500 group-hover:text-blue-500" />
        </div>
        <span id="blank-state" class="ml-3 text-gray-500 group-hover:text-gray-800">{{ __('Add kids') }}</span>
      </div>
    @endif
  @endif
</div>
