@props([
  'title' => 'Code',
  'verb' => '',
  'verbClass' => '',
])

<div class="rounded-lg border border-gray-200 dark:border-gray-700">
  <div class="rounded-t-lg border-b border-gray-200 bg-gray-50 p-2 text-xs font-light dark:border-gray-700">{!! $verb ? "<span class='font-normal {$verbClass}'>{$verb}</span> " : '' !!}{{ $title }}</div>
  <div class="rounded-b-lg bg-gray-100 p-2 dark:bg-gray-800">
    <code class="text-sm">
      {{ $slot }}
    </code>
  </div>
</div>
