<?php
/*
 * @var int $accountNumbers
 * @var array $pullRequests
 * @var \App\Models\MarketingPage $marketingPage
 */
?>

<x-marketing-layout :marketing-page="$marketingPage">
  <!-- Hero Section -->
  <div class="relative bg-white">
    <div class="mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:px-8 xl:px-0">
      <div class="grid grid-cols-1 gap-x-8 gap-y-16 lg:grid-cols-2 lg:items-center">
        <!-- Left side - Text content -->
        <div class="max-w-2xl">
          <h1 class="text-4xl font-semibold tracking-tight text-gray-900 sm:text-6xl">{{ __('Remember what matters about the people you care about') }}</h1>
          <p class="mt-6 text-lg leading-8 text-gray-600">
            {{ __('PeopleOS helps you be more intentional with your relationships by keeping track of the important details about people in your life.') }}
          </p>
          <div class="mt-10 mb-5 flex items-center gap-x-6">
            <a href="{{ route('register') }}" class="rounded-md bg-blue-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-offset-2 focus-visible:outline-blue-600">
              {{ __('Get started for free') }}
            </a>
            <x-tooltip text="Just kidding. We have no sales teams.">
              <p class="cursor-pointer text-sm leading-6 font-semibold text-gray-900">
                {{ __('Talk to sales') }}
                <span aria-hidden="true">→</span>
              </p>
            </x-tooltip>
          </div>

          <p class="-rotate-2">
            <span class="rounded-md bg-green-100 px-1.5 py-1 font-semibold text-green-600">{{ $accountNumbers }}</span>
            crazy users like you registered in the last 7 days.
          </p>
        </div>

        <!-- Right side - Image -->
        <div class="relative">
          <img src="{{ asset('marketing/homepage.png') }}" alt="PeopleOS Screenshot" class="rounded-xl shadow-xl ring-1 ring-gray-400/10" />
          <!-- Optional decorative elements -->
          <div class="absolute -z-10 hidden lg:block">
            <div class="absolute -top-16 -right-16 h-72 w-72 rounded-full bg-blue-50 opacity-70 mix-blend-multiply blur-2xl"></div>
            <div class="absolute -bottom-16 -left-16 h-72 w-72 rounded-full bg-purple-50 opacity-70 mix-blend-multiply blur-2xl"></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Feature Section -->
  <div id="features" class="bg-gray-50 py-12">
    <div class="mx-auto max-w-7xl px-6 lg:px-8 xl:px-0">
      <!-- Title -->
      <div class="mx-auto max-w-2xl lg:text-center">
        <h2 class="text-base leading-7 font-semibold text-green-600">{{ __('Your personal CRM') }}</h2>
        <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
          {{ __('Every feature is crafted to help you maintain meaningful relationships') }}
        </p>
      </div>

      <!-- 3 benefits -->
      <div class="mx-auto mt-16 max-w-2xl sm:mt-20 lg:max-w-none">
        <dl class="mb-20 grid max-w-xl grid-cols-1 gap-x-8 gap-y-16 lg:max-w-none lg:grid-cols-3">
          <div class="flex flex-col">
            <dt class="flex items-center gap-x-3 text-base leading-7 font-semibold text-gray-900">
              <x-lucide-shield-check class="h-5 w-5 flex-none text-blue-600" />
              {{ __('Add information about family') }}
            </dt>
            <dd class="mt-4 flex flex-auto flex-col text-base leading-7 text-gray-600">
              <p class="flex-auto">{{ __('Record everything you know about family members, friends, pets and even mistresses. You can add context, indicate the age of the person even if you just know partial information.') }}</p>
            </dd>
          </div>

          <div class="flex flex-col">
            <dt class="flex items-center gap-x-3 text-base leading-7 font-semibold text-gray-900">
              <x-lucide-sparkles class="h-5 w-5 flex-none text-blue-600" />
              {{ __('Document everything') }}
            </dt>
            <dd class="mt-4 flex flex-auto flex-col text-base leading-7 text-gray-600">
              <p class="flex-auto">{{ __('Add notes to any person. Record work history, hobbies, interests, and more. Do not be like me - document so you do not forget.') }}</p>
            </dd>
          </div>

          <div class="flex flex-col">
            <dt class="flex items-center gap-x-3 text-base leading-7 font-semibold text-gray-900">
              <x-lucide-server class="h-5 w-5 flex-none text-blue-600" />
              {{ __('Reminders') }}
            </dt>
            <dd class="mt-4 flex flex-auto flex-col text-base leading-7 text-gray-600">
              <p class="flex-auto">{{ __('Set reminders for birthdays, anniversaries, and other important dates. You can also set reminders for yourself to do something for a person.') }}</p>
            </dd>
          </div>
        </dl>

        <div class="mx-auto text-center">
          <a href="" class="group mb-3 inline-flex items-center gap-x-2 rounded-sm border border-b-3 border-gray-400 px-3 py-2 transition-colors duration-150 hover:bg-white">
            <x-lucide-building class="h-4 w-4 text-indigo-600 group-hover:text-indigo-700" />
            <span class="text-sm text-gray-700 group-hover:text-gray-900">
              {{ __('See all the incredible features') }}
            </span>
          </a>
          <p class="text-sm text-gray-600 italic">{{ __('Nobody has features like we do. They\'re tremendous, just tremendous.') }}</p>
        </div>
      </div>
    </div>
  </div>

  <!-- why -->
  <div id="why" class="bg-white py-12">
    <div class="mx-auto max-w-2xl rounded-lg bg-green-100 px-6 py-4">
      <div class="grid grid-cols-1 gap-x-8 gap-y-16 lg:grid-cols-3 lg:items-center">
        <div class="col-span-2">
          <h2 class="mb-3 text-xl leading-7 font-semibold text-green-600">{{ __('Why should you use PeopleOS?') }}</h2>
          <p class="mb-2">PeopleOS is designed for people with jobs, families, and busy lives who are striving to maintain a good work–life balance. They're often so busy that they forget to call a friend, wish a nephew a happy birthday, or invite someone special to dinner next week. As we grow older, life increasingly gets in the way. It's unfortunate, but it's the reality.</p>
          <p class="mb-2">I've created PeopleOS to remember all these little, but so important, things.</p>
          <p>
            Read more about
            <a href="{{ route('marketing.why.index') }}" class="text-blue-600 hover:text-blue-500">{{ __('why this tool exists') }}</a>
            .
          </p>
        </div>
        <div class="flex flex-col items-center lg:col-span-1 lg:items-start" x-data="{ isRotating: false }">
          <div class="relative">
            <img src="{{ asset('marketing/regis.jpg') }}" alt="Monica" class="mb-3 w-40 rounded-lg transition-all duration-[2000ms] ease-[cubic-bezier(0.34,1.56,0.64,1)] hover:scale-110 hover:rotate-[360deg] lg:rotate-4" @mouseenter="isRotating = true" @mouseleave="isRotating = false" @transitionend="isRotating = false" />

            <!-- Tooltip -->
            <div x-show="isRotating" x-transition.opacity class="bg-opacity-75 absolute top-1/2 left-full ml-3 -translate-y-1/2 rounded-lg bg-black px-3 py-2 text-sm whitespace-nowrap text-white">Please stooooop this! 😵‍💫</div>
          </div>
          <p class="text-xs text-gray-600 lg:rotate-4">Régis Freyd. I created PeopleOS. Sorry.</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Github section -->
  <div id="github" class="bg-gray-50 py-12 sm:py-20">
    <div class="mx-auto max-w-7xl px-6 lg:px-8 xl:px-0">
      <div class="mx-auto mb-10 max-w-7xl">
        <h3 class="mt-2 mb-3 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
          {{ __('We deliver features so fast that Github can\'t keep up.') }}
        </h3>
        <p class="text-xl">{{ __('We release code every day. Nothing is worse than a software that doesn\'t evolve, except war, famine and TikTok.') }}</p>
      </div>
      <div class="grid grid-cols-1 gap-x-8 gap-y-16 lg:grid-cols-2" x-data="{
        selectedPR: {
          number: {{ $pullRequests[0]['number'] }},
          title: '{{ $pullRequests[0]['title'] }}',
          merged_at: '{{ $pullRequests[0]['merged_at'] }}',
          body: '{{ $pullRequests[0]['body'] ?? 'No description provided.' }}',
          url: '{{ $pullRequests[0]['url'] }}',
        },
      }">
        <!-- list of pr -->
        <ul>
          @foreach ($pullRequests as $pr)
            <li
              @click="selectedPR = {
              number: '{{ $pr['number'] }}',
              title: '{{ $pr['title'] }}',
              merged_at: '{{ $pr['merged_at'] }}',
              body: '{{ $pr['body'] ?? 'No description provided.' }}',
              url: '{{ $pr['url'] }}'
            }"
              x-bind:class="{
                'flex justify-between items-center gap-x-2 border border-transparent hover:border-gray-200 hover:bg-white rounded-lg p-2 cursor-pointer': true,
                'border border-gray-200 bg-white':
                  selectedPR.number === '{{ $pr['number'] }}',
              }">
              <div class="flex items-center gap-x-2">
                <x-lucide-check-circle class="h-4 w-4 text-green-600" />
                <span>{{ $pr['title'] }}</span>
                <span class="rounded-lg bg-green-100 px-2 py-1 font-mono text-xs">#{{ $pr['number'] }}</span>
              </div>

              <div class="flex items-center gap-x-2">
                <span class="font-mono text-xs">{{ $pr['merged_at'] }}</span>
                <x-lucide-chevron-right class="h-4 w-4 text-gray-600" />
              </div>
            </li>
          @endforeach

          <li class="mt-4 text-center text-gray-600">
            <a href="https://github.com/djaiss/peopleOS/pulls" target="_blank" class="text-blue-600 hover:text-blue-500">{{ __('See all the features') }}</a>
          </li>
        </ul>

        <!-- details of the pr -->
        <div class="col-span-1 rounded-lg border border-gray-200 bg-white">
          <div class="flex items-center justify-between border-b border-gray-200 p-4">
            <div class="text-xl" x-text="selectedPR.title"></div>
            <div>
              <span class="font-mono text-xs" x-text="selectedPR.merged_at"></span>
            </div>
          </div>
          <div class="prose border-b border-gray-200 p-4" x-html="selectedPR.body"></div>
          <div class="px-4 py-2 text-center">
            <a :href="selectedPR.url" target="_blank" class="group inline-flex items-center gap-x-2 rounded-sm border border-b-3 border-gray-400 px-3 py-2 transition-colors duration-150 hover:bg-gray-50">
              <x-lucide-github class="h-4 w-4 text-gray-600" />
              <span class="text-sm text-gray-700 group-hover:text-gray-900">
                {{ __('View on Github') }}
              </span>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- CTA Section -->
  <div id="privacy" class="bg-white py-12 sm:py-20">
    <div class="mx-auto max-w-7xl px-6 lg:px-8 xl:px-0">
      <h3 class="mt-2 mb-3 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
        {{ __('Privacy and transparency is at the core of what we do.') }}
      </h3>
      <p class="mb-10 text-xl">{{ __('You are not our product. You are the reason we exist.') }}</p>

      <div class="grid grid-cols-1 gap-x-8 gap-y-16 lg:grid-cols-4">
        <div class="rounded-lg bg-gray-50 p-4">
          <div class="mb-2 flex justify-center">
            <x-lucide-eye class="h-6 w-6 text-green-600" />
          </div>
          <h4 class="mb-3 text-center text-lg font-bold">{{ __('Transparent by nature') }}</h4>
          <p>{{ __('Our code is open source. This means you can see exactly how we build the software. We can\'t imagine a better way to build trust with our users.') }}</p>
        </div>
        <div class="rounded-lg bg-gray-50 p-4">
          <div class="mb-2 flex justify-center">
            <x-lucide-lock class="h-6 w-6 text-green-600" />
          </div>
          <h4 class="mb-3 text-center text-lg font-bold">{{ __('Data is encrypted at rest') }}</h4>
          <p>{{ __('We use industry-standard encryption to protect your data. If someone would steal the database, they would only see a bunch of gibberish.') }}</p>
        </div>
        <div class="rounded-lg bg-gray-50 p-4">
          <div class="mb-2 flex justify-center">
            <x-lucide-eye-off class="h-6 w-6 text-green-600" />
          </div>
          <h4 class="mb-3 text-center text-lg font-bold">{{ __('We do not track you') }}</h4>
          <p>{{ __('There is no javascript trackers or ads on this website. We do not try to upsell you anything. We do track the number of page views to improve the website, but that\'s it.') }}</p>
        </div>
        <div class="rounded-lg bg-gray-50 p-4">
          <div class="mb-2 flex justify-center">
            <x-lucide-brain class="h-6 w-6 text-green-600" />
          </div>
          <h4 class="mb-3 text-center text-lg font-bold">{{ __('No AI bullshit') }}</h4>
          <p>{{ __('We are not super fancy, and do not rely on AI in the application, as it is not ready for prime time and would currently lead to many privacy issues.') }}</p>
        </div>
      </div>
    </div>
  </div>

  <!-- you will hate it -->
  <div id="hate" class="bg-gray-50 py-12 sm:py-20">
    <div class="mx-auto max-w-7xl px-6 lg:px-8 xl:px-0">
      <div class="mx-auto mb-10 max-w-7xl">
        <h3 class="mt-2 mb-10 text-center text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
          Warning: PeopleOS is probably
          <span class="rounded-md bg-amber-500 px-2 py-1 text-white">not for you</span>
          if...
        </h3>

        <div class="grid grid-cols-1 gap-x-8 gap-y-16 lg:grid-cols-4">
          <div class="rotate-2 rounded-lg border border-gray-200 bg-white p-4">
            <div class="mb-2 flex items-center justify-center">
              <img src="{{ asset('marketing/good_memory.png') }}" alt="Good memory" width="200" height="300" />
            </div>
            <p class="mb-3 text-xl">You have a good memory</p>
            <p class="text-sm">If you can remember everything about everyone you know, you probably don't need this tool.</p>
          </div>

          <div class="-rotate-1 rounded-lg border border-gray-200 bg-white p-4">
            <div class="mb-2 flex items-center justify-center">
              <img src="{{ asset('marketing/recurring.png') }}" alt="Expensive subscriptions" width="200" height="300" />
            </div>
            <p class="mb-3 text-xl">You like expensive, reccuring subscriptions</p>
            <p class="text-sm">We offer the a one-time payment for the software. No subscriptions, no hidden fees.</p>
          </div>

          <div class="-rotate-1 rounded-lg border border-gray-200 bg-white p-4">
            <div class="mb-2 flex items-center justify-center">
              <img src="{{ asset('marketing/ads.png') }}" alt="Ads" width="200" height="300" />
            </div>
            <p class="mb-3 text-xl">You like being tracked for ads purposes</p>
            <p class="text-sm">We do track users to serve ads, and don't profile our users. We hate ads as much as you do.</p>
          </div>

          <div class="rotate-2 rounded-lg border border-gray-200 bg-white p-4">
            <div class="mb-2 flex items-center justify-center">
              <img src="{{ asset('marketing/prison.png') }}" alt="Prison" width="200" height="300" />
            </div>
            <p class="mb-3 text-xl">You like being locked in</p>
            <p class="text-sm">We strongly advocate that you don't use our hosted version, and that you self-host the software on a server of your own.</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Testimonials -->
  <div class="bg-white">
    <div class="mx-auto max-w-7xl py-24 sm:px-6 sm:py-32 lg:px-0">
      <div class="relative isolate overflow-hidden bg-gray-900 px-6 py-24 text-center shadow-2xl sm:rounded-3xl sm:px-16">
        <h2 class="mx-auto max-w-2xl text-3xl font-bold tracking-tight text-white sm:text-4xl">
          {{ __('Take control of your relationships and go out there. Life is not lived in front of a computer screen.') }}
        </h2>
        <p class="mx-auto mt-6 max-w-xl text-lg leading-8 text-gray-300">
          {{ __('But if you can\'t or are too shy about it, we can help you by providing a simple tool to do so.') }}
        </p>
        <div class="mt-10 flex items-center justify-center gap-x-6">
          <a href="{{ route('register') }}" class="rounded-md bg-white px-3.5 py-2.5 text-sm font-semibold text-gray-900 shadow-sm hover:bg-gray-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">
            {{ __('Get started for free') }}
          </a>
          <a href="{{ route('login') }}" class="text-sm leading-6 font-semibold text-white">
            {{ __('Sign in') }}
            <span aria-hidden="true">→</span>
          </a>
        </div>
      </div>
    </div>
  </div>
</x-marketing-layout>
