<?php
/*
 * @var array $journalTemplates
 */
?>

<h2 class="font-semi-bold mb-1 text-lg">
  {{ __('Edit your journal templates') }}
</h2>

<p class="mb-4 text-sm text-zinc-500">
  {{ __('A journal template lets you define the content of your journal entries. You can create as many templates as you want.') }}
</p>

<div class="mb-8 border border-gray-200 bg-white sm:rounded-lg">
  <!-- nb of categories + action -->
  <div id="add-category-form" class="flex items-center justify-between rounded-t-lg border-b border-gray-200 p-3 last:rounded-b-lg last:border-b-0 hover:bg-blue-50">
    @if ($journalTemplates->isEmpty())
      <p class="text-sm text-zinc-500">{{ __('No templates created') }}</p>
    @else
      <p class="text-sm text-zinc-500">{{ __(':count template(s)', ['count' => $journalTemplates->count()]) }}</p>
    @endif

    <x-button.secondary href="{{ route('administration.personalization.journal-templates.new') }}" class="mr-2 text-sm">
      {{ __('New template') }}
    </x-button.secondary>
  </div>

  <div id="journal-template-list" class="divide-y divide-gray-200">
    @forelse ($journalTemplates as $template)
      <div id="journal-template-{{ $template['id'] }}" class="group flex items-center justify-between p-3 transition-colors duration-200 last:rounded-b-lg">
        <div class="flex items-center gap-2">
          <p class="border border-transparent py-1 text-sm font-semibold">{{ $template['name'] }}</p>
          <p class="text-sm text-zinc-500">{{ __(':columns columns, :questions questions total', ['columns' => $template['columns'], 'questions' => $template['questions']]) }}</p>
        </div>

        <div class="flex gap-2">
          <x-button.invisible href="{{ route('administration.personalization.journal-templates.edit', $template['id']) }}" class="hidden text-sm group-hover:block">
            {{ __('Edit') }}
          </x-button.invisible>

          <form x-target="journal-template-{{ $template['id'] }} journal-template-list" x-on:ajax:before="
            confirm(
              '{{ __('Are you sure you want to proceed? This can not be undone.') }}',
            ) || $event.preventDefault()
          " action="{{ route('administration.personalization.journal-templates.destroy', $template['id']) }}" method="POST">
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
        <h3 class="mt-2 text-sm font-semibold text-gray-900">{{ __('No templates yet') }}</h3>
        <p class="mt-1 text-sm text-gray-500">{{ __('Get started by creating a new template.') }}</p>
      </div>
    @endforelse
  </div>
</div>
