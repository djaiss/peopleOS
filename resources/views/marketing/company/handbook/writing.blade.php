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
    <span class="text-gray-600">{{ __('Writing for PeopleOS') }}</span>
  </x-slot>

  <h1 class="mb-6 text-2xl font-bold">Writing for PeopleOS</h1>

  <div class="prose">
    <p class="mb-2">There are two ways of writing for PeopleOS:</p>

    <ul>
      <li>the user interface in the product,</li>
      <li>the marketing material.</li>
    </ul>

    <p class="mb-2">For the user interface, the tone should be simple, direct, informative, and serious. Actions in the user interface should use the imperative tone. For instance, we would say “Save” instead of “I save.”</p>

    <p class="mb-2">For the marketing material, we should be really approachable, funny, give a lot of value, and don't take ourselves seriously at all.</p>

    <p class="mb-10">In all cases though, we should remain extremely humble. We know nothing, really, and we merely exist for the sole purpose of helping others.</p>
  </div>

  <div>
    <x-marketing-page-widget :marketing-page="$marketingPage" />
  </div>

  <x-slot name="rightSidebar">
    <x-marketing.handbook-stats :stats="$stats" />
  </x-slot>
</x-marketing-handbook-layout>
