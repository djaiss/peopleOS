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

  <main class="relative mt-16 sm:mt-24">
    <div class="mx-auto max-w-lg px-2 py-2 sm:py-6">
      <form method="post" action="{{ route('vaults.contacts.store', ['vault' => $vault]) }}" class="mb-6 rounded-lg border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-900">
        @csrf

        <div class="section-head border-b border-gray-200 bg-blue-50 p-5 dark:border-gray-700 dark:bg-blue-900">
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
        }">
          <!-- prefix -->
          <div x-cloak x-show="showPrefix" x-transition class="relative mb-5">
            <x-input-label for="prefix" :value="__('Prefix')" :optional="true" />
            <x-text-input class="mt-1 block w-full" id="prefix" name="prefix" type="text" x-ref="prefix" />
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
            <x-input-label for="last_name" :value="__('Last name')" />
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
            <x-input-error class="mt-2" :messages="$errors->get('maiden_name')" />
          </div>

          <!-- suffix -->
          <div x-cloak x-show="showSuffix" x-transition class="relative mb-5">
            <x-input-label for="suffix" :value="__('Suffix')" :optional="true" />
            <x-text-input class="mt-1 block w-full" id="suffix" name="suffix" type="text" x-ref="suffix" />
            <x-input-error class="mt-2" :messages="$errors->get('suffix')" />
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
          </div>
        </div>

        <!-- actions -->
        <div class="flex justify-between p-5">
          <x-button.secondary href="{{ route('vaults.contacts.index', ['vault' => $vault]) }}">
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
