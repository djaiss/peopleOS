<div class="mb-6 flex items-center gap-4">
  <div class="h-16 w-16 shrink-0">
    <img class="h-16 w-16 rounded-full object-cover p-[0.1875rem] ring-1 shadow-sm ring-slate-900/10" src="https://i.pravatar.cc/64" alt="" />
  </div>
  <div class="min-w-0">
    <h1 class="truncate text-xl font-semibold">{{ $person->name }}</h1>
    <div class="mt-1 flex flex-col gap-0">
      @if ($title)
        <span class="text-sm text-gray-600">{{ $title }}</span>
      @endif

      <span class="text-sm text-gray-600">32 years old</span>
    </div>
  </div>
</div>
