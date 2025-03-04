@props([
  'title' => 'Code',
])

<div class="border rounded-lg border-gray-200 dark:border-gray-700">
  <div class="border-b border-gray-200 bg-gray-50 rounded-t-lg dark:border-gray-700 p-2 text-xs font-light">{{ $title }}</div>
  <div class="bg-gray-100 dark:bg-gray-800 rounded-b-lg p-2">
    <code class="text-sm">
      {{ $slot }}
  </code>
</div>
</div>
