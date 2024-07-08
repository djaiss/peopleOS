<!-- title + cta -->
<div class="mb-3 mt-8 items-center justify-between sm:mt-0 sm:flex">
  <h3 class="mb-4 sm:mb-0">
    <span class="me-1">🗑</span>
    {{ __('Delete the vault') }}
  </h3>
</div>

<div class="mb-6 rounded border text-sm">
  <div class="mb-2 flex rounded-t border-b border-gray-200 bg-slate-50 px-3 py-2 dark:border-gray-700 dark:bg-slate-900">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 grow pe-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>

    <div>
      <p>
        {{ __('Deleting the vault means deleting all the data inside this vault, forever. There is no turning back. Please be certain.') }}
      </p>
    </div>
  </div>

  <p class="mb-1 px-5 py-2 text-center">
    <x-button.secondary x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-vault-deletion')" :class="'me-3 border-red-600 text-red-600 dark:border-red-400 dark:text-red-400'" dusk="delete-vault-cta">
      {{ __('Delete the vault') }}
    </x-button.secondary>
  </p>

  <x-modal name="confirm-vault-deletion" :show="false" focusable>
    <form method="post" action="{{ route('vaults.destroy', $vault) }}" class="p-6">
      @csrf
      @method('delete')

      <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
        {{ __('Are you sure you want to delete this vault?') }}
      </h2>

      <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
        {{ __('Once the vault is deleted, all of its resources and data will be permanently deleted.') }}
      </p>

      <div class="mt-6 flex justify-end">
        <x-button.secondary x-on:click="$dispatch('close')">
          {{ __('Cancel') }}
        </x-button.secondary>

        <x-button.primary class="ms-3" dusk="destroy-vault-cta">
          {{ __('Delete') }}
        </x-button.primary>
      </div>
    </form>
  </x-modal>
</div>
