<?php
/*
 * @var array $stats
 */
?>

<x-marketing-handbook-layout>
  <x-slot name="breadcrumb">
    <a href="{{ route('marketing.index') }}" class="text-blue-500 hover:underline">{{ __('Home') }}</a>
    <span class="text-gray-500">&gt;</span>
    <a href="{{ route('marketing.company.index') }}" class="text-blue-500 hover:underline">{{ __('Company') }}</a>
    <span class="text-gray-500">&gt;</span>
    <a href="{{ route('marketing.company.handbook.index') }}" class="text-blue-500 hover:underline">{{ __('Handbook') }}</a>
    <span class="text-gray-500">&gt;</span>
    <span class="text-gray-600">{{ __('How do I envision marketing') }}</span>
  </x-slot>

  <h1 class="mb-6 text-2xl font-bold">How do I envision marketing</h1>

  <div class="prose">
    <p class="mb-2">Marketing has bad press. I used to hate marketing. Trying to find ways to sell a crappy product is why marketing has such a bad press. However, when you do create a product that you truly think will benefit a lot of people, you want the world to know. So how can you do that?</p>

    <p class="mb-2">I still hate marketing by the way. But I hate because I'm bad at it, not because it's a bad practice per se.</p>

    <p class="mb-2">For people like me, solo developers who prefer to code a feature than writing content or promoting it, I'd say that marketing is about writing about the product and nothing else. Let the product do the work for you. Promote it inside the product itself, and on your social platforms, and that's it.</p>

    <p class="mb-2">We will never say things like "PeopleOS is the best way to...". No. It's not the best, not the first, not the only. PeopleOS is humble. It lets you do one thing well (ie document your life). It's not a revolution. It's a useful tool for a very specific set of people.</p>

    <p class="mb-2">This is why I'll never write blog posts about crappy inspirational things just for the SEO and written by AI. Blog posts will be about the product and things I care about, nothing else. Just the thought of having to do a keyword analysis depresses me.</p>

    <p class="mb-10">I'll do what you should probably not do. I'll do marketing as if I was the user target.</p>
  </div>

  <div>
    <x-marketing.edit-github />
  </div>

  <x-slot name="rightSidebar">
    <x-marketing.handbook-stats :stats="$stats" />
  </x-slot>
</x-marketing-handbook-layout>
