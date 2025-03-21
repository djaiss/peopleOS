<x-app-layout>
  <div class="grid h-[calc(100vh-48px)] grid-cols-1 lg:grid-cols-[240px_1fr]">
    <!-- sidebar -->
    @include('administration.partials.sidebar')

    <!-- main content -->
    <div class="relative bg-gray-50 px-6 pt-8 lg:px-12">
      <div class="mx-auto max-w-2xl px-2 py-2 sm:px-0">
        <h1 class="font-semi-bold mb-4 text-2xl">
          {{ __('Account administration') }}
        </h1>

        <h2 class="font-semi-bold mb-1 text-lg">{{ __('Prune your account') }}</h2>
        <p class="mb-4 text-sm text-zinc-500">{{ __('Delete all persons and related data from your account. This lets you start over with a new account.') }}</p>

        <div class="mb-8 border border-gray-200 bg-white sm:rounded-lg">
          <div class="flex items-center justify-between rounded-t-lg border-b border-gray-200 p-3 last:rounded-b-lg last:border-b-0 hover:bg-blue-50">
            <p class="text-sm text-zinc-500">{{ __('Beware, this action is irreversible.') }}</p>

            <form onsubmit="return confirm('Are you absolutely sure? This action cannot be undone.')" action="{{ route('administration.account.prune') }}" method="post">
              @csrf
              @method('put')

              <x-button.secondary type="submit" class="mr-2 text-sm">
                {{ __('Prune account') }}
              </x-button.secondary>
            </form>
          </div>
        </div>

        <div class="mb-2 flex items-center gap-x-2">
          <x-lucide-alert-triangle class="h-4 w-4 text-red-600" />
          <h2 class="font-semi-bold mb-1 text-lg text-red-600">
            {{ __('Delete your account') }}
          </h2>
        </div>

        <!-- Danger Zone -->
        <div class="rounded-md border border-red-200 bg-red-50">
          <div class="p-4">
            <p class="mb-4 text-sm text-red-600">
              {{ __('Your account and all data will be deleted immediately and cannot be restored. This is irreversible. Please be certain.') }}
            </p>

            <form action="{{ route('administration.account.destroy') }}" method="post" x-data="{
              feedback: '',
              isValid: false,
              async handleSubmit() {
                if (! this.isValid) return

                if (
                  await confirm(
                    '{{ __('Are you absolutely sure? This action cannot be undone.') }}',
                  )
                ) {
                  $el.submit()
                }
              },
            }" @submit.prevent="handleSubmit">
              @csrf
              @method('delete')

              <label for="feedback" class="block text-sm font-medium text-red-700">
                {{ __('Please tell us why you are leaving (required)') }}
              </label>

              <div class="mt-1">
                <textarea id="feedback" name="feedback" rows="3" x-model="feedback" @input="isValid = feedback.length >= 3" class="block w-full rounded-md border-red-300 bg-white text-red-900 shadow-xs focus:border-red-500 focus:ring-red-500 sm:text-sm" placeholder="{{ __('Your feedback helps us improve our service...') }}"></textarea>
              </div>

              <div class="mt-4 flex items-center justify-end gap-x-3">
                <button type="submit" x-bind:disabled="!isValid" x-bind:class="! isValid ? 'opacity-50 cursor-not-allowed' : ''" class="inline-flex items-center gap-x-2 rounded-md bg-red-600 px-3.5 py-2 text-sm font-semibold text-white shadow-xs hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">
                  <x-lucide-trash-2 class="h-4 w-4" />
                  {{ __('Delete my account') }}
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
