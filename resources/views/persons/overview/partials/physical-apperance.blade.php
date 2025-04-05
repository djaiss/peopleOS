<section id="physical-appearance" class="mb-8">
  <div class="mb-4 flex items-center justify-between">
    <div class="flex items-center gap-2">
      <x-lucide-smile class="h-5 w-5 text-green-500" />
      <h2 class="text-lg font-semibold text-gray-900">{{ __('Physical appearance') }}</h2>
    </div>

    <div class="flex items-center gap-2">
      <a x-target="physical-appearance-details" href="{{ route('person.physical-appearance.edit', $person->slug) }}" class="inline-flex items-center gap-1 rounded-md bg-green-50 px-2 py-1 text-sm font-medium text-green-600 hover:bg-green-100">
        <x-lucide-pencil class="mr-1 h-3 w-3" />
        {{ __('Edit') }}
      </a>
    </div>
  </div>

  @if ($person->hasPhysicalDetails())
    <div id="physical-appearance-details" class="rounded-lg border-gray-200">
      <div class="grid grid-cols-3 gap-0">
        @if ($person->height)
          <div class="nth-last:border-b-0 flex flex-col border-r border-b border-gray-200 bg-white px-4 py-2">
            <span class="text-xs text-gray-500">{{ __('Height') }}</span>
            <span class="font-medium">{{ $person->height }}</span>
          </div>
        @endif

        @if ($person->weight)
          <div class="nth-last:border-b-0 flex flex-col border-r border-b border-gray-200 bg-white px-4 py-2">
            <span class="text-xs text-gray-500">{{ __('Weight') }}</span>
            <span class="font-medium">{{ $person->weight }}</span>
          </div>
        @endif

        @if ($person->build)
          <div class="nth-last:border-b-0 flex flex-col border-r border-b border-gray-200 bg-white px-4 py-2">
            <span class="text-xs text-gray-500">{{ __('Build') }}</span>
            <span class="font-medium">{{ $person->build }}</span>
          </div>
        @endif

        @if ($person->skin_tone)
          <div class="nth-last:border-b-0 flex flex-col border-r border-b border-gray-200 bg-white px-4 py-2">
            <span class="text-xs text-gray-500">{{ __('Skin Tone') }}</span>
            <span class="font-medium">{{ $person->skin_tone }}</span>
          </div>
        @endif

        @if ($person->face_shape)
          <div class="nth-last:border-b-0 flex flex-col border-r border-b border-gray-200 bg-white px-4 py-2">
            <span class="text-xs text-gray-500">{{ __('Face Shape') }}</span>
            <span class="font-medium">{{ $person->face_shape }}</span>
          </div>
        @endif

        @if ($person->eye_shape)
          <div class="nth-last:border-b-0 flex flex-col border-r border-b border-gray-200 bg-white px-4 py-2">
            <span class="text-xs text-gray-500">{{ __('Eye Shape') }}</span>
            <span class="font-medium">{{ $person->eye_shape }}</span>
          </div>
        @endif

        @if ($person->eye_color)
          <div class="nth-last:border-b-0 flex flex-col border-r border-b border-gray-200 bg-white px-4 py-2">
            <span class="text-xs text-gray-500">{{ __('Eye Color') }}</span>
            <span class="font-medium">{{ $person->eye_color }}</span>
          </div>
        @endif

        @if ($person->hair_color)
          <div class="nth-last:border-b-0 flex flex-col border-r border-b border-gray-200 bg-white px-4 py-2">
            <span class="text-xs text-gray-500">{{ __('Hair Color') }}</span>
            <span class="font-medium">{{ $person->hair_color }}</span>
          </div>
        @endif

        @if ($person->hair_type)
          <div class="nth-last:border-b-0 flex flex-col border-r border-b border-gray-200 bg-white px-4 py-2">
            <span class="text-xs text-gray-500">{{ __('Hair Type') }}</span>
            <span class="font-medium">{{ $person->hair_type }}</span>
          </div>
        @endif

        @if ($person->hair_length)
          <div class="nth-last:border-b-0 flex flex-col border-r border-b border-gray-200 bg-white px-4 py-2">
            <span class="text-xs text-gray-500">{{ __('Hair Length') }}</span>
            <span class="font-medium">{{ $person->hair_length }}</span>
          </div>
        @endif

        @if ($person->facial_hair)
          <div class="nth-last:border-b-0 flex flex-col border-r border-b border-gray-200 bg-white px-4 py-2">
            <span class="text-xs text-gray-500">{{ __('Facial Hair') }}</span>
            <span class="font-medium">{{ $person->facial_hair }}</span>
          </div>
        @endif

        @if ($person->scars)
          <div class="nth-last:border-b-0 flex flex-col border-r border-b border-gray-200 bg-white px-4 py-2">
            <span class="text-xs text-gray-500">{{ __('Scars') }}</span>
            <span class="font-medium">{{ $person->scars }}</span>
          </div>
        @endif

        @if ($person->tatoos)
          <div class="nth-last:border-b-0 flex flex-col border-r border-b border-gray-200 bg-white px-4 py-2">
            <span class="text-xs text-gray-500">{{ __('Tatoos') }}</span>
            <span class="font-medium">{{ $person->tatoos }}</span>
          </div>
        @endif

        @if ($person->piercings)
          <div class="nth-last:border-b-0 flex flex-col border-r border-b border-gray-200 bg-white px-4 py-2">
            <span class="text-xs text-gray-500">{{ __('Piercings') }}</span>
            <span class="font-medium">{{ $person->piercings }}</span>
          </div>
        @endif

        @if ($person->distinctive_marks)
          <div class="nth-last:border-b-0 flex flex-col border-r border-b border-gray-200 bg-white px-4 py-2">
            <span class="text-xs text-gray-500">{{ __('Distinctive Marks') }}</span>
            <span class="font-medium">{{ $person->distinctive_marks }}</span>
          </div>
        @endif

        @if ($person->glasses)
          <div class="nth-last:border-b-0 flex flex-col border-r border-b border-gray-200 bg-white px-4 py-2">
            <span class="text-xs text-gray-500">{{ __('Glasses') }}</span>
            <span class="font-medium">{{ $person->glasses }}</span>
          </div>
        @endif

        @if ($person->dress_style)
          <div class="nth-last:border-b-0 flex flex-col border-r border-b border-gray-200 bg-white px-4 py-2">
            <span class="text-xs text-gray-500">{{ __('Dress Style') }}</span>
            <span class="font-medium">{{ $person->dress_style }}</span>
          </div>
        @endif

        @if ($person->voice)
          <div class="nth-last:border-b-0 flex flex-col border-r border-b border-gray-200 bg-white px-4 py-2">
            <span class="text-xs text-gray-500">{{ __('Voice') }}</span>
            <span class="font-medium">{{ $person->voice }}</span>
          </div>
        @endif
      </div>
    </div>
  @else
    <!-- blank state -->
    <div id="physical-appearance-details" class="flex items-center justify-center gap-x-3 rounded-lg border border-gray-200 bg-white p-4 text-center">
      <div class="flex h-9 w-9 items-center justify-center rounded-full bg-green-100">
        <x-lucide-smile class="h-6 w-6 text-green-600" />
      </div>
      <p class="text-sm text-gray-500">
        {{ __('Record details of the physical appearance of this person.') }}
      </p>
    </div>
  @endif
</section>
