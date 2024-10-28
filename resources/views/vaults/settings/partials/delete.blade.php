<!-- title + cta -->
<div class="mb-3 mt-8 items-center justify-between sm:mt-0 sm:flex">
  <h3 class="mb-4 flex items-center sm:mb-0">
    <x-lucide-trash class="me-2 h-4 text-gray-600" />

    {{ __('Delete the vault') }}
  </h3>
</div>

<div class="mb-6 rounded border bg-gray-50 text-sm shadow-md">
  <div class="flex rounded-t border-b border-gray-200 bg-slate-50 px-3 py-2 dark:border-gray-700 dark:bg-slate-900">
    <x-lucide-badge-info class="relative top-1 h-4 grow pe-2" />

    <div>
      <p>
        {{ __('Deleting the vault means deleting all the data inside this vault, forever. There is no turning back. Please be certain.') }}
      </p>
    </div>
  </div>

  <form action="{{ route('vaults.destroy', $vault) }}" method="POST" class="mb-1 px-5 py-2 text-center">
    @csrf
    @method('DELETE')

    <x-button.secondary type="submit" onclick="return confirm('{{ __('Are you sure? This can not be undone.') }}')" :class="'me-3 border-red-600 text-red-600 hover:bg-red-600 hover:text-white dark:border-red-400 dark:text-red-400 dark:hover:bg-red-400 dark:hover:text-white'" dusk="delete-vault-cta">
      {{ __('Delete the vault') }}
    </x-button.secondary>
  </form>
</div>
