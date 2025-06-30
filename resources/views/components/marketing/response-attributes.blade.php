<div x-cloak x-data="{ open: false }">
  <div @click="open = !open" x-bind:class="open ? 'border-b border-gray-200' : ''" class="flex cursor-pointer items-center justify-between pb-2">
    <p class="font-semibold">Response attributes</p>
    <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
  </div>

  <div x-show="open" x-transition>
    {{ $slot }}
  </div>
</div>
