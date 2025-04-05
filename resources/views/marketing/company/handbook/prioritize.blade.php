<?php
/*
 * @var array $stats
 * @var \App\Models\MarketingPage $marketingPage
  * @var string $viewName
 */
?>

<x-marketing-handbook-layout :marketing-page="$marketingPage" :view-name="$viewName">
  <x-slot name="breadcrumb">
    <a href="{{ route('marketing.index') }}" class="text-blue-500 hover:underline">{{ __('Home') }}</a>
    <span class="text-gray-500">&gt;</span>
    <a href="{{ route('marketing.company.index') }}" class="text-blue-500 hover:underline">{{ __('Company') }}</a>
    <span class="text-gray-500">&gt;</span>
    <a href="{{ route('marketing.company.handbook.index') }}" class="text-blue-500 hover:underline">{{ __('Handbook') }}</a>
    <span class="text-gray-500">&gt;</span>
    <span class="text-gray-600">{{ __('How do we prioritize features?') }}</span>
  </x-slot>

  <h1 class="mb-6 text-2xl font-bold">How do we prioritize features?</h1>

  <div class="prose">
    <p class="mb-2">This one is spicy. As a project maintainer, I have to battle two constant conflicting thoughts. On one hand we have what the user wants and needs. On the other hand, I have what I like to work on. Sometimes these priorities align, and other times they do not.</p>

    <p class="mb-2">I've built PeopleOS for myself. I've open sourced it so others can take advantage of it too. And I've decided to host my own version so people can use it too.</p>

    <p class="mb-2">Now I'm not a regular business. I don't seek money and everywhere I can, I advocate that people should use the Docker image and host PeopleOS themselves instead of relying on the version I host. Even though the software is as secured as it can be, it won't replace a system that you own completely.</p>

    <p class="mb-2">This is why, apart from fixing bugs which should always be the priority, I might decide to work on something that I want, rather than what the entire community wants. I want to have fun with this project. I want to enjoy my time working on this project. For instance, implementing CalDav is not fun for me. I'll probably never do it. And I will also probably not accept this contribution if it comes from the community since I would have to maintain it for the rest of the software's life, and not the community.</p>

    <p class="mb-10">However, I'm also not blind. If I see that something keeps coming up, I'll eventually implement it. I want to help others, and one way to help others is to achieve something they would want. Except if this is something that would kill the effort of actually working hard to keep good relationships.</p>
  </div>

  <div>
    <x-marketing-page-widget :marketing-page="$marketingPage" :view-name="$viewName" />
  </div>

  <x-slot name="rightSidebar">
    <x-marketing.handbook-stats :stats="$stats" />
  </x-slot>
</x-marketing-handbook-layout>
