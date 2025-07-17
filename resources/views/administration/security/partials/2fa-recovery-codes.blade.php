<?php
/*
 * @var string $recoveryCodes
 */
?>

<div id="recovery-codes" class="border-b border-gray-200 p-4">
    <div class="flex items-center mb-4">
      <x-lucide-container class="h-5 w-5 text-gray-500" />
      <div class="ms-5 flex w-full items-center justify-between">
        <div>
            <p class="font-semibold">
                {{ __('Recovery codes') }}
            </p>
            <p class="text-xs text-gray-600">{{ __('Use these codes to access your account if you lose access to your authenticator app.') }}</p>
        </div>
      </div>
    </div>

    <div class="grid grid-cols-3 gap-2 bg-gray-50 rounded-lg p-4">
      @foreach ($recoveryCodes as $code)
        <div class="text-sm font-mono">{{ $code }}</div>
      @endforeach
    </div>
</div>
