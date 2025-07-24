<?php
/*
 * @var array $stats
 * @var \App\Models\MarketingPage $marketingPage
  * @var string $viewName
 */
?>

{{-- @llms-title: Social media --}}
{{-- @llms-description: Social media --}}
{{-- @llms-route: /company/handbook/social-media --}}
<x-marketing-handbook-layout :marketing-page="$marketingPage" :view-name="$viewName">
  <x-slot name="breadcrumb">
    <a href="{{ route('marketing.index') }}" class="text-blue-500 hover:underline">{{ __('Home') }}</a>
    <span class="text-gray-500">&gt;</span>
    <a href="{{ route('marketing.company.index') }}" class="text-blue-500 hover:underline">{{ __('Company') }}</a>
    <span class="text-gray-500">&gt;</span>
    <a href="{{ route('marketing.company.handbook.index') }}" class="text-blue-500 hover:underline">{{ __('Handbook') }}</a>
    <span class="text-gray-500">&gt;</span>
    <span class="text-gray-600">{{ __('Social media') }}</span>
  </x-slot>

  <h1 class="mb-6 text-2xl font-bold">Social media</h1>

  <div class="prose">
    <p class="mb-2">On social media, we want to have a distinct, non serious voice. We should talk about two things: the product itself, and funny things.</p>

    <p class="mb-2">We should target our core audience. The problem is how difficult is to know our target audience. PeopleOS is used by many people with completely different background and context. How can we fine tune our message so it matches their interests?</p>

    <p class="mb-2">The only audience I really know, is me. I would use PeopleOS. I know I'm a very specific niche: a nerd with some social anxiety. But I'll do like I create the product: I'll do something that matches my values and my personnality.</p>

    <p class="mb-10">If you have a business, you really should never follow my advice. The good thing is that PeopleOS is not a business for me.</p>
  </div>

  <div>
    <x-marketing-page-widget :marketing-page="$marketingPage" :view-name="$viewName" />
  </div>

  <x-slot name="rightSidebar">
    <x-marketing.handbook-stats :stats="$stats" />
  </x-slot>
</x-marketing-handbook-layout>
