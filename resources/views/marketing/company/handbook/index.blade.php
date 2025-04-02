<?php
/*
 * @var string $pageviews
 */
?>

<x-marketing-handbook-layout :pageviews="$pageviews">
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
      <div class="mx-4 flex-grow border-b border-dashed border-gray-800"></div>
      <p class="text-gray-600">{{ \App\Helpers\MarketingHelper::countWords('marketing.company.handbook.index') }} words</p>
    </div>
    <div class="flex items-center justify-between">
      <p class="font-semibold">Product management</p>
      <div class="mx-4 flex-grow border-b border-dashed border-gray-800"></div>
      <p class="text-gray-600">{{ \App\Helpers\MarketingHelper::countWords('marketing.company.handbook.index') }} words</p>
    </div>
    <div class="flex items-center justify-between">
      <p class="font-semibold">Support</p>
      <div class="mx-4 flex-grow border-b border-dashed border-gray-800"></div>
      <p class="text-gray-600">{{ \App\Helpers\MarketingHelper::countWords('marketing.company.handbook.index') }} words</p>
    </div>
    <div class="flex items-center justify-between">
      <p class="font-semibold">Sales</p>
      <div class="mx-4 flex-grow border-b border-dashed border-gray-800"></div>
      <p class="text-gray-600">{{ \App\Helpers\MarketingHelper::countWords('marketing.company.handbook.index') }} words</p>
    </div>
    <div class="mb-10 flex items-center justify-between">
      <p class="font-semibold">Development</p>
      <div class="mx-4 flex-grow border-b border-dashed border-gray-800"></div>
      <p class="text-gray-600">{{ \App\Helpers\MarketingHelper::countWords('marketing.company.handbook.index') }} words</p>
    </div>

    <div>
      <x-marketing.edit-github />
    </div>
  </div>
</x-marketing-handbook-layout>
