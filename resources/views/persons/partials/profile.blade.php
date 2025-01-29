<?php
/*
 * @var array $person
 */
?>

<div class="flex h-[calc(100vh-48px)] flex-col overflow-hidden bg-white">
  <!-- Contact Header -->
  <div class="border-b border-gray-200 p-6">
    <livewire:persons.display-person-information :person="$person" />

    <!-- Personal Details -->
    <div class="space-y-4">
      <!-- Relationship Status -->
      <div class="flex items-center gap-2">
        <x-lucide-heart class="h-4 w-4 text-rose-500" />
        <span class="text-sm">
          Married to
          <a href="#" class="text-blue-600 hover:underline">Jane Smith</a>
        </span>
      </div>

      <!-- Children -->
      <div class="flex items-center gap-2">
        <x-lucide-baby class="h-4 w-4 text-blue-500" />
        <span class="text-sm">Father of Emma (8) and Lucas (5)</span>
      </div>

      <!-- Pets -->
      <div class="flex items-center gap-2">
        <x-lucide-dog class="h-4 w-4 text-amber-500" />
        <span class="text-sm">Pet parent of Max (Golden Retriever)</span>
      </div>
    </div>
  </div>

  <!-- Navigation Menu -->
  <nav class="border-b border-gray-200">
    <div class="flex flex-col">
      <a href="#" class="flex items-center gap-3 border-l-2 border-transparent px-4 py-3 hover:bg-gray-50">
        <x-lucide-history class="h-4 w-4 text-gray-500" />
        <span class="text-sm font-medium text-gray-600">History</span>
      </a>
      <a wire:navigate href="{{ route('persons.notes.index', ['slug' => $person['slug']]) }}" class="{{ request()->routeIs('persons.notes.index') ? 'border-blue-500 bg-blue-50' : '' }} flex items-center gap-3 border-l-2 border-transparent px-4 py-3">
        <x-lucide-book-open class="{{ request()->routeIs('persons.notes.index') ? 'text-blue-500' : 'text-gray-500' }} h-4 w-4" />
        <span class="{{ request()->routeIs('persons.notes.index') ? 'text-blue-700' : 'text-gray-600' }} text-sm font-medium">Notes</span>
      </a>
      <a wire:navigate href="{{ route('persons.family.index', ['slug' => $person['slug']]) }}" class="{{ request()->routeIs('persons.family.index') ? 'border-blue-500 bg-blue-50' : '' }} flex items-center gap-3 border-l-2 border-transparent px-4 py-3">
        <x-lucide-person-standing class="{{ request()->routeIs('persons.family.index') ? 'text-blue-500' : 'text-gray-500' }} h-4 w-4" />
        <span class="{{ request()->routeIs('persons.family.index') ? 'text-blue-700' : 'text-gray-600' }} text-sm font-medium">Family</span>
      </a>
      <a href="#" class="flex items-center gap-3 border-l-2 border-transparent px-4 py-3 hover:bg-gray-50">
        <x-lucide-bell class="h-4 w-4 text-gray-500" />
        <span class="text-sm font-medium text-gray-600">Reminders</span>
      </a>
      <a href="{{ route('persons.gifts.index') }}" class="flex items-center gap-3 border-l-2 border-transparent px-4 py-3 hover:bg-gray-50">
        <x-lucide-gift class="h-4 w-4 text-gray-500" />
        <span class="text-sm font-medium text-gray-600">Gifts</span>
      </a>
      <a href="#" class="flex items-center gap-3 border-l-2 border-transparent px-4 py-3 hover:bg-gray-50">
        <x-lucide-folder class="h-4 w-4 text-gray-500" />
        <span class="text-sm font-medium text-gray-600">Files</span>
      </a>
      <a wire:navigate href="{{ route('persons.work.index', ['slug' => $person['slug']]) }}" class="{{ request()->routeIs('persons.work.index') ? 'border-blue-500 bg-blue-50' : '' }} flex items-center gap-3 border-l-2 border-transparent px-4 py-3 hover:bg-gray-50">
        <x-lucide-briefcase class="{{ request()->routeIs('persons.work.index') ? 'text-blue-500' : 'text-gray-500' }} h-4 w-4" />
        <span class="{{ request()->routeIs('persons.work.index') ? 'text-blue-700' : 'text-gray-600' }} text-sm font-medium">{{ __('Work & Passions') }}</span>
      </a>
      <a wire:navigate href="{{ route('persons.settings.index', ['slug' => $person['slug']]) }}" class="{{ request()->routeIs('persons.settings.index') ? 'border-blue-500 bg-blue-50' : '' }} flex items-center gap-3 border-l-2 border-transparent px-4 py-3 hover:bg-gray-50">
        <x-lucide-settings class="{{ request()->routeIs('persons.settings.index') ? 'text-blue-500' : 'text-gray-500' }} h-4 w-4" />
        <span class="{{ request()->routeIs('persons.settings.index') ? 'text-blue-700' : 'text-gray-600' }} text-sm font-medium">{{ __('Edit information') }}</span>
      </a>
    </div>
  </nav>
</div>
