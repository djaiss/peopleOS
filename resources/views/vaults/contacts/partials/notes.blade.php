@forelse ($notes as $note)
  <div class="mb-4 border-b border-gray-200 pb-4">
    <!-- date -->
    <div class="mb-2 flex text-xs">
      <p>
        <x-tooltip text="{{ $note['created_at_full_timestamp'] }}" class="mr-2 font-bold">{{ $note['created_at'] }}</x-tooltip>
      </p>
      <p class="text-gray-400">{{ __('Note by :user', ['user' => $note['user']['name']]) }}</p>
    </div>

    <div>
      {!! $note['body'] !!}
    </div>
  </div>
@empty
  <p>No notes</p>
@endforelse
