@forelse ($notes as $note)
  <div class="mb-4 border-b border-gray-200 pb-4">
    <!-- date -->
    <div class="mb-2 flex text-sm">
      <p class="mr-2 font-bold">Feb 23, 2024 (Saturday)</p>
      <p class="text-gray-400">{{ __('Note by :user', ['user' => $note['user']['name']]) }}</p>
    </div>

    <div>
      <p>{{ $note['body'] }}</p>
    </div>
  </div>
@empty
  <p>No notes</p>
@endforelse
