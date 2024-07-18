<?php
/**
 * @var \App\Models\Vault $vault
 * @var \Illuminate\Support\Collection<int, \App\Models\Note> $notes
 * @var array $contact
 */
?>

@forelse ($notes as $note)
  @include('vaults.contacts.partials.note', ['vault' => $vault, 'contact' => $contact, 'note' => $note])
@empty
  <div class="bg-gray-50 p-3 text-center">
    <p>{{ __('There are no notes yet.') }}</p>
  </div>
@endforelse
