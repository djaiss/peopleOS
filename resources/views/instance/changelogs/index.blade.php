<?php
/*
 *
 */
?>

<x-app-layout>
  <!-- Admin panel indicator -->
  <div class="border-b border-yellow-200 bg-yellow-50">
    <div class="mx-auto flex max-w-7xl items-center justify-center gap-x-3 px-4 py-2 sm:px-6 lg:px-8">
      <x-lucide-shield class="h-4 w-4 text-yellow-600" />
      <span class="text-sm font-medium text-yellow-800">{{ __('Instance administration area') }}</span>
    </div>
  </div>

  <!-- Breadcrumb -->
  <nav class="border-b border-gray-200 bg-white">
    <div class="mx-auto flex max-w-7xl items-center gap-x-3 px-4 py-3 sm:px-6 lg:px-8">
      <div class="flex items-center gap-x-3 text-sm text-gray-500">
        <a href="{{ route('dashboard.index') }}" class="hover:text-gray-700">{{ __('Dashboard') }}</a>
        <x-lucide-chevron-right class="h-4 w-4" />
        <a href="{{ route('instance.index') }}" class="hover:text-gray-700">{{ __('Instance administration') }}</a>
        <x-lucide-chevron-right class="h-4 w-4" />
        <span class="text-gray-700">{{ __('Changelog management') }}</span>
      </div>
    </div>
  </nav>

  <div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
      @include('instance.partials.menu')

      <div class="mb-6 flex justify-end">
        <a href="{{ route('instance.changelog.new') }}" class="inline-flex items-center gap-2 rounded-md border border-blue-600 bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700">
          <x-lucide-plus class="h-4 w-4" />
          {{ __('New changelog') }}
        </a>
      </div>

      <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12">
          <div class="rounded-lg border border-gray-200 bg-white shadow-sm">
            <div class="border-b border-gray-200 px-4 py-3">
              <h2 class="text-base font-semibold text-gray-900">{{ __('Changelogs') }}</h2>
            </div>
            @forelse($changelogs as $changelog)
              <div class="group border-b border-gray-200 p-4 text-sm last:border-b-0">
                <div class="flex flex-col gap-2">
                  <div class="flex items-center justify-between gap-4">
                    <div class="flex flex-col gap-1">
                      <div class="font-medium text-gray-900">{{ $changelog->title }}</div>
                      <div class="text-xs text-gray-500">
                        @if ($changelog->published_at)
                          {{ __('Published at:') }} {{ $changelog->published_at->format('Y-m-d H:i') }}
                        @else
                          <span class="rounded bg-yellow-100 px-2 py-0.5 text-xs font-medium text-yellow-800">{{ __('Draft') }}</span>
                        @endif
                      </div>
                    </div>
                    <div class="flex items-center gap-2">
                      <a href="{{ route('instance.changelog.edit', $changelog->id) }}" class="inline-flex items-center gap-1 rounded-md border border-gray-300 bg-white px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-50">
                        <x-lucide-pencil class="h-3 w-3" /> {{ __('Edit') }}
                      </a>
                      <form method="post" action="{{ route('instance.changelog.destroy', $changelog->id) }}" onsubmit="return confirm('{{ __('Are you sure? This action cannot be undone.') }}')">
                        @csrf
                        @method('delete')
                        <button type="submit" class="inline-flex items-center gap-1 rounded-md border border-red-200 bg-white px-3 py-1.5 text-xs font-medium text-red-600 hover:bg-red-50">
                          <x-lucide-trash-2 class="h-3 w-3" /> {{ __('Delete') }}
                        </button>
                      </form>
                    </div>
                  </div>
                  <div class="prose max-w-none text-xs text-gray-600 line-clamp-3">{{ Str::limit($changelog->description, 200) }}</div>
                </div>
              </div>
            @empty
              <div class="flex items-center justify-center p-6 text-sm text-gray-500">{{ __('No changelogs found') }}</div>
            @endforelse
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
