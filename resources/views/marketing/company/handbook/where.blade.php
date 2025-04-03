<?php
/*
 * @var array $stats
 * @var \App\Models\MarketingPage $marketingPage
 */
?>

<x-marketing-handbook-layout :marketing-page="$marketingPage">
  <x-slot name="breadcrumb">
    <a href="{{ route('marketing.index') }}" class="text-blue-500 hover:underline">{{ __('Home') }}</a>
    <span class="text-gray-500">&gt;</span>
    <a href="{{ route('marketing.company.index') }}" class="text-blue-500 hover:underline">{{ __('Company') }}</a>
    <span class="text-gray-500">&gt;</span>
    <a href="{{ route('marketing.company.handbook.index') }}" class="text-blue-500 hover:underline">{{ __('Handbook') }}</a>
    <span class="text-gray-500">&gt;</span>
    <span class="text-gray-600">{{ __('Where am I going with this') }}</span>
  </x-slot>

  <h1 class="mb-6 text-2xl font-bold">Where am I going with this</h1>

  <div class="prose">
    <p class="mb-2">This project has one scope: it's about documenting your life and the information you know about the people you care about. That's the only scope.</p>

    <p class="mb-2">This project is not meant to be:</p>

    <ul>
      <li>a social network,</li>
      <li>a repository for all your photos,</li>
      <li>a contact book storing all your contacts,</li>
      <li>a place where all the possible very specific use cases could live, like things that match your particular life and not the lives of many others.</li>
    </ul>

    <p class="mb-2">A great project is the direct result of all the no's, not the yes's. For one yes, there should be a thousand no.</p>

    <p class="mb-10">I don't want PeopleOS to become a software where everything is configurable through an option. The more options, the harder it is for testing the software with all the possible edge cases. Options are generally bad in consumer products. We'll make a new option only if we have no choice.</p>
  </div>

  <div>
    <x-marketing-page-widget :marketing-page="$marketingPage" />
  </div>

  <x-slot name="rightSidebar">
    <x-marketing.handbook-stats :stats="$stats" />
  </x-slot>
</x-marketing-handbook-layout>
