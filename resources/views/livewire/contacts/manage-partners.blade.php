@if ($addMode)
  <!-- add partner form -->
  <form wire:submit="store" class="mb-8 items-center rounded-lg border border-gray-200 bg-white p-3 shadow-md hover:border-gray-300 dark:border-gray-700 dark:bg-gray-900" x-data="{
    showName: false,
    showOccupation: false,
    showNumberOfYearsTogether: false,
  }">
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

    <!-- occupation -->
    <div x-cloak x-show="showOccupation" class="relative mb-4">
      <x-input-label for="occupation" :optional="true" :value="__('Occupation')" />

      <x-text-input x-ref="showAge" wire:model="age" wire:keydown.escape="toggleAddMode" class="mt-1 block w-full" id="age" name="age" type="number" min="0" max="100" />

      <x-input-error class="mt-2" :messages="$errors->get('occupation')" />
    </div>

    <!-- number of years together -->
    <div x-cloak x-show="showNumberOfYearsTogether" class="relative mb-4">
      <x-input-label for="number_of_years_together" :optional="true" :value="__('Number of years together')" />

      <x-text-input x-ref="showGradeLevel" wire:model="gradeLevel" wire:keydown.escape="toggleAddMode" class="mt-1 block w-full" id="grade_level" name="grade_level" type="text" />

      <x-input-error class="mt-2" :messages="$errors->get('number_of_years_together')" />
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

<div wire:click="toggleAddMode" class="group mb-8 flex cursor-pointer items-center rounded-lg border border-gray-200 bg-white p-3 shadow-md hover:border-gray-400 dark:border-gray-700 dark:bg-gray-900">
  <div class="-rotate-12 rounded border border-gray-200 bg-white p-1 transition group-hover:rotate-0 group-hover:border-blue-500">
    <x-lucide-heart class="h-4 w-4 text-gray-500 group-hover:text-blue-500" />
  </div>
  <span id="blank-state" class="ml-3 text-gray-500 group-hover:text-gray-800">{{ __('Add partner') }}</span>
</div>
