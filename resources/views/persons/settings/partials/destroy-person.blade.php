<h2 class="font-semi-bold mb-1 text-lg">
  {{ __('Delete person') }}
</h2>

<p class="mb-4 text-sm text-zinc-500">
  {{ __('All the data related to this person will be deleted. Please be certain.') }}
</p>

<!--  -->
<div class="mb-6 rounded-lg border border-gray-200 bg-white">
  @if ($person->can_be_deleted)
    <form action="{{ route('person.settings.destroy', ['slug' => $person->slug]) }}" method="post">
      @csrf
      @method('delete')

      <div class="flex items-center justify-center gap-x-3 px-3 py-3">
        <button type="submit" onclick="return confirm('{{ __('Are you sure you want to delete this person? This action cannot be undone.') }}')" class="inline-flex items-center gap-x-2 rounded-md bg-red-600 px-3.5 py-2 text-sm font-semibold text-white shadow-xs hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">
          <x-lucide-trash-2 class="h-4 w-4" />
          {{ __('Delete person') }}
        </button>
      </div>
    </form>
  @else
    <div class="flex items-center gap-3 p-4">
      <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-amber-100">
        <x-lucide-shield-alert class="h-6 w-6 text-amber-600" />
      </div>
      <div>
        <h3 class="text-sm font-medium text-gray-900">{{ __('Contact cannot be deleted') }}</h3>
        <p class="mt-1 text-sm text-gray-500">
          {{ __('This contact is linked to other records or has special permissions that prevent deletion. Please review and remove any dependencies first.') }}
        </p>
      </div>
    </div>
  @endif
</div>
