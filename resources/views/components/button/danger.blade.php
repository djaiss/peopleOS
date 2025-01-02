<button {{ $attributes->merge(['type' => 'submit', 'class' => 'px-3 py-1 bg-red-600 border border-transparent rounded-md font-semibold text-white hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800']) }}>
  {{ $slot }}
</button>
