<x-app-layout :vault="$vault">
  <x-slot name="breadcrumb">
    <div class="flex text-sm">
      <p class="mr-2">{{ __('You are here:') }}</p>
      <ul class="text-sm">
        <li class="inline after:text-xs after:text-gray-500 after:content-['>']">
          <x-link href="{{ route('vaults.contacts.index', ['vault' => $vault]) }}">
            {{ __('All the contacts') }}
          </x-link>
        </li>
        <li class="inline">
          {{ __('Add a contact') }}
        </li>
      </ul>
    </div>
  </x-slot>

  <main class="relative sm:mt-12">
    <div class="mx-auto max-w-7xl px-2 py-2 sm:px-0 sm:py-0">
      <form class="mb-6 rounded-lg border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-900" @submit.prevent="submit()">
        <div class="section-head border-b border-gray-200 bg-blue-50 p-5 dark:border-gray-700 dark:bg-blue-900">
          <h1 class="text-center text-2xl font-medium">
            {{ $t('Add a contact') }}
          </h1>
        </div>
        <div class="border-b border-gray-200 p-5 dark:border-gray-700">
          <errors :errors="form.errors" />

          <!-- prefix -->
          <text-input v-if="showPrefixField" :id="'prefix'" v-model="form.prefix" :class="'mb-5'" :input-class="'block w-full'" :required="false" :maxlength="255" :label="$t('Prefix')" />

          <!-- first name -->
          <text-input v-model="form.first_name" :autofocus="true" :class="'mb-5'" :input-class="'block w-full'" :required="true" :maxlength="255" :label="$t('First name')" />

          <!-- last name -->
          <text-input :id="'last_name'" v-model="form.last_name" :class="'mb-5'" :input-class="'block w-full'" :required="false" :maxlength="255" :label="$t('Last name')" />

          <!-- middle name -->
          <text-input v-if="showMiddleNameField" :id="'middle_name'" v-model="form.middle_name" :class="'mb-5'" :input-class="'block w-full'" :required="false" :maxlength="255" :label="$t('Middle name')" />

          <!-- nickname -->
          <text-input v-if="showNicknameField" :id="'nickname'" v-model="form.nickname" :class="'mb-5'" :input-class="'block w-full'" :required="false" :maxlength="255" :label="$t('Nickname')" />

          <!-- maiden name -->
          <text-input v-if="showMaidenNameField" :id="'maiden_name'" v-model="form.maiden_name" :class="'mb-5'" :input-class="'block w-full'" :required="false" :maxlength="255" :label="$t('Maiden name')" />

          <!-- suffix -->
          <text-input v-if="showSuffixField" :id="'suffix'" v-model="form.suffix" :class="'mb-5'" :input-class="'block w-full'" :required="false" :maxlength="255" :label="$t('Suffix')" />

          <!-- genders -->
          <dropdown v-if="showGenderField" v-model="form.gender_id" :data="data.genders" :required="false" :class="'mb-5'" :placeholder="$t('Choose a value')" :dropdown-class="'block w-full'" :label="$t('Gender')" />

          <!-- pronouns -->
          <dropdown v-if="showPronounField" v-model="form.pronoun_id" :data="data.pronouns" :required="false" :class="'mb-5'" :placeholder="$t('Choose a value')" :dropdown-class="'block w-full'" :label="$t('Pronoun')" />

          <!-- templates -->
          <dropdown v-if="showTemplateField" v-model="form.template_id" :data="data.templates" :required="false" :class="'mb-5'" :placeholder="$t('Choose a value')" :dropdown-class="'block w-full'" :label="$t('Use the following template for this contact')" />

          <!-- other fields -->
          <div class="flex flex-wrap text-xs">
            <span v-if="!showMiddleNameField" class="mb-2 me-2 flex cursor-pointer flex-wrap rounded-lg border bg-slate-200 px-1 py-1 hover:bg-slate-300 dark:bg-slate-500 dark:text-gray-900 dark:text-white" @click="displayMiddleNameField">
              {{ $t('+ middle name') }}
            </span>
            <span v-if="!showPrefixField" class="mb-2 me-2 flex cursor-pointer flex-wrap rounded-lg border bg-slate-200 px-1 py-1 hover:bg-slate-300 dark:bg-slate-500 dark:text-gray-900 dark:text-white" @click="displayPrefixField">
              {{ $t('+ prefix') }}
            </span>
            <span v-if="!showSuffixField" class="mb-2 me-2 flex cursor-pointer flex-wrap rounded-lg border bg-slate-200 px-1 py-1 hover:bg-slate-300 dark:bg-slate-500 dark:text-gray-900 dark:text-white" @click="displaySuffixField">
              {{ $t('+ suffix') }}
            </span>
            <span v-if="!showNicknameField" class="mb-2 me-2 flex cursor-pointer flex-wrap rounded-lg border bg-slate-200 px-1 py-1 hover:bg-slate-300 dark:bg-slate-500 dark:text-gray-900 dark:text-white" @click="displayNicknameField">
              {{ $t('+ nickname') }}
            </span>
            <span v-if="!showMaidenNameField" class="mb-2 me-2 flex cursor-pointer flex-wrap rounded-lg border bg-slate-200 px-1 py-1 hover:bg-slate-300 dark:bg-slate-500 dark:text-gray-900 dark:text-white" @click="displayMaidenNameField">
              {{ $t('+ maiden name') }}
            </span>
            <span v-if="data.genders.length > 0 && !showGenderField" class="mb-2 me-2 flex cursor-pointer flex-wrap rounded-lg border bg-slate-200 px-1 py-1 hover:bg-slate-300 dark:bg-slate-500 dark:text-gray-900 dark:text-white" @click="displayGenderField">
              {{ $t('+ gender') }}
            </span>
            <span v-if="data.pronouns.length > 0 && !showPronounField" class="mb-2 me-2 flex cursor-pointer flex-wrap rounded-lg border bg-slate-200 px-1 py-1 hover:bg-slate-300 dark:bg-slate-500 dark:text-gray-900 dark:text-white" @click="displayPronounField">
              {{ $t('+ pronoun') }}
            </span>
            <span v-if="data.templates.length > 0 && !showTemplateField" class="mb-2 me-2 flex cursor-pointer flex-wrap rounded-lg border bg-slate-200 px-1 py-1 hover:bg-slate-300 dark:bg-slate-500 dark:text-gray-900 dark:text-white" @click="displayTemplateField">
              {{ $t('+ change template') }}
            </span>
          </div>
        </div>

        <!-- actions -->
        <div class="flex justify-between p-5">
          <pretty-link :href="data.url.back" :text="$t('Cancel')" :class="'me-3'" />
          <pretty-button :href="'data.url.vault.create'" :text="$t('Add')" :state="loadingState" :icon="'check'" :class="'save'" />
        </div>
      </form>
    </div>
  </main>
</x-app-layout>
