<button {{ $attributes->merge(['type' => 'submit', 'class' => 'px-2 py-1 inline-flex items-center justify-center whitespace-nowrap rounded-md font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 border border-gray-300 bg-transparent shadow-sm hover:bg-accent hover:text-accent-foreground transition ease-in-out duration-150 hover:bg-gray-100 dark:bg-gray-700 dark:text-white dark:hover:text-gray-800']) }}>
  {{ $slot }}
</button>
