<?php
/*
 * @var \App\Models\MarketingPage $marketingPage
 * @var string $viewName
 */
?>

{{-- @llms-title: Handbook --}}
{{-- @llms-description: Our handbook --}}
{{-- @llms-route: /company/handbook --}}
<x-marketing-handbook-layout :marketing-page="$marketingPage" :view-name="$viewName">
  <x-slot name="breadcrumb">
    <a href="{{ route('marketing.index') }}" class="text-blue-500 hover:underline">{{ __('Home') }}</a>
    <span class="text-gray-500">&gt;</span>
    <a href="{{ route('marketing.company.index') }}" class="text-blue-500 hover:underline">{{ __('Company') }}</a>
    <span class="text-gray-500">&gt;</span>
    <span class="text-gray-600">{{ __('Handbook') }}</span>
  </x-slot>

  <h1 class="mb-6 text-2xl font-bold">Our handbook</h1>

  <p class="mb-6">This handbook explains what I do, how I think and how I want to move this project forward. Brace yourself, it's very good. At least I think so.</p>

  <div class="flex flex-col gap-y-4">
    <div class="flex items-center justify-between">
      <p class="font-semibold">General information</p>
      <div class="ml-4 flex-grow border-b border-dashed border-gray-800"></div>
    </div>
    <div class="flex items-center justify-between pl-6">
      <a href="{{ route('marketing.company.handbook.project') }}" class="text-blue-500 hover:underline">Who I am and what is this project</a>
      <div class="mx-4 flex-grow border-b border-dashed border-gray-800"></div>
      <p class="text-gray-600">{{ \App\Helpers\MarketingHelper::countWords('marketing.company.handbook.project') }} words</p>
    </div>
    <div class="flex items-center justify-between pl-6">
      <a href="{{ route('marketing.company.handbook.principles') }}" class="text-blue-500 hover:underline">Principles</a>
      <div class="mx-4 flex-grow border-b border-dashed border-gray-800"></div>
      <p class="text-gray-600">{{ \App\Helpers\MarketingHelper::countWords('marketing.company.handbook.principles') }} words</p>
    </div>
    <div class="flex items-center justify-between pl-6">
      <a href="{{ route('marketing.company.handbook.shipping') }}" class="text-blue-500 hover:underline">Shipping is better than not shipping</a>
      <div class="mx-4 flex-grow border-b border-dashed border-gray-800"></div>
      <p class="text-gray-600">{{ \App\Helpers\MarketingHelper::countWords('marketing.company.handbook.shipping') }} words</p>
    </div>
    <div class="flex items-center justify-between pl-6">
      <a href="{{ route('marketing.company.handbook.money') }}" class="text-blue-500 hover:underline">How does this project make money</a>
      <div class="mx-4 flex-grow border-b border-dashed border-gray-800"></div>
      <p class="text-gray-600">{{ \App\Helpers\MarketingHelper::countWords('marketing.company.handbook.money') }} words</p>
    </div>
    <div class="flex items-center justify-between pl-6">
      <a href="{{ route('marketing.company.handbook.why-open-source') }}" class="text-blue-500 hover:underline">Why open source</a>
      <div class="mx-4 flex-grow border-b border-dashed border-gray-800"></div>
      <p class="text-gray-600">{{ \App\Helpers\MarketingHelper::countWords('marketing.company.handbook.why-open-source') }} words</p>
    </div>
    <div class="flex items-center justify-between pl-6">
      <a href="{{ route('marketing.company.handbook.where') }}" class="text-blue-500 hover:underline">Where am I going with this</a>
      <div class="mx-4 flex-grow border-b border-dashed border-gray-800"></div>
      <p class="text-gray-600">{{ \App\Helpers\MarketingHelper::countWords('marketing.company.handbook.where') }} words</p>
    </div>
    <div class="flex items-center justify-between">
      <p class="font-semibold">Marketing</p>
      <div class="ml-4 flex-grow border-b border-dashed border-gray-800"></div>
    </div>
    <div class="flex items-center justify-between pl-6">
      <a href="{{ route('marketing.company.handbook.marketing.envision') }}" class="text-blue-500 hover:underline">How do I envision marketing</a>
      <div class="mx-4 flex-grow border-b border-dashed border-gray-800"></div>
      <p class="text-gray-600">{{ \App\Helpers\MarketingHelper::countWords('marketing.company.handbook.marketing') }} words</p>
    </div>
    <div class="flex items-center justify-between pl-6">
      <a href="{{ route('marketing.company.handbook.marketing.social-media') }}" class="text-blue-500 hover:underline">Social media</a>
      <div class="mx-4 flex-grow border-b border-dashed border-gray-800"></div>
      <p class="text-gray-600">{{ \App\Helpers\MarketingHelper::countWords('marketing.company.handbook.social-media') }} words</p>
    </div>
    <div class="flex items-center justify-between pl-6">
      <a href="{{ route('marketing.company.handbook.marketing.writing') }}" class="text-blue-500 hover:underline">Writing for PeopleOS</a>
      <div class="mx-4 flex-grow border-b border-dashed border-gray-800"></div>
      <p class="text-gray-600">{{ \App\Helpers\MarketingHelper::countWords('marketing.company.handbook.writing') }} words</p>
    </div>
    <div class="flex items-center justify-between pl-6">
      <a href="{{ route('marketing.company.handbook.marketing.product-philosophy') }}" class="text-blue-500 hover:underline">Product philosophy</a>
      <div class="mx-4 flex-grow border-b border-dashed border-gray-800"></div>
      <p class="text-gray-600">{{ \App\Helpers\MarketingHelper::countWords('marketing.company.handbook.product-philosophy') }} words</p>
    </div>
    <div class="mb-10 flex items-center justify-between pl-6">
      <a href="{{ route('marketing.company.handbook.marketing.prioritize') }}" class="text-blue-500 hover:underline">How do we prioritize features?</a>
      <div class="mx-4 flex-grow border-b border-dashed border-gray-800"></div>
      <p class="text-gray-600">{{ \App\Helpers\MarketingHelper::countWords('marketing.company.handbook.prioritize') }} words</p>
    </div>

    <div>
      <x-marketing-page-widget :marketing-page="$marketingPage" :view-name="$viewName" />
    </div>
  </div>
</x-marketing-handbook-layout>
