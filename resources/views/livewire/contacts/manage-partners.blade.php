<div>
  @if ($addMode)
    <!-- add partner form -->
    <form wire:submit="store" class="mb-8 items-center rounded-lg border border-gray-200 bg-white p-3 shadow-md hover:border-gray-300 dark:border-gray-700 dark:bg-gray-900" x-data="{
      showName: false,
      showOccupation: false,
      showNumberYearsTogether: false,
    }">
      <div class="relative mb-5">
        <x-input-label for="marital_status_id" :value="__('Marital status')" />
        <select wire:model="maritalStatusId" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:text-gray-400 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600" id="marital_status_id" name="marital_status_id">
          @foreach ($maritalStatuses as $maritalStatus)
            <option value="{{ $maritalStatus['id'] }}">{{ $maritalStatus['name'] }}</option>
          @endforeach
        </select>

        <x-input-error class="mt-2" :messages="$errors->get('maritalStatusId')" />
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

        <x-text-input x-ref="showOccupation" wire:model="occupation" wire:keydown.escape="toggleAddMode" class="mt-1 block w-full" id="occupation" name="occupation" type="text" />

        <x-input-error class="mt-2" :messages="$errors->get('occupation')" />
      </div>

      <!-- number of years together -->
      <div x-cloak x-show="showNumberYearsTogether" class="relative mb-4">
        <x-input-label for="number_of_years_together" :optional="true" :value="__('Number of years together')" />

        <x-text-input x-ref="showNumberYearsTogether" wire:model="numberOfYearsTogether" wire:keydown.escape="toggleAddMode" class="mt-1 block w-full" id="number_of_years_together" name="number_of_years_together" type="text" />

        <x-input-error class="mt-2" :messages="$errors->get('numberOfYearsTogether')" />
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

        <span x-cloak x-show="! showOccupation" class="mb-2 me-2 flex cursor-pointer flex-wrap rounded-lg border bg-slate-200 px-1 py-1 hover:bg-slate-300 dark:bg-slate-500" x-on:click="
          showOccupation = true
          $nextTick(() => {
            $refs.showOccupation.focus()
          })
        ">
          {{ __('+ occupation') }}
        </span>

        <span x-cloak x-show="! showNumberYearsTogether" class="mb-2 me-2 flex cursor-pointer flex-wrap rounded-lg border bg-slate-200 px-1 py-1 hover:bg-slate-300 dark:bg-slate-500" x-on:click="
          showNumberYearsTogether = true
          $nextTick(() => {
            $refs.showNumberYearsTogether.focus()
          })
        ">
          {{ __('+ number of years together') }}
        </span>
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

  @if ($partners->count() > 0)
    <div class="relative mb-8 rounded-lg border border-gray-200 bg-white p-3 pt-7 shadow-md hover:border-gray-300 dark:border-gray-700 dark:bg-gray-900">
      <div class="absolute -top-3 w-full">
        <div class="flex justify-between">
          <div class="flex items-center rounded-full border bg-white py-1 pl-2 pr-3 text-sm">
            <x-lucide-heart class="mr-2 h-4 w-4 text-gray-500" />
            <div>{{ __('Partners') }}</div>
          </div>

          <div class="absolute -top-1 right-6 cursor-pointer rounded-full border border-gray-300 bg-white p-2 hover:bg-gray-100">
            <span wire:click="toggleAddMode">
              <x-lucide-plus class="h-4 w-4 text-gray-500" />
            </span>
          </div>
        </div>
      </div>

      @foreach ($partners as $partner)
        @if ($partner['id'] !== $editedPartnerId)
          <p wire:click="editMode({{ $partner['id'] }})" class="rounded-lg border border-transparent px-2 py-1 hover:cursor-pointer hover:border-gray-200 hover:bg-gray-50">
            {{ $partner['marital_status']['label'] }}
            @if ($partner['number_of_years_together'])
              <span class="text-gray-500">({{ $partner['number_of_years_together'] }} years)</span>
            @endif

            @if ($partner['name'])
              with
              <span class="text-gray-500">{{ $partner['name'] }}</span>
            @endif

            @if ($partner['occupation'])
              who works as a
              <span class="text-gray-500">{{ $partner['occupation'] }}</span>
            @endif
          </p>
        @else
          <!-- edit partner form -->
          <form wire:submit="update" class="items-center rounded-lg border border-gray-200 bg-white p-3 hover:border-gray-300 dark:border-gray-700 dark:bg-gray-900" x-data="{
            showName: {{ $partner['name'] ? 'true' : 'false' }},
            showOccupation: {{ $partner['occupation'] ? 'true' : 'false' }},
            showNumberYearsTogether:
              {{ $partner['number_of_years_together'] ? 'true' : 'false' }},
          }">
            <div class="relative mb-5">
              <x-input-label for="marital_status_id" :value="__('Marital status')" />
              <select wire:model="maritalStatusId" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:text-gray-400 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600" id="marital_status_id" name="marital_status_id">
                @foreach ($maritalStatuses as $maritalStatus)
                  <option value="{{ $maritalStatus['id'] }}">{{ $maritalStatus['name'] }}</option>
                @endforeach
              </select>

              <x-input-error class="mt-2" :messages="$errors->get('maritalStatusId')" />
            </div>

            <!-- name -->
            <div x-cloak x-show="showName" class="relative mb-4">
              <x-input-label for="name" :optional="true" :value="__('Name')" />
              <x-text-input x-ref="showName" wire:model="name" wire:keydown.escape="resetEdit" class="mt-1 block w-full" id="name" name="name" type="text" />
              <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <!-- occupation -->
            <div x-cloak x-show="showOccupation" class="relative mb-4">
              <x-input-label for="occupation" :optional="true" :value="__('Occupation')" />
              <x-text-input x-ref="showOccupation" wire:model="occupation" wire:keydown.escape="resetEdit" class="mt-1 block w-full" id="occupation" name="occupation" type="text" />
              <x-input-error class="mt-2" :messages="$errors->get('occupation')" />
            </div>

            <!-- number of years together -->
            <div x-cloak x-show="showNumberYearsTogether" class="relative mb-4">
              <x-input-label for="number_of_years_together" :optional="true" :value="__('Number of years together')" />
              <x-text-input x-ref="showNumberYearsTogether" wire:model="numberOfYearsTogether" wire:keydown.escape="resetEdit" class="mt-1 block w-full" id="number_of_years_together" name="number_of_years_together" type="text" />
              <x-input-error class="mt-2" :messages="$errors->get('numberOfYearsTogether')" />
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

              <span x-cloak x-show="! showOccupation" class="mb-2 me-2 flex cursor-pointer flex-wrap rounded-lg border bg-slate-200 px-1 py-1 hover:bg-slate-300 dark:bg-slate-500" x-on:click="
                showOccupation = true
                $nextTick(() => {
                  $refs.showOccupation.focus()
                })
              ">
                {{ __('+ occupation') }}
              </span>

              <span x-cloak x-show="! showNumberYearsTogether" class="mb-2 me-2 flex cursor-pointer flex-wrap rounded-lg border bg-slate-200 px-1 py-1 hover:bg-slate-300 dark:bg-slate-500" x-on:click="
                showNumberYearsTogether = true
                $nextTick(() => {
                  $refs.showNumberYearsTogether.focus()
                })
              ">
                {{ __('+ number of years together') }}
              </span>
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

              <x-button.danger type="button" wire:confirm="{{ __('Are you sure you want to proceed? This can not be undone.') }}" wire:click="delete({{ $partner['id'] }})">
                {{ __('Delete') }}
              </x-button.danger>
            </div>
          </form>
        @endif
      @endforeach
    </div>
  @else
    <div wire:click="toggleAddMode" class="group mb-8 flex cursor-pointer items-center rounded-lg border border-gray-200 bg-white p-3 shadow-md hover:border-gray-400 dark:border-gray-700 dark:bg-gray-900">
      <div class="-rotate-12 rounded border border-gray-200 bg-white p-1 transition group-hover:rotate-0 group-hover:border-blue-500">
        <x-lucide-heart class="h-4 w-4 text-gray-500 group-hover:text-blue-500" />
      </div>
      <span id="blank-state" class="ml-3 text-gray-500 group-hover:text-gray-800">{{ __('Add partner') }}</span>
    </div>
  @endif
</div>
