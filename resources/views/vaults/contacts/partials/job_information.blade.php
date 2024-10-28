<?php
/**
 * @var array $vault
 * @var array $contact
 * @var array $companies
 */
?>

<div id="job-information" class="mb-2 flex w-full items-center">
  {{-- <x-heroicon-o-briefcase class="mr-2 h-4 w-4 flex-shrink-0 text-gray-500" /> --}}

  <div
    class="w-full"
    x-data="{
      editMode: false,
      hasSearchResults: false,
      search: '{{ old('company_name', $contact['company']['name']) }}',
      get getCompanies() {
        const filterItems = this.companies.filter((item) => {
          return item.name.toLowerCase().includes(this.search.toLowerCase())
        })
        if (filterItems.length <= this.companies.length && filterItems.length > 0) {
          this.hasSearchResults = true
          return filterItems
        } else {
          this.hasSearchResults = false
        }
      },
      cleanSearch(e) {
        this.hasSearchResults = false
        this.search = e.target.innerText
      },
      closeSearch() {
        this.hasSearchResults = false
      },
      companies: {{ json_encode($companies) }},
    }">
    <div x-show="! editMode">
      @if ($contact['job_title'])
        <span>
          <span x-on:click="editMode = true" dusk="job-information" class="cursor-pointer hover:bg-yellow-300">{{ $contact['job_title'] }}</span>

          @if ($contact['company']['name'])
            ({{ $contact['company']['name'] }})
          @endif
        </span>
      @else
        <span x-on:click="editMode = true" class="cursor-pointer border-b border-dotted border-gray-500 text-gray-500 hover:bg-yellow-300" dusk="blank-job-information">{{ __('Add job information') }}</span>
      @endif
    </div>

    <div x-cloak x-show="editMode">
      <form hx-target="#job-information" hx-swap="outerHTML" hx-put="{{ route('vaults.contacts.job-information.update', ['vault' => $vault, 'slug' => $contact['slug']]) }}" class="mb-4">
        @csrf
        @method('PUT')

        <!-- job title -->
        <div class="relative mb-2">
          <x-input-label for="job_title" :value="__('Job title')" />

          <x-text-input :value="old('job_title', $contact['job_title'])" @keyup.escape="editMode = false" class="mt-1 block w-full" id="job_title" name="job_title" type="text" required autofocus />

          <x-input-error class="mt-2" :messages="$errors->get('job_title')" />
        </div>

        <!-- company -->
        <div class="relative mb-2">
          <x-input-label for="company_name" :value="__('Company name')" />

          <div class="relative">
            <x-text-input @input="getCompanies" x-model="search" :value="old('company_name', $contact['company']['name'])" @keyup.escape="editMode = false" class="mt-1 block w-full" id="company_name" name="company_name" type="text" required />

            <ul x-cloack x-show="hasSearchResults" @click.outside="closeSearch" class="absolute z-50 w-full rounded-b-lg border border-gray-300 bg-white">
              <template x-for="company in getCompanies" :key="company.id">
                <li class="border-b border-gray-300 px-3 py-1">
                  <a x-text="company.name" @click="cleanSearch"></a>
                </li>
              </template>
            </ul>
          </div>

          <x-input-error class="mt-2" :messages="$errors->get('company_name')" />
        </div>

        <div class="flex justify-end">
          <div class="flex items-center">
            <x-button.secondary x-on:click="editMode = false" class="mr-2">
              {{ __('Cancel') }}
            </x-button.secondary>

            <x-button.primary type="submit" dusk="update-job-information">
              {{ __('Save') }}
            </x-button.primary>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
