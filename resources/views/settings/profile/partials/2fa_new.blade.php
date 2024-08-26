<?php
/**
 * @var string $qrcode_image
 */
?>

<form id="define-two-factor" hx-target="#define-two-factor" hx-swap="innerHTML" hx-post="{{ route('settings.profile.2fa.store') }}" class="bg-gray-50 dark:bg-gray-900">
  @csrf
  @method('POST')

  <p class="px-4 pt-4">{{ __('Authenticator apps and browser extensions like 1Password, Authy, Microsoft Authenticator, etc. generate one-time passwords that are used as a second factor to verify your identity when prompted during sign-in.') }}</p>

  <p class="mb-2 px-4 pt-4">{{ __('1. Use an authenticator app or browser extension to scan the QR code below.') }}</p>

  <div class="flex justify-center">
    <div class="rounded-lg border border-gray-300 bg-white p-3">
      {!! $qrcode_image !!}
    </div>
  </div>

  <div class="px-4 pt-4">
    <p class="">{{ __('2. Verify the code from the app.') }}</p>
    <div class="flex justify-center">
      <div>
        <input id="code_verification" name="code_verification" type="text" value="" maxlength="6" class="mt-1 block w-40 rounded-md border-gray-300 p-3 text-center font-mono text-xl tracking-widest shadow-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:text-gray-400 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600" />

        <div id="error-container"></div>
      </div>
    </div>
  </div>

  <div class="flex justify-between p-5">
    <x-button.secondary hx-target="#define-two-factor" hx-swap="outerHTML" hx-get="{{ route('settings.profile.2fa.show') }}">
      {{ __('Cancel') }}
    </x-button.secondary>

    <x-button.primary type="submit">
      {{ __('Save') }}
    </x-button.primary>
  </div>
</form>

<script>
  document.body.addEventListener('htmx:responseError', function (event) {
    var errorContainer = document.getElementById('error-container');
    var response = event.detail.xhr.response;
    var message = JSON.parse(response).message;
    errorContainer.innerHTML = '<div class="mt-3 alert alert-danger block w-full border p-2 border-red-400 bg-red-50 rounded-lg">' + message + '</div>';
  });
</script>
