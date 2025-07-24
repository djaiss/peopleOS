<?php
/*
 * @var array $stats
 * @var \App\Models\MarketingPage $marketingPage
 * @var string $viewName
 */
?>

{{-- @llms-title: Project --}}
{{-- @llms-description: Who I am and what is this project --}}
{{-- @llms-route: /company/handbook/project --}}
<x-marketing-handbook-layout :marketing-page="$marketingPage" :view-name="$viewName">
  <x-slot name="breadcrumb">
    <a href="{{ route('marketing.index') }}" class="text-blue-500 hover:underline">{{ __('Home') }}</a>
    <span class="text-gray-500">&gt;</span>
    <a href="{{ route('marketing.company.index') }}" class="text-blue-500 hover:underline">{{ __('Company') }}</a>
    <span class="text-gray-500">&gt;</span>
    <a href="{{ route('marketing.company.handbook.index') }}" class="text-blue-500 hover:underline">{{ __('Handbook') }}</a>
    <span class="text-gray-500">&gt;</span>
    <span class="text-gray-600">{{ __('Who I am and what is this project') }}</span>
  </x-slot>

  <h1 class="mb-6 text-2xl font-bold">Who I am and what is this project</h1>

  <div class="prose">
    <p class="mb-2">PeopleOS is a side project that I've started in Decembre 2024. I worked a lot on another very successful side project called Monica, which I believe was the first personal CRM. After 8 years on this project, I wanted to change and do something different. I think I got completely burned out by Monica, its success in the community, and I let the community down despite them being generally super nice with me.</p>

    <p class="mb-2">My passion, when I get back from my real work (the one that pays the bills), is to code and learn new things every day. This is how I relieve my stress from a challenging day job (which is not about code at all). So even though I stopped working on Monica, I still wanted to code every day.</p>

    <p class="mb-2">I believed my work on Monica was incomplete. I still think we haven't figured out how to effectively document personal lives and share what we know about people we like. So, I started this project as an experiment to solve this puzzle. It's also a way for me to learn new technologies and, more importantly, to explore how far we can push simple technologies to achieve significant results without relying on complex, hard-to-maintain JavaScript frameworks, which I personally don't like at all.</p>

    <p class="mb-2">PeopleOS is a side project. I work a lot on it, but I work on it at night and on the weekend. I try to fix bugs as soon as I see them. I will not implement all the features people want. Do not expect a professionnal, 24/7 support - I don't have the time for this. I try to limitate as much as possible how people can contact me, since it takes so much time otherwise, and I want to decidate my time to working on the product as much as possible.</p>

    <p class="mb-2">I believe in open source. Most of the time, I work on Linux. I use many OSS tools every day. I need to make money to run this project, and also to help justify the (significant) personal time I put into this project, but it's not the driving force behind the project. I like closed source projects too. I'm not a purist. But I use so many open source project that I need to give back somehow. Also, would you trust a closed source project to store this kind of data? Lol.</p>

    <p class="mb-10">I have launched this project for the journey, not the destination. I'm not sure where it will go. I'm not sure if it will be a success. But I'm sure it will be a fun ride.</p>
  </div>

  <div>
    <x-marketing-page-widget :marketing-page="$marketingPage" :view-name="$viewName" />
  </div>

  <x-slot name="rightSidebar">
    <x-marketing.handbook-stats :stats="$stats" />
  </x-slot>
</x-marketing-handbook-layout>
