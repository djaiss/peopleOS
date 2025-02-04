<?php
/*
 * @var array $genders
 */
?>

<h2 class="font-semi-bold mb-1 text-lg">
  {{ __('All the genders in the account') }}
</h2>

<p class="mb-4 text-sm text-zinc-500">
  {{ __('Genders are used to identify the gender of a person.') }}
</p>

<div class="mb-8 border border-gray-200 bg-white sm:rounded-lg">
  <!-- nb of genders + action -->
  <div id="add-gender-form" class="flex items-center justify-between rounded-t-lg border-b border-gray-200 p-3 last:rounded-b-lg last:border-b-0 hover:bg-blue-50">
    @if ($genders->isEmpty())
      <p class="text-sm text-zinc-500">{{ __('No genders created') }}</p>
    @else
      <p class="text-sm text-zinc-500">{{ __(':count gender(s)', ['count' => $genders->count()]) }}</p>
    @endif

    <x-button.secondary x-target="add-gender-form" href="{{ route('administration.personalization.genders.new') }}" class="mr-2 text-sm">
      {{ __('New gender') }}
    </x-button.secondary>
  </div>

  <div id="gender-list" class="divide-y divide-gray-200">
    @forelse ($genders as $gender)
      <div id="gender-{{ $gender['id'] }}" class="group flex items-center justify-between p-3 transition-colors duration-200 last:rounded-b-lg">
        <p class="border border-transparent py-1 text-sm font-semibold">{{ $gender['name'] }}</p>

        <div class="flex gap-2">
          <x-button.invisible x-target="gender-{{ $gender['id'] }}" href="{{ route('administration.personalization.genders.edit', $gender['id']) }}" class="hidden text-sm group-hover:block">
            {{ __('Edit') }}
          </x-button.invisible>

          <form x-target="gender-{{ $gender['id'] }}" x-on:ajax:before="
            confirm('Are you sure you want to proceed? This can not be undone.') ||
              $event.preventDefault()
          " action="{{ route('administration.personalization.genders.destroy', $gender['id']) }}" method="POST">
            @csrf
            @method('DELETE')

            <x-button.invisible class="hidden text-sm group-hover:block">
              {{ __('Delete') }}
            </x-button.invisible>
          </form>
        </div>
      </div>
    @empty
      <div class="flex flex-col items-center justify-center p-6 text-center">
        <x-lucide-dna class="h-8 w-8 text-gray-400" />
        <h3 class="mt-2 text-sm font-semibold text-gray-900">{{ __('Genders represent the identify of a person.') }}</h3>
        <p class="mt-1 text-sm text-gray-500">{{ __('Get started by creating a new gender.') }}</p>
      </div>
    @endforelse
  </div>
</div>
