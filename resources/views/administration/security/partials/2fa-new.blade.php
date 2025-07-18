<?php
/*
 * @var string $secret
 * @var string $qrCodeSvg
 */
?>

<form action="{{ route('administration.security.2fa.store') }}" id="authenticator-app" x-target="authenticator-app" method="post" class="border-b border-gray-200 p-4">
  @csrf
  @method('post')

  <div class="flex flex-col gap-y-4">
    <p>
      <span class="inline-flex h-6 w-6 items-center justify-center rounded-full border border-gray-400 text-sm">1</span>
      {{ __('Use any authenticator app to scan your QR code, or manually use the setup key.') }}
    </p>
    <div class="mx-auto w-full">
      <div class="mb-2 flex h-36 w-36 items-center justify-center rounded-lg border border-gray-200">{!! $qrCodeSvg !!}</div>
      <p class="mb-4 text-sm">
        {{ __('Setup key:') }}
        <code>{{ $secret }}</code>
      </p>
    </div>
  </div>
  <div class="flex flex-col gap-y-4">
    <p>
      <span class="inline-flex h-6 w-6 items-center justify-center rounded-full border border-gray-400 text-sm">2</span>
      {{ __('Enter the code generated by your authenticator app below.') }}
    </p>
    <div class="mb-4">
      <x-input-label for="token" :value="__('Enter 6-digit OTP token')" class="mb-2" />
      <x-text-input id="token" class="block w-full" type="text" name="token" :value="old('token')" required autofocus :avoidAutofill="false" autocomplete="off" pattern="[0-9]{6}" maxlength="6" inputmode="numeric" />
      <x-input-error :messages="$errors->get('token')" class="mt-2" />
    </div>
  </div>
  <div class="flex justify-between">
    <x-button.secondary href="{{ route('administration.security.index') }}" x-target="authenticator-app">
      {{ __('Cancel') }}
    </x-button.secondary>

    <x-button.primary class="mr-2">
      {{ __('Save') }}
    </x-button.primary>
  </div>
</form>
