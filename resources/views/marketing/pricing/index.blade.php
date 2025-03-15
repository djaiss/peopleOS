<x-marketing-layout>
  <!-- breadcrumb -->
  <div class="border-b border-gray-200 py-3 text-sm">
    <div class="mx-auto flex max-w-7xl items-center gap-x-2 px-6 lg:px-8 xl:px-0">
      <a href="{{ route('marketing.index') }}" class="text-blue-500 hover:underline">{{ __('Home') }}</a>
      <span class="text-gray-500">&gt;</span>
      <span class="text-gray-600">{{ __('Why PeopleOS?') }}</span>
    </div>
  </div>

  <div class="relative mx-auto max-w-7xl px-6 lg:px-8 xl:px-0">
    <div class="grid grid-cols-1 gap-x-16 lg:grid-cols-[1fr_250px]">
      <!-- Main content -->
      <div class="py-16 sm:border-r sm:border-gray-200 sm:pr-10">

        <p>We have three plans.</p>
        <p>They are all a one-time fee, and not a subscription.</p>
        <p>I repeat, because it's really rare these days. They are all a one-time fee.</p>

        <p>Please choose one of the following plans. It’s entirely based on the honour system—we won’t ask you for any proof of your status.</p>

        <ul>
          <li>For students or people with financial difficulties</li>
          <li>USD $29</li>
          <li>One-time payment</li>
          <li>No subscriptions, no hidden costs</li>
          <li>Up to 1 000 contacts</li>
        </ul>

        <ul>
          <li>For people with a regular job</li>
          <li>USD $99</li>
          <li>One-time payment</li>
          <li>No subscriptions, no hidden costs</li>
          <li>Up to 1 000 contacts</li>
        </ul>

        <ul>
          <li>For people who plan to use PeopleOS for professional use</li>
          <li>USD $299</li>
          <li>One-time payment</li>
          <li>No subscriptions, no hidden costs</li>
          <li>Up to 1 000 contacts</li>
        </ul>

        <p>It’s free for up to 10 contacts. After that, we’ll ask you to pay.</p>

        <p></p>

        <x-marketing.edit-github />
      </div>

      <!-- Sidebar -->
      <div class="mb-10 hidden w-full flex-shrink-0 flex-col justify-self-end lg:flex">
        <div class="bg-light dark:bg-dark z-10 pt-16">
          <div class="mb-1 flex items-center justify-between">
            <p class="text-xs">Written by...</p>
          </div>
          <div class="-mx-4 pt-1">
            <a href="" class="border-light dark:border-dark text-primary dark:text-primary-dark hover:text-primary dark:hover:text-primary-dark relative flex justify-between rounded border hover:border-b-[4px] hover:transition-all active:top-[2px] active:border-b-1 md:mx-4">
              <div class="flex w-full flex-col justify-between gap-0.5 px-4 py-2">
                <h3 class="mb-0 text-base leading-tight"><span>Régis Freyd</span></h3>
                <p class="text-primary/50 dark:text-primary-dark/50 m-0 line-clamp-1 text-sm leading-tight">Founder</p>
              </div>
              <div class="flex-shrink-0 px-4 py-2">
                <img src="{{ asset('marketing/regis.jpg') }}" alt="Regis" class="h-12 w-12 rounded-full" />
              </div>
            </a>
          </div>
        </div>
        <div class="flex flex-grow items-end">
          <div class="sticky bottom-0 w-full">
            <!-- Table of Contents -->
            <div class="mb-4">
              <h4 class="mb-2 text-xs font-semibold text-gray-500 uppercase">Jump to</h4>
              <nav class="space-y-1 text-sm">
                <a href="#introduction" class="group flex items-center gap-x-2 rounded-sm border border-b-3 border-transparent px-2 py-1 text-gray-600 transition-colors duration-50 hover:border-gray-400 hover:bg-white">What is PeopleOS?</a>
                <a href="#problems" class="group flex items-center gap-x-2 rounded-sm border border-b-3 border-transparent px-2 py-1 text-gray-600 transition-colors duration-50 hover:border-gray-400 hover:bg-white">What kind of problem does PeopleOS solve?</a>
                <a href="#open-source" class="group flex items-center gap-x-2 rounded-sm border border-b-3 border-transparent px-2 py-1 text-gray-600 transition-colors duration-50 hover:border-gray-400 hover:bg-white">We do things in the open</a>
                <a href="#no-tracking" class="group flex items-center gap-x-2 rounded-sm border border-b-3 border-transparent px-2 py-1 text-gray-600 transition-colors duration-50 hover:border-gray-400 hover:bg-white">We do not track you</a>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-marketing-layout>
