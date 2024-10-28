<?php
/**
 * @var User $user
 */
?>

<div class="mx-auto mb-10 max-w-xl px-2 py-2 sm:px-0 sm:py-4">
  <!-- title + cta -->
  <div class="mb-3 mt-4 items-center justify-between sm:mt-0 sm:flex">
    <h3 class="mb-4 flex font-semibold sm:mb-0">
      {{ __('Setup Two Factor authentication (2FA)') }}
    </h3>
  </div>

  <div class="rounded-lg border border-gray-200">
    <!-- 2fa -->
    @fragment('2fa-show-state')
      <div id="define-two-factor" class="flex items-center p-3">
        {{-- <x-heroicon-o-device-phone-mobile class="mr-3 h-5 w-5 flex-shrink-0 text-gray-400" /> --}}

        <div>
          <div class="flex items-center">
            <h2 class="mr-2 font-bold">{{ __('Authenticator app') }}</h2>

            @if ($user->two_factor_confirmed_at)
              <span class="me-2 rounded bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800 dark:bg-green-900 dark:text-green-300">{{ __('Configured') }}</span>
            @endif
          </div>
          <p>{{ __('Use an authentication app or browser extension to get two-factor authentication codes when prompted.') }}</p>
        </div>

        @if ($user->two_factor_confirmed_at)
          <x-button.secondary hx-target="#define-two-factor" hx-swap="outerHTML" hx-delete="{{ route('settings.profile.2fa.destroy') }}" hx-confirm="{{ __('Are you sure you want to proceed? This can not be undone.') }}">
            {{ __('Disable') }}
          </x-button.secondary>
        @else
          <x-button.secondary hx-target="#define-two-factor" hx-swap="outerHTML" hx-get="{{ route('settings.profile.2fa.new') }}">
            {{ __('Configure') }}
          </x-button.secondary>
        @endif
      </div>

      <!-- recovery codes -->
      @if ($user->two_factor_confirmed_at)
        <div id="recovery-code-show-state" class="flex items-center border-t p-3">
          {{-- <x-heroicon-o-document-text class="mr-3 h-5 w-5 flex-shrink-0 text-gray-400" /> --}}

          <div>
            <div class="flex items-center">
              <h2 class="mr-2 font-bold">{{ __('Recovery codes') }}</h2>
            </div>
            <p>{{ __('Recovery codes can be used to access your account in the event you lose access to your device and cannot receive two-factor authentication codes.') }}</p>
          </div>

          <x-button.secondary hx-target="#recovery-code-show-state" hx-swap="innerHTML" hx-get="{{ route('settings.profile.recovery-code.show') }}">
            {{ __('View') }}
          </x-button.secondary>
        </div>
      @endif
    @endfragment
  </div>
</div>
