<div x-cloak x-data="{ open: false }" class="mb-8">
  <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="mb-2 flex cursor-pointer items-center justify-between pb-2">
    <p class="font-semibold">Query parameters</p>
    <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
  </div>

  <div x-show="open" x-transition class="mt-2">
    {{ $slot }}
  </div>
</div>
