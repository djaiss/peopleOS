<div class="relative mb-8 space-y-1 rounded-lg border border-gray-200 bg-white px-3 py-3 shadow-md">
  @if ($contact['first_name'])
    <div class="flex items-end">
      <span class="font-mono text-xs uppercase tracking-tighter text-gray-600">{{ __('first name') }}</span>
      <div class="mx-1 mb-1 flex-grow border-b border-dotted border-gray-600"></div>
      <span>{{ $contact['first_name'] }}</span>
    </div>
  @endif

  @if ($contact['middle_name'])
    <div class="flex items-end">
      <span class="font-mono text-xs uppercase tracking-tighter text-gray-600">{{ __('middle name') }}</span>
      <div class="mx-1 mb-1 flex-grow border-b border-dotted border-gray-600"></div>
      <span>{{ $contact['middle_name'] }}</span>
    </div>
  @endif

  @if ($contact['last_name'])
    <div class="flex items-end">
      <span class="font-mono text-xs uppercase tracking-tighter text-gray-600">{{ __('last name') }}</span>
      <div class="mx-1 mb-1 flex-grow border-b border-dotted border-gray-600"></div>
      <span>{{ $contact['last_name'] }}</span>
    </div>
  @endif

  @if ($contact['nickname'])
    <div class="flex items-end">
      <span class="font-mono text-xs uppercase tracking-tighter text-gray-600">{{ __('nickname') }}</span>
      <div class="mx-1 mb-1 flex-grow border-b border-dotted border-gray-600"></div>
      <span>{{ $contact['nickname'] }}</span>
    </div>
  @endif

  @if ($contact['maiden_name'])
    <div class="flex items-end">
      <span class="font-mono text-xs uppercase tracking-tighter text-gray-600">{{ __('maiden name') }}</span>
      <div class="mx-1 mb-1 flex-grow border-b border-dotted border-gray-600"></div>
      <span>{{ $contact['maiden_name'] }}</span>
    </div>
  @endif

  @if ($contact['patronymic_name'])
    <div class="flex items-end">
      <span class="font-mono text-xs uppercase tracking-tighter text-gray-600">{{ __('patronymic name') }}</span>
      <div class="mx-1 mb-1 flex-grow border-b border-dotted border-gray-600"></div>
      <span>{{ $contact['patronymic_name'] }}</span>
    </div>
  @endif

  @if ($contact['tribal_name'])
    <div class="flex items-end">
      <span class="font-mono text-xs uppercase tracking-tighter text-gray-600">{{ __('tribal name') }}</span>
      <div class="mx-1 mb-1 flex-grow border-b border-dotted border-gray-600"></div>
      <span>{{ $contact['tribal_name'] }}</span>
    </div>
  @endif

  @if ($contact['generation_name'])
    <div class="flex items-end">
      <span class="font-mono text-xs uppercase tracking-tighter text-gray-600">{{ __('generation name') }}</span>
      <div class="mx-1 mb-1 flex-grow border-b border-dotted border-gray-600"></div>
      <span>{{ $contact['generation_name'] }}</span>
    </div>
  @endif

  @if ($contact['romanized_name'])
    <div class="flex items-end">
      <span class="font-mono text-xs uppercase tracking-tighter text-gray-600">{{ __('romanized name') }}</span>
      <div class="mx-1 mb-1 flex-grow border-b border-dotted border-gray-600"></div>
      <span>{{ $contact['romanized_name'] }}</span>
    </div>
  @endif

  @if ($contact['nationality'])
    <div class="flex items-end">
      <span class="font-mono text-xs uppercase tracking-tighter text-gray-600">{{ __('nationality') }}</span>
      <div class="mx-1 mb-1 flex-grow border-b border-dotted border-gray-600"></div>
      <span>{{ $contact['nationality'] }}</span>
    </div>
  @endif
</div>
