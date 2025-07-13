<?php
/*
 * @var \App\Models\MarketingPage $marketingPage
 * @var string $viewName
 */
?>

<x-marketing-layout :marketing-page="$marketingPage" :view-name="$viewName">
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
              <p class="text-sm text-gray-500">There cannot be any privacy issues</p>
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
            <img src="{{ asset('marketing/docker.svg') }}" class="mr-2 inline-block h-8 w-8" loading="lazy" />
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

    <div class="mx-auto mt-16 mb-8 max-w-3xl px-6 lg:px-8 xl:px-0">
      <div class="mb-8 flex items-center justify-center gap-x-2">
        <x-lucide-message-circle-question class="h-6 w-6 text-gray-500" />
        <h3 class="text-center text-2xl font-semibold">Frequently Asked Questions</h3>
      </div>

      <div class="space-y-6">
        <div class="border-b border-gray-200 pb-5">
          <h4 id="is-my-data-secure" class="group relative text-lg font-medium text-gray-900">
            Is my data secure?
            <a href="#is-my-data-secure" class="ml-2 text-blue-500 opacity-0 transition-opacity group-hover:opacity-100">#</a>
          </h4>
          <div class="mt-2 text-gray-600">
            <p class="mb-2">If you want complete security and privacy, we strongly, strongly urge you to host your own instance of PeopleOS.</p>
            <p>
              That being said, we try very hard to make sure your data is secure. Data is encrypted at rest - this means it's encrypted and if bad people were to have access to the database, they couldn't read it. We host the site on
              <a href="https://cloud.laravel.com" class="text-blue-500 hover:underline">Laravel Cloud</a>
              , which is a great, secure platform which uses S3 under the hood.
            </p>
          </div>
        </div>

        <div class="border-b border-gray-200 pb-5">
          <h4 id="is-my-data-private" class="group relative text-lg font-medium text-gray-900">
            Is my data private?
            <a href="#is-my-data-private" class="ml-2 text-blue-500 opacity-0 transition-opacity group-hover:opacity-100">#</a>
          </h4>
          <div class="mt-2 text-gray-600">
            <p class="mb-2">Again. If you want complete privacy, do not use our online service, and no other online services for that matter. Install PeopleOS on your own hardware. It's legal, it's free.</p>
            <p class="mb-2">That being said, we deeply care about user privacy. For instance, there is no tracking on this website. No Google Analytics, nothing. The codebase is completely open for you to read. The database is encrypted. No private information is sent to an external server (except the one that is used to host your data). Your email address is never shared to anyone and we don't send marketing emails.</p>
            <p>I'd like to see Facebook do that.</p>
          </div>
        </div>

        <div class="border-b border-gray-200 pb-5">
          <h4 id="is-there-a-free-tier" class="group relative text-lg font-medium text-gray-900">
            Is there a free tier?
            <a href="#is-there-a-free-tier" class="ml-2 text-blue-500 opacity-0 transition-opacity group-hover:opacity-100">#</a>
          </h4>
          <div class="mt-2 text-gray-600">
            <p class="mb-2">No. We offer a trial account for 30 days. After 30 days, if you want to continue using your account, you need to pay a single, one-time fee to unlock your account forever. Yes, forever. Yes, it's not a subscription.</p>
            <p>If you want a free forever account, please download and install the software yourself. It's free, and you will own your data forever.</p>
          </div>
        </div>

        <div class="border-b border-gray-200 pb-5">
          <h4 id="do-you-offer-refunds" class="group relative text-lg font-medium text-gray-900">
            Do you offer refunds?
            <a href="#do-you-offer-refunds" class="ml-2 text-blue-500 opacity-0 transition-opacity group-hover:opacity-100">#</a>
          </h4>
          <div class="mt-2 text-gray-600">
            <p class="mb-2">No. We offer a trial period, with all the features unlocked, that last 30 days. This will give enough time to decide whether the product is useful or not.</p>
            <p>Please, be sure before you unlock PeopleOS. Credit card disputes cost us $20 per dispute, and it's not fun for everyone. The purchasing flow will actually discourage you from buying the product if you're not sure about it.</p>
          </div>
        </div>

        <div class="border-b border-gray-200 pb-5">
          <h4 id="meaning-of-life" class="group relative text-lg font-medium text-gray-900">
            What is the answer to the Ultimate Question of Life, The Universe, and Everything?
            <a href="#meaning-of-life" class="ml-2 text-blue-500 opacity-0 transition-opacity group-hover:opacity-100">#</a>
          </h4>
          <div class="mt-2 text-gray-600">
            <p>42. Of course.</p>
          </div>
        </div>

        <div class="border-b border-gray-200 pb-5">
          <h4 id="can-i-import-my-data" class="group relative text-lg font-medium text-gray-900">
            Can I import my data?
            <a href="#can-i-import-my-data" class="ml-2 text-blue-500 opacity-0 transition-opacity group-hover:opacity-100">#</a>
          </h4>
          <div class="mt-2 text-gray-600">
            <p class="mb-2">If the case you have an existing local PeopleOS instance, you would want to import your data to our instance of PeopleOS. Short answer: you can't do that. We only do an export, not an import. Why? Because of security issues. Honestly, it would be too much of a risk to insert the data directly into the database.</p>
            <p>For all the conspiracy theorists out there, no, it's not because I want to keep your data forever. I actually want everyone to run their own instances of PeopleOS, so I'm free of the responsibility of your data.</p>
          </div>
        </div>

        <div class="pb-5">
          <h4 id="can-i-delete-my-account" class="group relative text-lg font-medium text-gray-900">
            Can I delete my account and am I autonomous?
            <a href="#can-i-delete-my-account" class="ml-2 text-blue-500 opacity-0 transition-opacity group-hover:opacity-100">#</a>
          </h4>
          <div class="mt-2 text-gray-600">
            <p>Yes. You can delete your account yourself, at any time, and you have the full control over your account without depending on anything from us.</p>
          </div>
        </div>
      </div>
    </div>

    <x-marketing-page-widget :marketing-page="$marketingPage" :view-name="$viewName" />
  </div>
</x-marketing-layout>
