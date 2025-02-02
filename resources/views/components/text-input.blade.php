@props([
  'avoidAutofill' => true,
])

<input @if($avoidAutofill) data-1p-ignore @endif {!! $attributes->merge(['class' => 'py-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-xs disabled:text-gray-400']) !!} />
