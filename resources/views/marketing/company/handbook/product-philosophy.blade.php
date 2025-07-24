<?php
/*
 * @var array $stats
 * @var \App\Models\MarketingPage $marketingPage
  * @var string $viewName
 */
?>

{{-- @llms-title: Product philosophy --}}
{{-- @llms-description: Product philosophy --}}
{{-- @llms-route: /company/handbook/product-philosophy --}}
<x-marketing-handbook-layout :marketing-page="$marketingPage" :view-name="$viewName">
  <x-slot name="breadcrumb">
    <a href="{{ route('marketing.index') }}" class="text-blue-500 hover:underline">{{ __('Home') }}</a>
    <span class="text-gray-500">&gt;</span>
    <a href="{{ route('marketing.company.index') }}" class="text-blue-500 hover:underline">{{ __('Company') }}</a>
    <span class="text-gray-500">&gt;</span>
    <a href="{{ route('marketing.company.handbook.index') }}" class="text-blue-500 hover:underline">{{ __('Handbook') }}</a>
    <span class="text-gray-500">&gt;</span>
    <span class="text-gray-600">{{ __('Product philosophy') }}</span>
  </x-slot>

  <h1 class="mb-6 text-2xl font-bold">Product philosophy</h1>

  <div class="prose">
    <p class="mb-2">A product should be simple to use. Users should never have to look for help to do something. That being said, a link to the help center should be present on every screen in order to assist users if, unfortunately, the UI is not clear enough.</p>

    <p class="mb-2">We should always iterate. The first version of a feature should be an embarrassing but very functional solution to a problem or a need. Then, using a fast-paced build-measure-learn feedback loop, we can create a better version.</p>

    <p class="mb-2">We should always start with the problem, not the solution. We should focus on well-formed problem statements in order to understand the core of the issues faced by the user. Only after a long process of thought can we fully get the big picture and envision the solution.</p>

    <p class="mb-2">
      As much as possible, you should resist adding configuration options or settings. It's much better to have smart defaults than to pollute the product with options. Every option adds complexity in terms of engineering, testing, and understanding. One of the personality traits of a project maintainer is to please people. We want users to love what we've spent nights and years creating. So, every time we receive a feature request, it's only natural to try to implement this feature, especially if it's about an option, so we give users a choice. This is not a good strategy. We should resist, as much as possible, creating a situation where your product is so complex that it has become unmaintainable. 37Signals has a great article about
      <a href="https://basecamp.com/gettingreal/05.3-start-with-no" class="text-blue-500 hover:underline">saying no</a>
      . Read this.
    </p>

    <p class="mb-10">Finally, we will never implement a feature that removes the need to make an effort in maintaining healthy relationships. What do I mean by that? Having a social circle requires time and effort. There is no easy way to have great relationships. PeopleOS will help you document but it won't replace the need to, you know, actually work on your relationships.</p>
  </div>

  <div>
    <x-marketing-page-widget :marketing-page="$marketingPage" :view-name="$viewName" />
  </div>

  <x-slot name="rightSidebar">
    <x-marketing.handbook-stats :stats="$stats" />
  </x-slot>
</x-marketing-handbook-layout>
