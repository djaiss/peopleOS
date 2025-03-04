@props([
  'name',
  'type',
  'description',
  'required' => false,
])

<div class="border-b border-gray-200 py-2 last:border-b-0 hover:bg-slate-100">
  <div class="mb-1 flex items-center gap-x-2">
    <span class="font-mono font-bold">{{ $name }}</span>
    <span class="text-xs text-gray-500">{{ $type }}</span>
    @if ($required)
      <span class="text-rose-800">required</span>
    @endif
  </div>

  <p>{{ $description }}</p>
</div>
