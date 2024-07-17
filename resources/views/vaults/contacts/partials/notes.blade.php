@forelse ($notes as $note)
  <div class="group mb-4 border-b border-gray-200 pb-4">
    <!-- date -->
    <div class="mb-2 flex justify-between text-xs">
      <div class="flex">
        <p>
          <x-tooltip text="{{ $note['created_at_full_timestamp'] }}" class="mr-2 font-bold">{{ $note['created_at'] }}</x-tooltip>
        </p>
        <p class="text-gray-400">{{ __('Note by :user', ['user' => $note['user']['name']]) }}</p>
      </div>

      <x-link class="hidden cursor-pointer group-hover:inline">{{ __('Edit') }}</x-link>
    </div>

    <div dusk="note-body-{{ $note['id'] }}">
      {!! $note['body'] !!}
    </div>
  </div>
@empty
  <div class="bg-gray-50 p-3 text-center">
    <p>{{ __('There are no notes yet.') }}</p>
  </div>
@endforelse
