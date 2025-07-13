<?php
/*
 * @var \App\Models\MarketingPage $marketingPage
 * @var string $viewName
 */
?>

<x-marketing-layout :marketing-page="$marketingPage" :view-name="$viewName">
  @include('marketing.company.partials.company-header')

  <!-- breadcrumb -->
  <div class="border-b border-gray-200 py-3 text-sm">
    <div class="mx-auto flex max-w-7xl items-center gap-x-2 px-6 lg:px-8 xl:px-0">
      <a href="{{ route('marketing.index') }}" class="text-blue-500 hover:underline">{{ __('Home') }}</a>
      <span class="text-gray-500">&gt;</span>
      <span class="text-gray-600">{{ __('Company') }}</span>
    </div>
  </div>

  <h1 class="mb-6 text-2xl font-bold">Our handbook</h1>

  <p>This handbook explains what I do, how I think and how I want to move this project forward.</p>
</x-marketing-layout>
