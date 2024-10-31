<?php
/**
 * @var \App\Models\Vault $vault
 * @var array $ethnicities
 * @var array $genders
 * @var array $routes
 */
?>

<x-app-layout :vault="$vault">
  <x-slot name="breadcrumb">
    <div class="flex text-sm">
      <p class="mr-2">{{ __('You are here:') }}</p>
      <ul class="text-sm">
        <li class="inline after:text-xs after:text-gray-500 after:content-['>']">
          <x-link href="{{ $routes['contact']['index'] }}">
            {{ __('All the contacts') }}
          </x-link>
        </li>
        <li class="inline">
          {{ __('Add a contact') }}
        </li>
      </ul>
    </div>
  </x-slot>

  <main class="relative mt-16 sm:mt-24">
    <div class="mx-auto max-w-lg px-2 py-2 sm:py-6">
      <form method="post" action="{{ $routes['contact']['store'] }}" class="mb-6 overflow-hidden rounded-lg border border-gray-200 bg-white shadow-md dark:border-gray-700 dark:bg-gray-900">
        @csrf
        @method('post')

        <div class="rounded-t-lg border-b border-gray-200 bg-slate-200 p-3 sm:p-5 dark:border-gray-700 dark:bg-blue-900">
          <h1 class="text-center text-2xl font-medium">
            {{ __('Add a contact') }}
          </h1>
        </div>

        <!-- list of fields -->
        <div class="border-b border-gray-200 p-5 dark:border-gray-700" x-data="{
          showPrefix: false,
          showMiddleName: false,
          showSuffix: false,
          showNickname: false,
          showMaidenName: false,
          showEthnicity: false,
          showGender: false,
          showPatronymicName: false,
          showTribalName: false,
          showGenerationName: false,
          showRomanizedName: false,
          showNationality: false,
          showMaritalStatus: false,
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

          <!-- nationality -->
          <div x-cloak x-show="showNationality" x-transition class="relative mb-5">
            <x-input-label for="nationality" :value="__('Nationality')" :optional="true" />
            <x-text-input class="mt-1 block w-full" id="nationality" name="nationality" type="text" x-ref="nationality" />
            <x-input-error class="mt-2" :messages="$errors->get('nationality')" />
          </div>

          <!-- gender -->
          <div x-cloak x-show="showGender" x-transition class="relative mb-5">
            <x-input-label for="gender_id" :value="__('Gender')" />
            <select class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:text-gray-400 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600" id="gender_id" name="gender_id">
              @foreach ($genders as $gender)
                <option :value="{{ $gender['id'] }}">{{ $gender['name'] }}</option>
              @endforeach
            </select>
            <p class="mt-1 text-xs text-gray-500">
              {{ __('Gender is the classification of people based on their biological sex.') }}
            </p>
          </div>

          <!-- marital status -->
          <div x-cloak x-show="showMaritalStatus" x-transition class="relative mb-5">
            <x-input-label for="marital_status_id" :value="__('Marital status')" />
            <select class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:text-gray-400 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600" id="marital_status_id" name="marital_status_id">
              @foreach ($maritalStatuses as $maritalStatus)
                <option :value="{{ $maritalStatus['id'] }}">{{ $maritalStatus['name'] }}</option>
              @endforeach
            </select>
          </div>

          <!-- ethnicity -->
          <div x-cloak x-show="showEthnicity" x-transition class="relative mb-5">
            <x-input-label for="ethnicity_id" :value="__('Ethnicity')" />
            <select class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:text-gray-400 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600" id="ethnicity_id" name="ethnicity_id">
              @foreach ($ethnicities as $ethnicity)
                <option :value="{{ $ethnicity['id'] }}">{{ $ethnicity['name'] }}</option>
              @endforeach
            </select>
            <p class="mt-1 text-xs text-gray-500">
              {{ __('Ethnicity is the classification of people based on their shared cultural, social, and genetic characteristics.') }}
            </p>
          </div>

          <!-- patronymic name -->
          <div x-cloak x-show="showPatronymicName" x-transition class="relative mb-5">
            <x-input-label for="patronymic_name" :value="__('Patronymic name')" :optional="true" />
            <x-text-input class="mt-1 block w-full" id="patronymic_name" name="patronymic_name" type="text" x-ref="patronymicname" />
            <p class="mt-1 text-xs text-gray-500">
              {{ __('Patronymic name is a name derived from a parent’s name, common in Icelandic, Russian, and some Arabic cultures.') }}
            </p>
            <x-input-error class="mt-2" :messages="$errors->get('patronymic_name')" />
          </div>

          <!-- tribal name -->
          <div x-cloak x-show="showTribalName" x-transition class="relative mb-5">
            <x-input-label for="tribal_name" :value="__('Tribal name')" :optional="true" />
            <x-text-input class="mt-1 block w-full" id="tribal_name" name="tribal_name" type="text" x-ref="tribalname" />
            <p class="mt-1 text-xs text-gray-500">
              {{ __('Tribal name is a name used in various African and Indigenous cultures, like Zulu clan names.') }}
            </p>
            <x-input-error class="mt-2" :messages="$errors->get('tribal_name')" />
          </div>

          <!-- generation name -->
          <div x-cloak x-show="showGenerationName" x-transition class="relative mb-5">
            <x-input-label for="generation_name" :value="__('Generation name')" :optional="true" />
            <x-text-input class="mt-1 block w-full" id="generation_name" name="generation_name" type="text" x-ref="generationname" />
            <p class="mt-1 text-xs text-gray-500">
              {{ __('Generation name is a name used in Japanese, Chinese, Korean, and Vietnamese culture where part of the name is shared by siblings or cousins to signify their generation.') }}
            </p>
            <x-input-error class="mt-2" :messages="$errors->get('generation_name')" />
          </div>

          <!-- romanized name -->
          <div x-cloak x-show="showRomanizedName" x-transition class="relative mb-5">
            <x-input-label for="romanized_name" :value="__('Romanized name')" :optional="true" />
            <x-text-input class="mt-1 block w-full" id="romanized_name" name="romanized_name" type="text" x-ref="romanizedname" />
            <p class="mt-1 text-xs text-gray-500">
              {{ __('Romanized name is the Latin alphabet transliteration of a non-Latin name.') }}
            </p>
            <x-input-error class="mt-2" :messages="$errors->get('romanized_name')" />
          </div>

          <!-- other fields -->
          <div class="flex flex-wrap text-xs">
            <span x-cloak x-show="! showPrefix" class="mb-2 me-2 flex cursor-pointer flex-wrap rounded-lg border bg-slate-200 px-1 py-1 hover:bg-slate-300 dark:bg-slate-500" x-on:click="
              showPrefix = true
              $nextTick(() => {
                $refs.prefix.focus()
              })
            ">
              {{ __('+ prefix') }}
            </span>
            <span x-cloak x-show="! showMiddleName" class="mb-2 me-2 flex cursor-pointer flex-wrap rounded-lg border bg-slate-200 px-1 py-1 hover:bg-slate-300 dark:bg-slate-500" x-on:click="
              showMiddleName = true
              $nextTick(() => {
                $refs.middlename.focus()
              })
            ">
              {{ __('+ middle name') }}
            </span>
            <span x-cloak x-show="! showSuffix" class="mb-2 me-2 flex cursor-pointer flex-wrap rounded-lg border bg-slate-200 px-1 py-1 hover:bg-slate-300 dark:bg-slate-500" x-on:click="
              showSuffix = true
              $nextTick(() => {
                $refs.suffix.focus()
              })
            ">
              {{ __('+ suffix') }}
            </span>
            <span x-cloak x-show="! showNickname" class="mb-2 me-2 flex cursor-pointer flex-wrap rounded-lg border bg-slate-200 px-1 py-1 hover:bg-slate-300 dark:bg-slate-500" x-on:click="
              showNickname = true
              $nextTick(() => {
                $refs.nickname.focus()
              })
            ">
              {{ __('+ nickname') }}
            </span>
            <span x-cloak x-show="! showMaidenName" class="mb-2 me-2 flex cursor-pointer flex-wrap rounded-lg border bg-slate-200 px-1 py-1 hover:bg-slate-300 dark:bg-slate-500" x-on:click="
              showMaidenName = true
              $nextTick(() => {
                $refs.maidenname.focus()
              })
            ">
              {{ __('+ maiden name') }}
            </span>
            <span x-cloak x-show="! showNationality" x-on:click="showNationality = true" class="mb-2 me-2 flex cursor-pointer flex-wrap rounded-lg border bg-slate-200 px-1 py-1 hover:bg-slate-300 dark:bg-slate-500">
              {{ __('+ nationality') }}
            </span>
            <span x-cloak x-show="! showGender" x-on:click="showGender = true" class="mb-2 me-2 flex cursor-pointer flex-wrap rounded-lg border bg-slate-200 px-1 py-1 hover:bg-slate-300 dark:bg-slate-500">
              {{ __('+ gender') }}
            </span>
            <span x-cloak x-show="! showMaritalStatus" x-on:click="showMaritalStatus = true" class="mb-2 me-2 flex cursor-pointer flex-wrap rounded-lg border bg-slate-200 px-1 py-1 hover:bg-slate-300 dark:bg-slate-500">
              {{ __('+ marital status') }}
            </span>
            <span x-cloak x-show="! showEthnicity" x-on:click="showEthnicity = true" class="mb-2 me-2 flex cursor-pointer flex-wrap rounded-lg border bg-slate-200 px-1 py-1 hover:bg-slate-300 dark:bg-slate-500">
              {{ __('+ ethnicity') }}
            </span>
            <span x-cloak x-show="! showPatronymicName" x-on:click="showPatronymicName = true" class="mb-2 me-2 flex cursor-pointer flex-wrap rounded-lg border bg-slate-200 px-1 py-1 hover:bg-slate-300 dark:bg-slate-500">
              {{ __('+ patronymic name') }}
            </span>
            <span x-cloak x-show="! showTribalName" x-on:click="showTribalName = true" class="mb-2 me-2 flex cursor-pointer flex-wrap rounded-lg border bg-slate-200 px-1 py-1 hover:bg-slate-300 dark:bg-slate-500">
              {{ __('+ tribal name') }}
            </span>
            <span x-cloak x-show="! showGenerationName" x-on:click="showGenerationName = true" class="mb-2 me-2 flex cursor-pointer flex-wrap rounded-lg border bg-slate-200 px-1 py-1 hover:bg-slate-300 dark:bg-slate-500">
              {{ __('+ generation name') }}
            </span>
            <span x-cloak x-show="! showRomanizedName" x-on:click="showRomanizedName = true" class="mb-2 me-2 flex cursor-pointer flex-wrap rounded-lg border bg-slate-200 px-1 py-1 hover:bg-slate-300 dark:bg-slate-500">
              {{ __('+ romanized name') }}
            </span>
          </div>
        </div>

        <!-- actions -->
        <div class="flex justify-between p-5">
          <x-button.secondary navigate href="{{ $routes['contact']['index'] }}">
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
