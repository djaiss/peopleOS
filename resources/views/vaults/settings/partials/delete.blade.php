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

  <form action="{{ route('vaults.destroy', $vault) }}" method="POST" class="mb-1 px-5 py-2 text-center">
    @csrf
    @method('DELETE')

    <x-button.secondary type="submit" onclick="return confirm('{{ __('Are you sure? This can not be undone.') }}')" :class="'me-3 border-red-600 text-red-600 dark:border-red-400 dark:text-red-400'" dusk="delete-vault-cta">
      {{ __('Delete the vault') }}
    </x-button.secondary>
  </form>
</div>
