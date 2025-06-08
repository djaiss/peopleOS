<?php
/*
 * @var \App\Models\Person $person
 */
?>

<div class="flex h-[calc(100vh-48px)] flex-col overflow-hidden bg-white">
  <!-- Contact header -->
  <div class="border-b border-gray-200 p-6">
    <!-- name + title + age -->
    <div id="profile-header" class="mb-6 flex items-center gap-4">
      <div class="h-16 w-16 shrink-0">
        <img class="h-16 w-16 rounded-full object-cover p-[0.1875rem] shadow-sm ring-1 ring-slate-900/10" src="{{ $person->getAvatar(64) }}" srcset="{{ $person->getAvatar(64) }}, {{ $person->getAvatar(128) }} 2x" alt="{{ $person->name }}" loading="lazy" />
      </div>
      <div class="flex min-w-0 flex-col gap-1">
        <!-- name -->
        <h1 class="truncate text-xl font-semibold">{{ $person->name }}</h1>

        <!-- job -->
        @php
          $job = $person->job();
        @endphp

        @if ($job)
          <span class="text-sm text-gray-600">{{ $job }}</span>
        @endif

        <!-- age -->
        @if ($person->age)
          <span class="text-sm text-gray-600">{{ $person->age }}</span>
        @endif
      </div>
    </div>

    <!-- Personal details -->
    <div class="space-y-2">
      <!-- Relationship status -->
      <div class="flex items-center gap-2">
        <x-lucide-heart class="h-4 w-4 flex-shrink-0 text-rose-500" />
        @include('persons.partials.marital-statuses', ['person' => $person])
      </div>

      <!-- Children -->
      <div id="children-status" class="flex items-center gap-2">
        <x-lucide-baby class="h-4 w-4 text-blue-500" />
        <span class="text-sm">{{ $person->getChildrenStatus() }}</span>
      </div>

      <!-- Pets -->
      <div class="flex items-center gap-2">
        <x-lucide-dog class="h-4 w-4 text-amber-500" />
        <span class="text-sm">Pet parent of Max (Golden Retriever)</span>
      </div>
    </div>
  </div>

  <!-- Navigation menu -->
  <nav class="border-b border-gray-200">
    <div class="flex flex-col">
      <a href="{{ route('person.show', ['slug' => $person['slug']]) }}" class="{{ request()->routeIs('person.show') ? 'border-blue-500 bg-blue-50' : '' }} group flex items-center gap-3 border-l-2 border-transparent px-4 py-3 hover:bg-gray-50">
        <x-lucide-scan-face class="{{ request()->routeIs('person.show') ? 'text-blue-500' : 'text-gray-500' }} h-4 w-4 transition-all duration-400 grouphover:-translate-y-0.5 group-hover:-rotate-3" />
        <span class="{{ request()->routeIs('person.show') ? 'text-blue-700' : 'text-gray-600' }} text-sm font-medium">{{ __('Overview') }}</span>
      </a>
      <a href="{{ route('person.life-event.index', ['slug' => $person['slug']]) }}" class="{{ request()->routeIs('person.life-event.index') ? 'border-blue-500 bg-blue-50' : '' }} group flex items-center gap-3 border-l-2 border-transparent px-4 py-3 hover:bg-gray-50">
        <x-lucide-radical class="h-4 w-4 text-gray-500" />
        <span class="text-sm font-medium text-gray-600">{{ __('Life events') }}</span>
      </a>
      <a href="{{ route('person.note.index', ['slug' => $person['slug']]) }}" class="{{ request()->routeIs('person.note.index') ? 'border-blue-500 bg-blue-50' : '' }} group flex items-center gap-3 border-l-2 border-transparent px-4 py-3 hover:bg-gray-50">
        <x-lucide-book-open class="{{ request()->routeIs('person.note.index') ? 'text-blue-500' : 'text-gray-500' }} h-4 w-4 transition-all duration-400 grouphover:-translate-y-0.5 group-hover:-rotate-3" />
        <span class="{{ request()->routeIs('person.note.index') ? 'text-blue-700' : 'text-gray-600' }} text-sm font-medium">Notes</span>
      </a>

      <a href="{{ route('person.family.index', ['slug' => $person['slug']]) }}" class="{{ request()->routeIs('person.family.index') ? 'border-blue-500 bg-blue-50' : '' }} group flex items-center gap-3 border-l-2 border-transparent px-4 py-3 hover:bg-gray-50">
        <x-lucide-person-standing class="{{ request()->routeIs('person.family.index') ? 'text-blue-500' : 'text-gray-500' }} h-4 w-4 transition-all duration-400 grouphover:-translate-y-0.5 group-hover:-rotate-3" />
        <span class="{{ request()->routeIs('person.family.index') ? 'text-blue-700' : 'text-gray-600' }} text-sm font-medium">{{ __('Love & family') }}</span>
      </a>

      <a href="{{ route('person.reminder.index', ['slug' => $person['slug']]) }}" class="{{ request()->routeIs('person.reminder.index') ? 'border-blue-500 bg-blue-50' : '' }} group flex items-center gap-3 border-l-2 border-transparent px-4 py-3 hover:bg-gray-50">
        <x-lucide-bell class="{{ request()->routeIs('person.reminder.index') ? 'text-blue-500' : 'text-gray-500' }} h-4 w-4 transition-all duration-400 grouphover:-translate-y-0.5 group-hover:-rotate-3" />
        <span class="{{ request()->routeIs('person.reminder.index') ? 'text-blue-700' : 'text-gray-600' }} text-sm font-medium">{{ __('Tasks and reminders') }}</span>
      </a>
      <a href="{{ route('person.gift.index', ['slug' => $person['slug']]) }}" class="{{ request()->routeIs('person.gift.index') ? 'border-blue-500 bg-blue-50' : '' }} group flex items-center gap-3 border-l-2 border-transparent px-4 py-3 hover:bg-gray-50">
        <x-lucide-gift class="{{ request()->routeIs('person.gift.index') ? 'text-blue-500' : 'text-gray-500' }} h-4 w-4 transition-all duration-400 grouphover:-translate-y-0.5 group-hover:-rotate-3" />
        <span class="{{ request()->routeIs('person.gift.index') ? 'text-blue-700' : 'text-gray-600' }} text-sm font-medium">{{ __('Gifts') }}</span>
      </a>
      {{--
        <a href="#" class="group flex items-center gap-3 border-l-2 border-transparent px-4 py-3 hover:bg-gray-50">
        <x-lucide-folder class="h-4 w-4 text-gray-500" />
        <span class="text-sm font-medium text-gray-600">Files</span>
        </a>
      --}}
      <a href="{{ route('person.work.index', ['slug' => $person['slug']]) }}" class="{{ request()->routeIs('person.work.index') ? 'border-blue-500 bg-blue-50' : '' }} group flex items-center gap-3 border-l-2 border-transparent px-4 py-3 hover:bg-gray-50">
        <x-lucide-briefcase class="{{ request()->routeIs('person.work.index') ? 'text-blue-500' : 'text-gray-500' }} h-4 w-4 transition-all duration-400 grouphover:-translate-y-0.5 group-hover:-rotate-3" />
        <span class="{{ request()->routeIs('person.work.index') ? 'text-blue-700' : 'text-gray-600' }} text-sm font-medium">{{ __('Work') }}</span>
      </a>
      <a href="{{ route('person.food.index', ['slug' => $person['slug']]) }}" class="{{ request()->routeIs('person.food.index') ? 'border-blue-500 bg-blue-50' : '' }} group flex items-center gap-3 border-l-2 border-transparent px-4 py-3 hover:bg-gray-50">
        <x-lucide-cooking-pot class="{{ request()->routeIs('person.food.index') ? 'text-blue-500' : 'text-gray-500' }} h-4 w-4 transition-all duration-400 grouphover:-translate-y-0.5 group-hover:-rotate-3" />
        <span class="{{ request()->routeIs('person.food.index') ? 'text-blue-700' : 'text-gray-600' }} text-sm font-medium">{{ __('Food') }}</span>
      </a>
      <a href="{{ route('person.settings.index', ['slug' => $person['slug']]) }}" class="{{ request()->routeIs('person.settings.index') ? 'border-blue-500 bg-blue-50' : '' }} group flex items-center gap-3 border-l-2 border-transparent px-4 py-3 hover:bg-gray-50">
        <x-lucide-settings class="{{ request()->routeIs('person.settings.index') ? 'text-blue-500' : 'text-gray-500' }} h-4 w-4 transition-all duration-400 grouphover:-translate-y-0.5 group-hover:-rotate-3" />
        <span class="{{ request()->routeIs('person.settings.index') ? 'text-blue-700' : 'text-gray-600' }} text-sm font-medium">{{ __('Edit information') }}</span>
      </a>
    </div>
  </nav>
</div>
