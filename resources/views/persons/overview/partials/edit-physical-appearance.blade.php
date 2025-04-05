<?php
/*
 * @var Person $person
 * @var Encounter $encounter
 */
?>

<div id="physical-appearance-details" class="rounded-lg border border-gray-200 bg-white">
  <form x-target="physical-appearance-details" x-target.back="physical-appearance-details" action="{{ route('person.physical-appearance.update', [$person->slug]) }}" method="POST">
    @method('PUT')
    @csrf

    <div class="flex gap-2 rounded-t-lg border-b border-gray-200 bg-gray-100 px-4 pt-2 pb-2">
      <p class="text-sm font-semibold">{{ __('General characteristics') }}</p>
    </div>

    <!-- height -->
    <div class="grid grid-cols-3 items-center border-b p-3 hover:bg-blue-50">
      <x-input-label for="height" :value="__('Height')" class="col-span-1" />
      <div class="col-span-2 w-full justify-self-end">
        <x-text-input id="height" name="height" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-xs focus:border-indigo-500 focus:ring-indigo-500 disabled:text-gray-400 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600" autofocus :value="$person->height" />
        <x-input-error class="mt-2" :messages="$errors->get('height')" />
      </div>
    </div>

    <!-- weight -->
    <div class="grid grid-cols-3 items-center border-b p-3 hover:bg-blue-50">
      <x-input-label for="weight" :value="__('Weight')" class="col-span-1" />
      <div class="col-span-2 w-full justify-self-end">
        <x-text-input id="weight" name="weight" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-xs focus:border-indigo-500 focus:ring-indigo-500 disabled:text-gray-400 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600" :value="$person->weight" />
        <x-input-error class="mt-2" :messages="$errors->get('weight')" />
      </div>
    </div>

    <!-- build -->
    <div class="grid grid-cols-3 items-center border-b p-3 hover:bg-blue-50">
      <x-input-label for="build" :value="__('Build')" class="col-span-1" />
      <div class="col-span-2 w-full justify-self-end">
        <x-text-input placeholder="{{ __('e.g. athletic, curvy, etc.') }}" id="build" name="build" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-xs focus:border-indigo-500 focus:ring-indigo-500 disabled:text-gray-400 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600" :value="$person->build" />
        <x-input-error class="mt-2" :messages="$errors->get('build')" />
      </div>
    </div>

    <!-- skin tone -->
    <div class="grid grid-cols-3 items-center border-b p-3 hover:bg-blue-50">
      <x-input-label for="skin_tone" :value="__('Skin tone')" class="col-span-1" />
      <div class="col-span-2 w-full justify-self-end">
        <x-text-input placeholder="{{ __('e.g. e.g., fair, medium, deep, etc.') }}" id="skin_tone" name="skin_tone" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-xs focus:border-indigo-500 focus:ring-indigo-500 disabled:text-gray-400 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600" :value="$person->skin_tone" />
        <x-input-error class="mt-2" :messages="$errors->get('skin_tone')" />
      </div>
    </div>

    <div class="flex gap-2 border-b border-gray-200 bg-gray-100 px-4 pt-2 pb-2">
      <p class="text-sm font-semibold">{{ __('Facial features') }}</p>
    </div>

    <!-- face shape -->
    <div class="grid grid-cols-3 items-center border-b p-3 hover:bg-blue-50">
      <x-input-label for="face_shape" :value="__('Face shape')" class="col-span-1" />
      <div class="col-span-2 w-full justify-self-end">
        <x-text-input placeholder="{{ __('e.g. oval, square, round, etc.') }}" id="face_shape" name="face_shape" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-xs focus:border-indigo-500 focus:ring-indigo-500 disabled:text-gray-400 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600" :value="$person->face_shape" />
        <x-input-error class="mt-2" :messages="$errors->get('face_shape')" />
      </div>
    </div>

    <!-- eye color -->
    <div class="grid grid-cols-3 items-center border-b p-3 hover:bg-blue-50">
      <x-input-label for="eye_color" :value="__('Eye color')" class="col-span-1" />
      <div class="col-span-2 w-full justify-self-end">
        <x-text-input placeholder="{{ __('e.g. blue, green, brown, etc.') }}" id="eye_color" name="eye_color" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-xs focus:border-indigo-500 focus:ring-indigo-500 disabled:text-gray-400 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600" :value="$person->eye_color" />
        <x-input-error class="mt-2" :messages="$errors->get('eye_color')" />
      </div>
    </div>

    <!-- eye shape -->
    <div class="grid grid-cols-3 items-center border-b p-3 hover:bg-blue-50">
      <x-input-label for="eye_shape" :value="__('Eye shape')" class="col-span-1" />
      <div class="col-span-2 w-full justify-self-end">
        <x-text-input placeholder="{{ __('e.g. almond, round, etc.') }}" id="eye_shape" name="eye_shape" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-xs focus:border-indigo-500 focus:ring-indigo-500 disabled:text-gray-400 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600" :value="$person->eye_shape" />
        <x-input-error class="mt-2" :messages="$errors->get('eye_shape')" />
      </div>
    </div>

    <!-- hair color -->
    <div class="grid grid-cols-3 items-center border-b p-3 hover:bg-blue-50">
      <x-input-label for="hair_color" :value="__('Hair color')" class="col-span-1" />
      <div class="col-span-2 w-full justify-self-end">
        <x-text-input placeholder="{{ __('e.g. blonde, brown, black, etc.') }}" id="hair_color" name="hair_color" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-xs focus:border-indigo-500 focus:ring-indigo-500 disabled:text-gray-400 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600" :value="$person->hair_color" />
        <x-input-error class="mt-2" :messages="$errors->get('hair_color')" />
      </div>
    </div>

    <!-- hair type -->
    <div class="grid grid-cols-3 items-center border-b p-3 hover:bg-blue-50">
      <x-input-label for="hair_type" :value="__('Hair type')" class="col-span-1" />
      <div class="col-span-2 w-full justify-self-end">
        <x-text-input placeholder="{{ __('e.g. straight, wavy, curly, etc.') }}" id="hair_type" name="hair_type" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-xs focus:border-indigo-500 focus:ring-indigo-500 disabled:text-gray-400 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600" :value="$person->hair_type" />
        <x-input-error class="mt-2" :messages="$errors->get('hair_type')" />
      </div>
    </div>

    <!-- hair length -->
    <div class="grid grid-cols-3 items-center border-b p-3 hover:bg-blue-50">
      <x-input-label for="hair_length" :value="__('Hair length')" class="col-span-1" />
      <div class="col-span-2 w-full justify-self-end">
        <x-text-input placeholder="{{ __('e.g. long, short, shoulder-length, etc.') }}" id="hair_length" name="hair_length" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-xs focus:border-indigo-500 focus:ring-indigo-500 disabled:text-gray-400 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600" :value="$person->hair_length" />
        <x-input-error class="mt-2" :messages="$errors->get('hair_length')" />
      </div>
    </div>

    <!-- facial hair -->
    <div class="grid grid-cols-3 items-center border-b p-3 hover:bg-blue-50">
      <x-input-label for="facial_hair" :value="__('Facial hair')" class="col-span-1" />
      <div class="col-span-2 w-full justify-self-end">
        <x-text-input placeholder="{{ __('e.g. beard, moustache, etc.') }}" id="facial_hair" name="facial_hair" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-xs focus:border-indigo-500 focus:ring-indigo-500 disabled:text-gray-400 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600" :value="$person->facial_hair" />
        <x-input-error class="mt-2" :messages="$errors->get('facial_hair')" />
      </div>
    </div>

    <div class="flex gap-2 border-b border-gray-200 bg-gray-100 px-4 pt-2 pb-2">
      <p class="text-sm font-semibold">{{ __('Distinguishing features') }}</p>
    </div>

    <!-- scars -->
    <div class="grid grid-cols-3 items-center border-b p-3 hover:bg-blue-50">
      <x-input-label for="scars" :value="__('Scars')" class="col-span-1" />
      <div class="col-span-2 w-full justify-self-end">
        <x-text-input placeholder="{{ __('e.g. burn, scar, etc.') }}" id="scars" name="scars" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-xs focus:border-indigo-500 focus:ring-indigo-500 disabled:text-gray-400 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600" :value="$person->scars" />
        <x-input-error class="mt-2" :messages="$errors->get('scars')" />
      </div>
    </div>

    <!-- tatoos -->
    <div class="grid grid-cols-3 items-center border-b p-3 hover:bg-blue-50">
      <x-input-label for="tatoos" :value="__('tatoos')" class="col-span-1" />
      <div class="col-span-2 w-full justify-self-end">
        <x-text-input placeholder="{{ __('e.g. an eagle on the back, a rose on the wrist, etc.') }}" id="tatoos" name="tatoos" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-xs focus:border-indigo-500 focus:ring-indigo-500 disabled:text-gray-400 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600" :value="$person->tatoos" />
        <x-input-error class="mt-2" :messages="$errors->get('tatoos')" />
      </div>
    </div>

    <!-- distinctive marks -->
    <div class="grid grid-cols-3 items-center border-b p-3 hover:bg-blue-50">
      <x-input-label for="distinctive_marks" :value="__('Distinctive marks')" class="col-span-1" />
      <div class="col-span-2 w-full justify-self-end">
        <x-text-input placeholder="{{ __('e.g. a mole, a birthmark, etc.') }}" id="distinctive_marks" name="distinctive_marks" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-xs focus:border-indigo-500 focus:ring-indigo-500 disabled:text-gray-400 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600" :value="$person->distinctive_marks" />
        <x-input-error class="mt-2" :messages="$errors->get('distinctive_marks')" />
      </div>
    </div>

    <div class="flex gap-2 border-b border-gray-200 bg-gray-100 px-4 pt-2 pb-2">
      <p class="text-sm font-semibold">{{ __('Other details') }}</p>
    </div>

    <!-- glasses -->
    <div class="grid grid-cols-3 items-center border-b p-3 hover:bg-blue-50">
      <x-input-label for="glasses" :value="__('Glasses')" class="col-span-1" />
      <div class="col-span-2 w-full justify-self-end">
        <x-text-input placeholder="{{ __('e.g. glasses, sunglasses, etc.') }}" id="glasses" name="glasses" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-xs focus:border-indigo-500 focus:ring-indigo-500 disabled:text-gray-400 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600" :value="$person->glasses" />
        <x-input-error class="mt-2" :messages="$errors->get('glasses')" />
      </div>
    </div>

    <!-- dress style -->
    <div class="grid grid-cols-3 items-center border-b p-3 hover:bg-blue-50">
      <x-input-label for="dress_style" :value="__('Dress style')" class="col-span-1" />
      <div class="col-span-2 w-full justify-self-end">
        <x-text-input placeholder="{{ __('e.g. casual, formal, etc.') }}" id="dress_style" name="dress_style" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-xs focus:border-indigo-500 focus:ring-indigo-500 disabled:text-gray-400 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600" :value="$person->dress_style" />
        <x-input-error class="mt-2" :messages="$errors->get('dress_style')" />
      </div>
    </div>

    <!-- voice -->
    <div class="grid grid-cols-3 items-center border-b p-3 hover:bg-blue-50">
      <x-input-label for="voice" :value="__('Voice')" class="col-span-1" />
      <div class="col-span-2 w-full justify-self-end">
        <x-text-input placeholder="{{ __('e.g. deep, soft, etc.') }}" id="voice" name="voice" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-xs focus:border-indigo-500 focus:ring-indigo-500 disabled:text-gray-400 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600" :value="$person->voice" />
        <x-input-error class="mt-2" :messages="$errors->get('voice')" />
      </div>
    </div>

    <div class="flex justify-between border-t border-gray-200 p-3">
      <x-button.secondary x-target="physical-appearance-details" href="{{ route('person.show', $person->slug) }}">
        {{ __('Cancel') }}
      </x-button.secondary>

      <x-button.primary>
        {{ __('Save') }}
      </x-button.primary>
    </div>
  </form>
</div>
