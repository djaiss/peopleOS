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
        <div class="prose mb-5 max-w-none">
          <h1 id="introduction" class="text-xl font-normal">Why should you use PeopleOS?</h1>

          <h2 id="problems" class="flex items-center gap-x-3">
            <x-lucide-frown class="h-6 w-6 flex-shrink-0 text-amber-500" />
            What kind of problem does PeopleOS solve?
          </h2>

          <p>Consider these common scenarios:</p>

          <ul>
            <li>You meet a friend's partner at a dinner party, have a great conversation about their recent trip to Japan, but completely forget these details the next time you meet.</li>
            <li>Your colleague mentions their child's upcoming school play, but you forget to follow up and ask how it went.</li>
            <li>You want to buy the perfect birthday gift for your nephew, but can't remember if he's still into dinosaurs or has moved on to space exploration.</li>
            <li>A friend shares their struggle with a personal challenge, but you forget to check in on them a few weeks later.</li>
          </ul>

          <p>These missed opportunities for connection add up over time, gradually eroding the quality of our relationships. We're not failing because we don't care - we're failing because our brains aren't wired to keep track of hundreds of meaningful details about dozens of people.</p>

          <h2 id="open-source" class="flex items-center gap-x-3">
            <x-lucide-lightbulb class="h-6 w-6 text-green-500" />
            We do things in the open
          </h2>

          <p>Even though we pioneered the personal CRM concept, we now face a lot of competition. However, all of them are closed source. Being closed source means that you don't know what they do with the code, and therefore your data. I wouldn't trust a closed solution to store such personal and intimate details about my friends and family.</p>

          <p>
            PeopleOS is
            <a href="https://github.com/djaiss/peopleos" class="text-blue-600 hover:text-blue-500">100% open source</a>
            . This means the source code is available for everyone to see, contribute or change.
          </p>

          <p>From our revenues page, to our roadmap, everything we do is done in public.</p>

          <h2 id="no-tracking" class="flex items-center gap-x-3">
            <x-lucide-shield class="h-6 w-6 text-blue-500" />
            We do not track you
          </h2>

          <p>The only thing that we track is the page views on our website to improve it. For this we use Pirsch Analytics and these metrics are public. We do not use track you in any other way.</p>

          <p>We do not use AI or anything silly like that. If we did, that would constitute a major privacy risk. Also, we believe that maintaining relationships is a human activity, and should be kept that way.</p>

          <p>We also do not sell your data to third parties, and we do not use your data to sell ads. We do not use your data to sell you anything. Look. We are humans like you. We personally hate all the shitshows that big companies do with our data. We would never do that to you.</p>
        </div>

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
