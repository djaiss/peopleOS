<div>
  <h2 class="font-semi-bold mb-1 text-lg">
    {{ __('Work History') }}
  </h2>

  <p class="mb-4 text-sm text-zinc-500">
    {{ __('Track professional journey and career milestones.') }}
  </p>

  <div class="mb-8 rounded-lg border border-gray-200 bg-white">
    <!-- Add Job Form -->
    <div class="border-b border-gray-200 p-4">
      <button type="button" class="flex w-full items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
        <x-lucide-plus class="h-4 w-4" />
        {{ __('Add work experience') }}
      </button>

      <!-- add job form -->
    </div>

    <!-- Job List -->
    <div class="divide-y divide-gray-200">
      <div class="group flex items-center justify-between p-4">
        <div class="flex items-center gap-3">
          <span class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-100">
            <x-lucide-briefcase class="h-4 w-4 text-blue-600" />
          </span>
          <div>
            <h3 class="font-medium">
              Senior Software Engineer
              <span class="rounded-full bg-green-100 px-2 py-1 text-xs font-medium text-green-800">Current</span>
            </h3>
            <p class="text-sm text-gray-600">Google • 13 years • $110,000</p>
          </div>
        </div>
        <div class="flex gap-2">
          <x-button.invisible @click="$wire.toggleEditMode(item.id)" class="hidden text-sm group-hover:block">
            {{ __('Edit') }}
          </x-button.invisible>

          <x-button.invisible @click="confirm('{{ __('Are you sure you want to proceed? This can not be undone.') }}') ? $wire.delete(item.id) : false" class="hidden text-sm group-hover:block">
            {{ __('Delete') }}
          </x-button.invisible>
        </div>
      </div>

      <div class="group flex items-center justify-between p-4">
        <div class="flex items-center gap-3">
          <span class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-100">
            <x-lucide-briefcase class="h-4 w-4 text-blue-600" />
          </span>
          <div>
            <h3 class="font-medium">Software Engineer</h3>
            <p class="text-sm text-gray-600">Google • 13 years • $32,000</p>
          </div>
        </div>
        <div class="flex gap-2">
          <x-button.invisible @click="$wire.toggleEditMode(item.id)" class="hidden text-sm group-hover:block">
            {{ __('Edit') }}
          </x-button.invisible>

          <x-button.invisible @click="confirm('{{ __('Are you sure you want to proceed? This can not be undone.') }}') ? $wire.delete(item.id) : false" class="hidden text-sm group-hover:block">
            {{ __('Delete') }}
          </x-button.invisible>
        </div>
      </div>
    </div>
  </div>
</div>
