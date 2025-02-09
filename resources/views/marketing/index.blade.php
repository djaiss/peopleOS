<?php
/*
 * @var int $accountNumbers
 */
?>

<x-marketing-layout>
  <!-- Hero Section -->
  <div class="relative bg-white">
    <div class="mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:px-8">
      <div class="grid grid-cols-1 gap-x-8 gap-y-16 lg:grid-cols-2 lg:items-center">
        <!-- Left side - Text content -->
        <div class="max-w-2xl">
          <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">{{ __('Remember what matters about the people you care about') }}</h1>
          <p class="mt-6 text-lg leading-8 text-gray-600">
            {{ __('PeopleOS helps you be more intentional with your relationships by keeping track of the important details about people in your life.') }}
          </p>
          <div class="mt-10 flex items-center gap-x-6 mb-5">
            <a href="{{ route('register') }}" class="rounded-md bg-blue-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
              {{ __('Get started for free') }}
            </a>
            <x-tooltip text="Just kidding. We have no sales teams.">
            <p class="text-sm leading-6 font-semibold cursor-pointer text-gray-900">
              {{ __('Talk to sales') }}
              <span aria-hidden="true">→</span>
            </p>
            </x-tooltip>
          </div>

          <p class="-rotate-2"><span class="px-1.5 py-1 bg-green-100 font-semibold text-green-600 rounded-md">{{ $accountNumbers }}</span> crazy users like you registered in the last 7 days.</p>
        </div>

        <!-- Right side - Image -->
        <div class="relative">
          <img src="{{ asset('marketing/homepage.png') }}" alt="PeopleOS Screenshot" class="rounded-xl ring-1 shadow-xl ring-gray-400/10" />
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
  <div id="features" class="bg-gray-50 py-24 sm:py-32">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
      <!-- Title -->
      <div class="mx-auto max-w-2xl lg:text-center">
        <h2 class="text-base leading-7 font-semibold text-green-600">{{ __('Your personal CRM') }}</h2>
        <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
          {{ __('Every feature is crafted to help you maintain meaningful relationships') }}
        </p>
      </div>

      <!-- 3 benefits -->
      <div class="mx-auto mt-16 max-w-2xl sm:mt-20  lg:max-w-none">
        <dl class="grid max-w-xl grid-cols-1 gap-x-8 gap-y-16 lg:max-w-none lg:grid-cols-3 mb-20">
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


        <div class="text-center mx-auto">
          <a href="" class="group inline-flex items-center gap-x-2 rounded-sm border border-b-3 px-3 py-2 transition-colors duration-150 border-gray-400 hover:bg-white mb-3">
            <x-lucide-building class="h-4 w-4 text-indigo-600 group-hover:text-indigo-700" />
            <span class="text-sm text-gray-700 group-hover:text-gray-900">
              {{ __('See all the incredible features') }}
            </span>
          </a>
          <p class="text-gray-600 text-sm italic">{{ __('Nobody has features like we do. They\'re tremendous, just tremendous.') }}</p>
        </div>
        </div>
      </div>
    </div>

    <!-- why -->
    <div class="mx-auto mt-16 max-w-2xl sm:mt-20 lg:my-24 px-6 py-4 rounded-lg bg-green-100">
      <div class="grid grid-cols-1 gap-x-8 gap-y-16 lg:grid-cols-3 lg:items-center">
        <div class="col-span-2">
          <h2 class="text-xl leading-7 font-semibold text-green-600 mb-3">{{ __('Why the hell should you use PeopleOS?') }}</h2>
          <p class="mb-2">Monica is for people who have jobs, a family, and are busy trying to find a good work/life balance. So busy, that they don't have time anymore to remember to call a friend, say happy birthday to a nephew, or remember to invite someone special for dinner next week. The older we get, the more life gets in the way. It's sad, but it's the reality.</p>
          <p class="mb-2">I've created PeopleOS to remember all these little, but so important, things.</p>
          <p>Read more about <a href="" class="text-blue-600 hover:text-blue-500">{{ __('why this tool exists') }}</a>.</p>
        </div>
        <div class="lg:col-span-1 flex flex-col items-center lg:items-start">
          <img src="{{ asset('marketing/regis.jpg') }}" alt="Monica" class="rounded-lg w-40 lg:rotate-4 mb-3">
          <p class="lg:rotate-4 text-xs text-gray-600">Régis Freyd. I created PeopleOS. Sorry.</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Github section -->
  <div id="features" class="bg-gray-50 py-12 sm:py-20">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
      <div class="mx-auto max-w-7xl mb-10">
        <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
          {{ __('We deliver features so fast that Github can\'t keep up.') }}
        </p>
      </div>
      <div class="grid grid-cols-1 gap-x-8 gap-y-16 lg:grid-cols-3">
        <!-- list of pr -->
        <ul>
          @foreach ($pullRequests as $pr)
          <li class="flex justify-between items-center gap-x-2 border border-transparent hover:border-gray-200 hover:bg-white rounded-lg p-2">
            <div class="flex items-center gap-x-2">
              <x-lucide-check-circle class="w-4 h-4 text-green-600" />
              <span>{{ $pr['title'] }}</span>
              <span class="font-mono text-sm rounded-lg bg-green-100 px-2 py-1">#{{ $pr['number'] }}</span>
            </div>

            <div class="flex items-center gap-x-2">
              <span class="font-mono text-sm">{{ $pr['merged_at'] }}</span>
              <x-lucide-chevron-right class="w-4 h-4 text-gray-600" />
            </div>
          </li>
          @endforeach
        </ul>

        <!-- details of the pr -->
        <div class="col-span-2 bg-white rounded-lg border border-gray-200">
          <div class="p-4 border-b border-gray-200 flex justify-between items-center">
            <div class="text-xl">feat: add a person</div>
            <div>
              <span class="font-mono text-xs">Merged 3 days ago</span>
            </div>
          </div>
          <div class="p-4 border-b border-gray-200">
            Add a person to the database.
          </div>
          <div class="px-4 py-2 text-center">
            <a href="" class="group inline-flex items-center gap-x-2 rounded-sm border border-b-3 px-3 py-2 transition-colors duration-150 border-gray-400 hover:bg-gray-50">
              <x-lucide-github class="w-4 h-4 text-gray-600" />
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
  <div class="bg-white">
    <div class="mx-auto max-w-7xl py-24 sm:px-6 sm:py-32 lg:px-8">
      <div class="relative isolate overflow-hidden bg-gray-900 px-6 py-24 text-center shadow-2xl sm:rounded-3xl sm:px-16">
        <h2 class="mx-auto max-w-2xl text-3xl font-bold tracking-tight text-white sm:text-4xl">
          {{ __('Start building better relationships today') }}
        </h2>
        <p class="mx-auto mt-6 max-w-xl text-lg leading-8 text-gray-300">
          {{ __('Join thousands of users who use PeopleOS to maintain meaningful connections with the people who matter most.') }}
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
