<?php
/*
 * @var Person $person
 * @var Collection $children
 */
?>

<section class="mb-8">
  <div class="mb-4 flex items-center justify-between">
    <div class="flex items-center gap-2">
      <x-lucide-baby class="h-5 w-5 text-blue-500" />
      <h2 class="text-lg font-semibold text-gray-900">{{ __('Children') }}</h2>
    </div>
    <a x-target="new-child-relationship" href="{{ route('person.children.new', $person) }}" class="inline-flex items-center gap-1 rounded-md border border-transparent bg-blue-50 px-2 py-1 text-sm font-medium text-blue-600 hover:border-blue-300 hover:bg-blue-100">
      <x-lucide-plus class="h-4 w-4" />
      {{ __('Add child') }}
    </a>
  </div>

  <div id="new-child-relationship"></div>

  <div id="children-listing" class="rounded-lg border border-gray-200 bg-white">
    <div class="divide-y divide-gray-200">
      @forelse ($children as $child)
        <div id="current-child-relationship-{{ $child['id'] }}" class="group p-4">
          <div class="group flex items-center justify-between gap-3">
            <div class="min-w-0 flex-1">
              <div class="flex items-center gap-1 border border-transparent py-1 text-sm">
                @if ($child['name'])
                  <p class="truncate font-medium text-gray-900">{{ $child['name'] }}</p>
                @else
                  <p class="truncate text-gray-900 italic">{{ __('Unknown name') }}</p>
                @endif
              </div>
            </div>
            <div class="flex items-center gap-2">
              <form x-target="current-child-relationship-{{ $child['id'] }} children-status children-listing" x-on:ajax:before="
                confirm('Are you sure you want to proceed? This can not be undone.') ||
                  $event.preventDefault()
              " action="{{ route('person.children.destroy', ['slug' => $person->slug, 'child' => $child['id']]) }}" method="POST">
                @csrf
                @method('DELETE')

                <x-button.invisible class="hidden text-sm group-hover:block">
                  {{ __('Delete') }}
                </x-button.invisible>
              </form>
            </div>
          </div>
        </div>
      @empty
        <div class="flex flex-col items-center justify-center p-8 text-center">
          <!-- Decorative heart icon -->
          <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-rose-100">
            <x-lucide-heart class="h-6 w-6 text-rose-600" />
          </div>

          <!-- Text content -->
          <h3 class="mt-4 text-sm font-semibold text-gray-900">{{ __('No children recorded') }}</h3>
          <p class="mt-1 text-sm text-gray-500">{{ __('Keep track of children, present and future.') }}</p>

          <!-- Call to action -->
          <div class="mt-6">
            <a x-target="new-child-relationship" href="{{ route('person.children.new', $person) }}" class="inline-flex items-center gap-1 rounded-md bg-rose-50 px-3 py-2 text-sm font-medium text-rose-600 hover:bg-rose-100">
              <x-lucide-plus class="h-4 w-4" />
              {{ __('Add first child') }}
            </a>
          </div>
        </div>
      @endforelse
    </div>
  </div>
</section>
