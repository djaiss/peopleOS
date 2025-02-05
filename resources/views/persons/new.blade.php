<?php
/*
 * @var Collection $genders
 */
?>

<x-app-layout>
  <main class="grid min-h-[calc(100vh-48px)] place-items-center bg-gray-50">
    <div class="mx-auto w-full max-w-lg px-2 py-2 sm:py-6">
      <form method="post" action="{{ route('persons.store') }}" class="mb-6 overflow-hidden rounded-lg border border-gray-200 bg-white shadow-md dark:border-gray-700 dark:bg-gray-900">
        @csrf
        @method('post')

        <div class="rounded-t-lg border-b border-gray-200 bg-slate-200 p-3 sm:p-5 dark:border-gray-700 dark:bg-blue-900">
          <h1 class="text-center text-2xl font-medium">
            {{ __('Add a person') }}
          </h1>
        </div>

        <!-- list of fields -->
        <div class="border-b border-gray-200 p-5 dark:border-gray-700" x-data="{
          showPrefix: false,
          showMiddleName: false,
          showSuffix: false,
          showNickname: false,
          showMaidenName: false,
          showGender: false,
        }">
          <!-- prefix -->
          <div x-cloak x-show="showPrefix" x-transition class="relative mb-5">
            <x-input-label for="prefix" :value="__('Prefix')" :optional="true" />
            <x-text-input class="mt-1 block w-full" id="prefix" name="prefix" type="text" x-ref="prefix" />
            <p class="mt-1 text-xs text-gray-500">
              {{ __('Prefix is a title or honorific that precedes a name, like Mr., Mrs., Dr., etc.') }}
            </p>
            <x-input-error class="mt-2" :messages="$errors->get('prefix')" />
          </div>

          <!-- first name -->
          <div class="relative mb-5">
            <x-input-label for="first_name" :value="__('First name')" />
            <x-text-input class="mt-1 block w-full" id="first_name" name="first_name" type="text" required autofocus />
            <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
          </div>

          <!-- last name -->
          <div class="relative mb-5">
            <x-input-label for="last_name" :value="__('Last name')" :optional="true" />
            <x-text-input class="mt-1 block w-full" id="last_name" name="last_name" type="text" />
            <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
          </div>

          <!-- marital status -->
          <div class="relative mb-5">
            <x-input-label for="marital_status_id" :value="__('Marital status')" />
            <select class="mt-1 block w-full rounded-md border-gray-300 shadow-xs focus:border-indigo-500 focus:ring-indigo-500 disabled:text-gray-400 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600" id="marital_status_id" name="marital_status_id">
              @foreach ($maritalStatuses as $maritalStatus)
                <option value="{{ $maritalStatus['id'] }}">{{ $maritalStatus['name'] }}</option>
              @endforeach
            </select>
            <p class="mt-1 text-xs text-gray-500">
              {{ __('Marital statuses can be managed in the administration area.') }}
            </p>
          </div>

          <!-- middle name -->
          <div x-cloak x-show="showMiddleName" x-transition class="relative mb-5">
            <x-input-label for="middle_name" :value="__('Middle name')" :optional="true" />
            <x-text-input class="mt-1 block w-full" id="middle_name" name="middle_name" type="text" x-ref="middlename" />
            <x-input-error class="mt-2" :messages="$errors->get('middle_name')" />
          </div>

          <!-- nickname -->
          <div x-cloak x-show="showNickname" x-transition class="relative mb-5">
            <x-input-label for="nickname" :value="__('Nickname')" :optional="true" />
            <x-text-input class="mt-1 block w-full" id="nickname" name="nickname" type="text" x-ref="nickname" />
            <x-input-error class="mt-2" :messages="$errors->get('nickname')" />
          </div>

          <!-- maiden name -->
          <div x-cloak x-show="showMaidenName" x-transition class="relative mb-5">
            <x-input-label for="maiden_name" :value="__('Maiden name')" :optional="true" />
            <x-text-input class="mt-1 block w-full" id="maiden_name" name="maiden_name" type="text" x-ref="maidenname" />
            <p class="mt-1 text-xs text-gray-500">
              {{ __('Maiden name is the name a woman uses before she was married.') }}
            </p>
            <x-input-error class="mt-2" :messages="$errors->get('maiden_name')" />
          </div>

          <!-- suffix -->
          <div x-cloak x-show="showSuffix" x-transition class="relative mb-5">
            <x-input-label for="suffix" :value="__('Suffix')" :optional="true" />
            <x-text-input class="mt-1 block w-full" id="suffix" name="suffix" type="text" x-ref="suffix" />
            <p class="mt-1 text-xs text-gray-500">
              {{ __('Suffix is a term that follows a name, like Jr., Sr., III, etc.') }}
            </p>
            <x-input-error class="mt-2" :messages="$errors->get('suffix')" />
          </div>

          <!-- gender -->
          <div x-cloak x-show="showGender" x-transition class="relative mb-5">
            <x-input-label for="gender_id" :value="__('Gender')" />
            <select class="mt-1 block w-full rounded-md border-gray-300 shadow-xs focus:border-indigo-500 focus:ring-indigo-500 disabled:text-gray-400 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600" id="gender_id" name="gender_id">
              @foreach ($genders as $gender)
                <option :value="{{ $gender['id'] }}">{{ $gender['name'] }}</option>
              @endforeach
            </select>
            <p class="mt-1 text-xs text-gray-500">
              {{ __('Gender is the classification of people based on their biological sex.') }}
            </p>
          </div>

          <!-- other fields -->
          <div class="flex flex-wrap text-xs">
            <span x-cloak x-show="! showPrefix" class="me-2 mb-2 flex cursor-pointer flex-wrap rounded-lg border bg-slate-200 px-1 py-1 hover:bg-slate-300 dark:bg-slate-500" x-on:click="
              showPrefix = true
              $nextTick(() => {
                $refs.prefix.focus()
              })
            ">
              {{ __('+ prefix') }}
            </span>
            <span x-cloak x-show="! showMiddleName" class="me-2 mb-2 flex cursor-pointer flex-wrap rounded-lg border bg-slate-200 px-1 py-1 hover:bg-slate-300 dark:bg-slate-500" x-on:click="
              showMiddleName = true
              $nextTick(() => {
                $refs.middlename.focus()
              })
            ">
              {{ __('+ middle name') }}
            </span>
            <span x-cloak x-show="! showSuffix" class="me-2 mb-2 flex cursor-pointer flex-wrap rounded-lg border bg-slate-200 px-1 py-1 hover:bg-slate-300 dark:bg-slate-500" x-on:click="
              showSuffix = true
              $nextTick(() => {
                $refs.suffix.focus()
              })
            ">
              {{ __('+ suffix') }}
            </span>
            <span x-cloak x-show="! showNickname" class="me-2 mb-2 flex cursor-pointer flex-wrap rounded-lg border bg-slate-200 px-1 py-1 hover:bg-slate-300 dark:bg-slate-500" x-on:click="
              showNickname = true
              $nextTick(() => {
                $refs.nickname.focus()
              })
            ">
              {{ __('+ nickname') }}
            </span>
            <span x-cloak x-show="! showMaidenName" class="me-2 mb-2 flex cursor-pointer flex-wrap rounded-lg border bg-slate-200 px-1 py-1 hover:bg-slate-300 dark:bg-slate-500" x-on:click="
              showMaidenName = true
              $nextTick(() => {
                $refs.maidenname.focus()
              })
            ">
              {{ __('+ maiden name') }}
            </span>

            @if (count($genders) > 0)
              <span x-cloak x-show="! showGender" x-on:click="showGender = true" class="me-2 mb-2 flex cursor-pointer flex-wrap rounded-lg border bg-slate-200 px-1 py-1 hover:bg-slate-300 dark:bg-slate-500">
                {{ __('+ gender') }}
              </span>
            @endif
          </div>
        </div>

        <!-- actions -->
        <div class="flex justify-between p-5">
          <x-button.secondary navigate href="{{ route('persons.index') }}">
            {{ __('Cancel') }}
          </x-button.secondary>

          <x-button.primary dusk="submit-form-button">
            {{ __('Create') }}
          </x-button.primary>
        </div>
      </form>
    </div>
  </main>
</x-app-layout>
