<div x-data="{ search: '' }">
  <div class="mb-8 border border-gray-200 bg-white sm:rounded-lg">
    <!-- search -->
    <div class="flex items-center justify-between border-b border-gray-200 p-3 text-sm first:rounded-t-lg last:rounded-b-lg last:border-b-0 hover:bg-blue-50">
      <div class="relative ml-auto items-center text-sm sm:flex">
        <x-lucide-search class="pointer-events-none absolute top-1/2 left-2 h-4 w-4 -translate-y-1/2 text-gray-500" />
        <x-text-input type="text" placeholder="{{ __('Search') }}" class="w-30 border border-gray-300 bg-gray-100 py-1 pr-3 pl-8 text-sm focus:bg-white" x-model="search" />
      </div>
    </div>

    <!-- users -->
    @foreach ($users as $user)
      <div class="flex items-center justify-between border-b border-gray-200 p-3 text-sm first:rounded-t-lg last:rounded-b-lg last:border-b-0 hover:bg-blue-50" x-show="
        search === '' ||
          '{{ strtolower($user['name']) }}'.includes(search.toLowerCase()) ||
          '{{ strtolower($user['email']) }}'.includes(search.toLowerCase())
      ">
        <div class="flex items-center gap-3">
          <img src="{{ $user['profile_photo_url'] }}" alt="{{ $user['name'] }}" class="h-8 w-8 shrink-0 rounded-full object-cover p-[0.1875rem] shadow-sm ring-1 ring-slate-900/10" />
          <div>
            <p class="flex items-center gap-1 font-bold">
              {{ $user['name'] }}
            </p>
            <p class="text-gray-600">{{ $user['email'] }}</p>
          </div>
        </div>

        <div class="flex items-center gap-6">
          @if ($user['status'] === 'active')
            <div class="flex flex-col gap-1">
              <p class="text-center font-mono text-xs text-gray-600">{{ __('Last activity') }}</p>
              <p class="font-mono text-xs">{{ $user['last_activity_at'] }}</p>
            </div>

            <div class="flex w-fit items-center space-x-1 rounded-md border border-zinc-950/10 py-0.5 pr-1.5 pl-1 text-xs text-zinc-700 dark:border-white/10 dark:text-white/70">
              <x-lucide-circle-check class="size-3.5 min-w-3 fill-green-600 text-white dark:text-zinc-400" />
              <span>{{ $user['status'] }}</span>
            </div>
          @endif

          @if ($user['status'] === 'invited')
            <div class="flex w-fit items-center space-x-1 rounded-md border border-zinc-950/10 py-0.5 pr-1.5 pl-1 text-xs text-zinc-700 dark:border-white/10 dark:text-white/70">
              <x-lucide-send-horizontal class="size-3 min-w-3 text-yellow-500 dark:text-zinc-400" />
              <span>{{ $user['status'] }}</span>
            </div>
          @endif
        </div>
      </div>
    @endforeach
  </div>
</div>
