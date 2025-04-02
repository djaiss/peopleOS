<x-marketing-layout>
  <!-- breadcrumb -->
  <div class="border-b border-gray-200 py-3 text-sm">
    <div class="mx-auto flex max-w-7xl items-center gap-x-2 px-6 lg:px-8 xl:px-0">
      <a href="{{ route('marketing.index') }}" class="text-blue-500 hover:underline">{{ __('Home') }}</a>
      <span class="text-gray-500">&gt;</span>
      <span class="text-gray-600">{{ __('Pricing') }}</span>
    </div>
  </div>

  <div class="relative mx-auto max-w-7xl px-6 py-16 lg:px-8 xl:px-0">
    <h1 class="mb-4 text-center text-2xl tracking-tight text-gray-900">
      Remember the old days? A world
      <span class="rounded-md bg-green-200 px-2 py-1">without subscriptions</span>
      ?
    </h1>

    <h2 class="mb-16 text-center text-lg text-gray-600">
      PeopleOS has a
      <span class="font-semibold">one-time fee</span>
      and then you will own it forever.
    </h2>

    <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
      <!-- Free Plan -->
      <div class="relative rounded-2xl border-2 border-yellow-400 bg-white p-8">
        <div class="absolute -top-4 right-8">
          <div class="inline-flex items-center rounded-full border border-yellow-400 bg-yellow-50 px-4 py-1 text-sm">
            <span class="font-medium text-yellow-800">Just pick this one!</span>
          </div>
          <div class="mt-1 text-sm text-gray-500">if you are unsure about privacy.</div>
        </div>

        <h3 class="text-xl font-semibold italic">Totally free</h3>
        <p class="mb-4 text-gray-600">No strings attached</p>

        <div class="mb-8">
          <p class="text-2xl font-bold">Free</p>
        </div>

        <ul class="mb-8 space-y-4">
          <li class="flex items-start gap-x-3">
            <svg class="h-6 w-5 flex-none text-green-600" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
            </svg>
            <div>
              <span class="font-semibold">You host it yourself</span>
              <p class="text-sm text-gray-500">There can not be any privacy issues</p>
            </div>
          </li>
          <li class="flex items-start gap-x-3">
            <svg class="h-6 w-5 flex-none text-green-600" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
            </svg>
            <div>
              <span class="font-semibold">Like, 100% free</span>
              <p class="text-sm text-gray-500">
                It's
                <a href="https://github.com/djaiss/peopleOS?tab=MIT-1-ov-file" class="text-blue-500 hover:underline">MIT licensed</a>
                .
              </p>
            </div>
          </li>
          <li class="flex items-start gap-x-3">
            <svg class="h-6 w-5 flex-none text-green-600" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
            </svg>
            <div>
              <span class="font-semibold">No support</span>
              <p class="text-sm text-gray-500">Apart from the docs and community</p>
            </div>
          </li>
        </ul>

        <div class="mt-8">
          <a href="#" class="group inline-flex w-full items-center gap-x-2 rounded-sm border border-b-3 border-gray-400 px-3 py-2 transition-colors duration-150 hover:bg-white">
            <img src="{{ asset('marketing/docker.svg') }}" class="mr-2 inline-block h-8 w-8" />
            Download the Docker image
          </a>
        </div>
      </div>

      <div class="rounded-2xl border border-gray-200 bg-white p-8">
        <h3 class="text-xl font-semibold italic">For individuals</h3>
        <p class="mb-4 text-gray-600">A one-time fee, not a monthly subscription</p>

        <div class="mb-8">
          <p class="flex items-baseline gap-x-1">
            <span class="text-2xl font-bold">$99</span>
            <span class="text-sm text-gray-500">one time fee</span>
          </p>
        </div>

        <ul class="mb-8 space-y-4">
          <li class="flex items-start gap-x-3">
            <svg class="h-6 w-5 flex-none text-green-600" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
            </svg>
            <div>
              <span class="font-semibold">Up to 1000 contacts</span>
              <p class="text-sm text-gray-500">That should be more than enough</p>
            </div>
          </li>
          <li class="flex items-start gap-x-3">
            <svg class="h-6 w-5 flex-none text-green-600" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
            </svg>
            <div>
              <span class="font-semibold">No usage-based pricing</span>
              <p class="text-sm text-gray-500">You pay once, and enjoy it forever</p>
            </div>
          </li>
          <li class="flex items-start gap-x-3">
            <svg class="h-6 w-5 flex-none text-green-600" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
            </svg>
            <div>
              <span class="font-semibold">Standard support</span>
              <p class="text-sm text-gray-500">Support via email</p>
            </div>
          </li>
        </ul>

        <div class="mt-8">
          <a href="{{ route('register') }}" class="group inline-flex w-full items-center justify-center gap-x-2 rounded-sm border border-b-3 border-gray-400 px-3 py-2 transition-colors duration-150 hover:bg-white">Get started</a>
        </div>
      </div>

      <div class="rounded-2xl border border-gray-200 bg-white p-8">
        <h3 class="text-xl font-semibold italic">For business purposes</h3>
        <p class="mb-4 text-gray-600">Still a one-time fee, btw</p>

        <div class="mb-8">
          <p class="flex items-baseline gap-x-1">
            <span class="text-2xl font-bold">$299</span>
            <span class="text-sm text-gray-500">one time fee</span>
          </p>
        </div>

        <ul class="mb-8 space-y-4">
          <li class="flex items-start gap-x-3">
            <svg class="h-6 w-5 flex-none text-green-600" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
            </svg>
            <div>
              <span class="font-semibold">Up to 1000 contacts</span>
              <p class="text-sm text-gray-500">That should be more than enough</p>
            </div>
          </li>
          <li class="flex items-start gap-x-3">
            <svg class="h-6 w-5 flex-none text-green-600" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
            </svg>
            <div>
              <span class="font-semibold">No usage-based pricing</span>
              <p class="text-sm text-gray-500">You pay once, and enjoy it forever</p>
            </div>
          </li>
          <li class="flex items-start gap-x-3">
            <svg class="h-6 w-5 flex-none text-green-600" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
            </svg>
            <div>
              <span class="font-semibold">Standard support</span>
              <p class="text-sm text-gray-500">Support via email</p>
            </div>
          </li>
        </ul>

        <div class="mt-8">
          <a href="{{ route('register') }}" class="group inline-flex w-full items-center justify-center gap-x-2 rounded-sm border border-b-3 border-gray-400 px-3 py-2 transition-colors duration-150 hover:bg-white">Get started</a>
        </div>
      </div>
    </div>

    <!-- All plans include section -->
    <div class="mt-16">
      <h2 class="text-sm font-semibold text-gray-900">All plans include:</h2>
      <ul class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <li class="flex items-start gap-x-3">
          <svg class="h-6 w-5 flex-none text-green-600" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
          </svg>
          <span class="text-sm text-gray-600">Unlimited team members</span>
        </li>
        <li class="flex items-start gap-x-3">
          <svg class="h-6 w-5 flex-none text-green-600" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
          </svg>
          <span class="text-sm text-gray-600">No limits on tracked users</span>
        </li>
        <li class="flex items-start gap-x-3">
          <svg class="h-6 w-5 flex-none text-green-600" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
          </svg>
          <span class="text-sm text-gray-600">API access</span>
        </li>
        <li class="flex items-start gap-x-3">
          <svg class="h-6 w-5 flex-none text-green-600" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
          </svg>
          <span class="text-sm text-gray-600">Google, Github, and Gitlab SSO</span>
        </li>
      </ul>
    </div>

    <x-marketing.edit-github />
  </div>
</x-marketing-layout>
