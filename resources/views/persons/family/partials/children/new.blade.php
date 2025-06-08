<?php
/*
 * @var Person $person
 * @var Collection $potentialParents
 */
?>

<div id="new-child-relationship" class="mb-8 rounded-lg border border-gray-200 bg-white">
  <form x-target="children-listing new-child-relationship children-status" x-target.back="new-child-relationship" action="{{ route('person.children.store', $person) }}" method="POST">
    @csrf

    <div class="mb-4 flex gap-4 px-4 pt-4">
      <div class="flex-1">
        <x-input-label optional for="first_name" :value="__('First name')" class="mb-1" />
        <x-text-input class="block w-full" id="first_name" name="first_name" type="text" />
        <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
      </div>
      <div class="flex-1">
        <x-input-label optional for="last_name" :value="__('Last name')" class="mb-1" />
        <x-text-input class="block w-full" id="last_name" name="last_name" type="text" />
        <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
      </div>
    </div>

    <!-- parents -->
    <div class="flex flex-col gap-2 px-4">
      <div class="mb-2">
        <x-input-label for="second_parent" :value="__('First parent')" class="mb-1" />
        <div class="flex items-center gap-2">
          <div class="h-6 w-6 shrink-0">
            <img class="h-6 w-6 rounded-full object-cover p-[0.1875rem] shadow-sm ring-1 ring-slate-900/10" src="{{ $person->getAvatar(64) }}" srcset="{{ $person->getAvatar(64) }}, {{ $person->getAvatar(128) }} 2x" alt="{{ $person->name }}" loading="lazy" />
          </div>
          <h1 class="">{{ $person->name }}</h1>
        </div>
      </div>

      @if ($potentialParents->count() > 0)
        <div class="mb-4">
          <div x-data="{ showSecondParent: false }">
            <template x-if="!showSecondParent">
              <button type="button" @click="showSecondParent = true" class="flex cursor-pointer items-center gap-2 rounded-md border border-transparent bg-gray-50 p-1 text-sm text-gray-500 shadow-xs hover:border-gray-300">
                <x-lucide-plus class="h-4 w-4" />
                {{ __('Add second parent') }}
              </button>
            </template>
            <template x-if="showSecondParent">
              <div class="mb-2">
                <x-input-label for="second_parent" :value="__('Second parent')" class="mb-1" />
                <select id="second_parent_id" name="second_parent_id" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                  <option value="0">{{ __('Select a parent...') }}</option>
                  @foreach ($potentialParents as $parent)
                    <option value="{{ $parent['id'] }}">{{ $parent['name'] }}</option>
                  @endforeach
                </select>
                <x-input-error :messages="$errors->get('second_parent_id')" class="mt-2" />
              </div>
            </template>
          </div>
        </div>
      @endif
    </div>

    <div class="flex items-center justify-between border-t border-gray-200 px-4 py-4">
      <x-button.secondary x-target="new-child-relationship" href="{{ route('person.family.index', $person) }}">
        {{ __('Cancel') }}
      </x-button.secondary>

      <x-button.primary>
        {{ __('Create relationship') }}
      </x-button.primary>
    </div>
  </form>
</div>
