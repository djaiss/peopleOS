<div class="bg-light dark:bg-dark z-10 mb-10">
  <div class="mb-1 flex items-center justify-between">
    <p class="text-xs">Written by...</p>
  </div>
  <div class="pt-1">
    <a href="" class="border-light dark:border-dark text-primary dark:text-primary-dark hover:text-primary dark:hover:text-primary-dark relative flex justify-between rounded border hover:border-b-[4px] hover:transition-all active:top-[2px] active:border-b-1">
      <div class="flex w-full flex-col justify-between gap-0.5 px-4 py-2">
        <h3 class="mb-0 text-base leading-tight"><span>Régis Freyd</span></h3>
        <p class="text-primary/50 dark:text-primary-dark/50 m-0 line-clamp-1 text-sm leading-tight">Founder</p>
      </div>
      <div class="flex-shrink-0 px-4 py-2">
        <img src="{{ asset('marketing/regis.jpg') }}" alt="Regis" class="h-12 w-12 rounded-full" />
      </div>
    </a>
  </div>
</div>

<div class="mb-10 flex flex-col gap-y-2 text-sm">
  <div class="flex items-center gap-x-2">
    <x-lucide-trending-up class="h-4 w-4 text-gray-500" />
    <p class="text-gray-600">{{ $stats['word_count'] }} words</p>
  </div>
  <div class="flex items-center gap-x-2">
    <x-lucide-clock class="h-4 w-4 text-gray-500" />
    <p class="text-gray-600">{{ $stats['reading_time'] }} minutes</p>
  </div>
  <div>
    <p class="text-gray-600">
      This represents only
      <code class="rounded-md border border-gray-200 px-1">{{ $stats['comparison']['percentage'] }}%</code>
      of the number of pages in
      <span class="font-semibold">{{ $stats['comparison']['title'] }}</span>
      by
      <span class="font-semibold">{{ $stats['comparison']['author'] }}</span>
    </p>
  </div>
</div>

<div class="text-sm">
  <h3 class="mb-2 font-semibold">Random fact, so we don't die stupid</h3>

  <p class="text-gray-600">{{ $stats['random_fact'] }}</p>
</div>
