<div class="relative mb-8 rounded-lg border border-gray-200 bg-gray-50 p-3 dark:border-gray-700 dark:bg-gray-900">
  <!-- plus button -->
  <div class="absolute -top-4 w-full">
    <div class="flex justify-between">
      <div class="flex items-center rounded-full border bg-white py-1 pl-2 pr-3 text-sm">
        <svg class="mr-2 text-gray-500" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M9 12h.01" />
          <path d="M15 12h.01" />
          <path d="M10 16c.5.3 1.2.5 2 .5s1.5-.2 2-.5" />
          <path d="M19 6.3a9 9 0 0 1 1.8 3.9 2 2 0 0 1 0 3.6 9 9 0 0 1-17.6 0 2 2 0 0 1 0-3.6A9 9 0 0 1 12 3c2 0 3.5 1.1 3.5 2.5s-.9 2.5-2 2.5c-.8 0-1.5-.4-1.5-1" />
        </svg>
        <div>Kids</div>
      </div>

      <div class="button -left-6 flex cursor-pointer items-center rounded border bg-white text-sm">
        <x-heroicon-o-plus class="h-4 w-4" />
      </div>
    </div>
  </div>

  <!-- add kid form -->
  <div>
    <!-- choose gender -->
    <div x-data="{ selected: null }" class="mb-2 mt-4 grid grid-cols-3 space-x-2">
      <div @click="selected = 'boy'" class="flex cursor-pointer flex-col items-center rounded-lg border border-gray-200 py-3 hover:bg-white">
        <input x-model="selected" name="gender" value="boy" type="radio" class="mb-2" />
        <span class="mb-1 text-2xl">
          <svg class="h-6 w-6" viewBox="0 0 36 36" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" preserveAspectRatio="xMidYMid meet" fill="#000000">
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
        </span>
        <span class="text-xs text-gray-600">{{ __('Boy') }}</span>
      </div>
      <div @click="selected = 'girl'" class="flex cursor-pointer flex-col items-center rounded-lg border border-gray-200 py-3 hover:bg-white">
        <input x-model="selected" name="gender" value="girl" type="radio" class="mb-2" />
        <span class="mb-1 text-2xl">
          <svg class="h-6 w-6" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" preserveAspectRatio="xMidYMid meet" fill="#000000">
            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
            <g id="SVGRepo_iconCarrier">
              <path d="M57.9 40S61 34.4 61 26c0-11-8.1-24-29-24S3 15 3 26c0 8.4 3.1 14 3.1 14C2.5 44.1.3 52.4 3.4 57.8c1.3 2.2 14.1 10 15.3-3.9h26.4c1.3 13.8 14.1 6.1 15.3 3.9c3.2-5.4 1-13.7-2.5-17.8" fill="#f367a3"></path>
              <path d="M32 6C16.7 6 5.5 14 5.5 24C5.5 24 9.6 9 32 9s25.5 15 25.5 15C57.5 14 47.3 6 32 6z" fill="#c28fef"></path>
              <path d="M57.3 42c6.2 0 6.2-9 0-9v-3s-35-.9-43-13c2 12.2-7.7 16-7.7 16c-6.2 0-6.2 9 0 9c0 7 7.3 18 25.3 18s25.4-11 25.4-18" fill="#f9e9cf"></path>
              <g fill="#ffffff">
                <circle cx="44.5" cy="36.5" r="6.5"></circle>
                <circle cx="19.5" cy="36.5" r="6.5"></circle>
              </g>
              <circle cx="44.5" cy="36.5" r="4.5" fill="#cd4460"></circle>
              <circle cx="44.5" cy="36.5" r="1.5" fill="#231f20"></circle>
              <circle cx="19.5" cy="36.5" r="4.5" fill="#cd4460"></circle>
              <circle cx="19.5" cy="36.5" r="1.5" fill="#231f20"></circle>
              <path d="M40.1 48.1c-5.2 3.6-11 3.6-16.2 0c-.6-.4-1.2.3-.8 1c1.6 2.6 4.8 4.9 8.9 4.9s7.3-2.3 8.9-4.9c.4-.7-.2-1.4-.8-1" fill="#d64426"></path>
            </g>
          </svg>
        </span>
        <span class="text-xs text-gray-600">{{ __('Girl') }}</span>
      </div>
      <div @click="selected = 'other'" class="flex cursor-pointer flex-col items-center rounded-lg border border-gray-200 py-3 hover:bg-white">
        <input x-model="selected" name="gender" value="other" type="radio" class="mb-2" />
        <span class="mb-1 text-2xl">
          <svg class="h-6 w-6" viewBox="0 0 36 36" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" preserveAspectRatio="xMidYMid meet" fill="#000000">
            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
            <g id="SVGRepo_iconCarrier">
              <path fill="#d4d4d4" d="M21.906 1.262c-2.02-.654-6.772-.475-7.96 1.069c-3.089.059-6.713 2.851-7.188 6.535c-.47 3.645.578 5.338.951 8.079c.422 3.106 2.168 4.099 3.564 4.515C13.281 24.114 15.415 24 19 24c7 0 10.334-4.684 10.629-12.639c.178-4.812-2.645-8.456-7.723-10.099z"></path>
              <path fill="#d4d4d4" d="M27 21H9a4 4 0 0 0-4 4v11h26V25a4 4 0 0 0-4-4z"></path>
              <path fill="#acacac" d="M25.904 11.734c-.677-.938-1.545-1.693-3.446-1.96c.713.327 1.396 1.455 1.485 2.079c.089.624.178 1.129-.386.505c-2.261-2.499-4.723-1.515-7.163-3.041c-1.703-1.067-2.222-2.247-2.222-2.247s-.208 1.574-2.792 3.178c-.749.465-1.643 1.501-2.139 3.03c-.356 1.099-.246 2.079-.246 3.754c0 4.889 4.029 9 9 9s9-4.147 9-9c0-3.041-.318-4.229-1.091-5.298z"></path>
              <path fill="#DD551F" d="M10 27h1v9h-1z"></path>
              <path fill="#B78B60" d="M4.702 26.495l-.283-.059h-.511c0-.058.023-.112.035-.169a.994.994 0 0 1-.458-1.048c.112-.542.643-.89 1.186-.779l2.091.433h1.676c.863 0 1.562.7 1.562 1.564V28H6.253s-1.481-.669-1.551-1.505z"></path>
              <path fill="#acacac" d="M0 25.655c0-.432.35-.782.781-.782l4.69.782h3.747c.432 0 .781.351.781.781V28H5L.781 26.437S0 26.087 0 25.655z"></path>
              <path fill="#d4d4d4" d="M4 36h6v-8H5z"></path>
              <path fill="#DD551F" d="M25 27h1v9h-1z"></path>
              <path fill="#B78B60" d="M31.298 26.495l.283-.059h.511c0-.058-.023-.112-.035-.169a.994.994 0 0 0 .458-1.048a1.003 1.003 0 0 0-1.185-.779l-2.091.433h-1.676c-.863 0-1.562.7-1.562 1.564V28h3.747c-.001 0 1.48-.669 1.55-1.505z"></path>
              <path fill="#acacac" d="M36 25.655a.782.782 0 0 0-.781-.782l-4.691.782h-3.747a.781.781 0 0 0-.781.781V28h5l4.219-1.563s.781-.35.781-.782z"></path>
              <path fill="#d4d4d4" d="M32 36h-6v-8h5z"></path>
              <path fill="#C1694F" d="M19 19.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 0 1zm1.5 3.5H20a.5.5 0 0 1 0-1h.5a.5.5 0 0 1 0 1z"></path>
              <path fill="#662113" d="M14 16a1 1 0 0 1-1-1v-1a1 1 0 0 1 2 0v1a1 1 0 0 1-1 1zm8 0a1 1 0 0 1-1-1v-1a1 1 0 1 1 2 0v1a1 1 0 0 1-1 1z"></path>
            </g>
          </svg>
        </span>

        <span class="text-xs text-gray-600">{{ __('Other') }}</span>
      </div>
    </div>

    <!-- name -->
    <div class="relative mb-4">
      <x-input-label for="job_title" :optional="true" :value="__('Name')" />

      <x-text-input @keyup.escape="editMode = false" class="mt-1 block w-full" id="job_title" name="job_title" type="text" />

      <x-input-error class="mt-2" :messages="$errors->get('job_title')" />
    </div>

    <div class="flex justify-between">
      <x-button.secondary x-on:click="editMode = false" class="mr-2">
        {{ __('Cancel') }}
      </x-button.secondary>

      <x-button.primary type="submit" dusk="update-job-information">
        {{ __('Save') }}
      </x-button.primary>
    </div>
  </div>
</div>
