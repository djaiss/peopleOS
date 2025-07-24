<?php
/*
 * @var array $stats
 * @var \App\Models\MarketingPage $marketingPage
 * @var string $viewName
 */
?>

{{-- @llms-title: Money --}}
{{-- @llms-description: How does this project make money --}}
{{-- @llms-route: /company/handbook/money --}}
<x-marketing-handbook-layout :marketing-page="$marketingPage" :view-name="$viewName">
  <x-slot name="breadcrumb">
    <a href="{{ route('marketing.index') }}" class="text-blue-500 hover:underline">{{ __('Home') }}</a>
    <span class="text-gray-500">&gt;</span>
    <a href="{{ route('marketing.company.index') }}" class="text-blue-500 hover:underline">{{ __('Company') }}</a>
    <span class="text-gray-500">&gt;</span>
    <a href="{{ route('marketing.company.handbook.index') }}" class="text-blue-500 hover:underline">{{ __('Handbook') }}</a>
    <span class="text-gray-500">&gt;</span>
    <span class="text-gray-600">{{ __('How does this project make money') }}</span>
  </x-slot>

  <h1 class="mb-6 text-2xl font-bold">How does this project make money</h1>

  <div class="prose">
    <p class="mb-2">First of all, the goal of this project is not to make money. The primary goal is to create a tool that I need, to learn new programming techniques, to improve what I already know, and to have fun. It's my way of releasing the pressure of my other real job. PeopleOS is given for free as an open source tool, and you can install, modify or delete whatever you want and do whatever you want with it and I have no problem with that.</p>

    <p class="mb-2">But considering the extreme amount of time I put into trying to create a nice tool for everyone and not just for me, it'd be nice if it brought some money too so I can buy a new computer, a new bike or a new gadget. And not just for that. Yes, hosting the database itself costs almost nothing, but we still need to pay for the system that sends reminders and other services which, unfortunately, have a monthly fee attached to them.</p>

    <p class="mb-2">This project makes money by selling an access to the instance of PeopleOS that I own. For a single, one-time fee, you will have access to it forever, without being locked in. It's simple, really.</p>

    <p class="mb-2">I strongly believe that we have too many subscriptions these days. Subscriptions suck. I hate them. Let me buy a product once and for all. Subscriptions is renting something that you don't own. For an online software, it's even trickier. Yes you pay once, but how can you be sure that you will still own the software even if it dies?</p>

    <p class="mb-2">This is one of the reason the software is open source. If this site is ever shut down, you'll still have the software available on Github and elsewhere. Anyway. Host your software yourself. Pay and use the version I host. I don't care as long as you are happy.</p>

    <h3 class="mb-2 text-lg font-bold">A note on VC</h3>

    <p class="mb-2">How can I put this as delicately as possible? Fuck VC money. Yeah, I think that's a delicate way of putting it.</p>

    <p class="mb-2">In my previous project, I spent some time answering emails and attending calls with VCs. This is such a waste of time. They don't ever want to actually invest. They just want to understand why the product is a success and what is the market size. Not a single one of them had an ounce of respect for user privacy.</p>

    <p class="mb-10">Money is great, but independence and having to answer to no one is invaluable. Or is worth 50 millions, but no less.</p>
  </div>

  <div>
    <x-marketing-page-widget :marketing-page="$marketingPage" :view-name="$viewName" />
  </div>

  <x-slot name="rightSidebar">
    <x-marketing.handbook-stats :stats="$stats" />
  </x-slot>
</x-marketing-handbook-layout>
