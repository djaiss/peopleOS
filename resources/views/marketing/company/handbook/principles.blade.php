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
    <span class="text-gray-600">{{ __('Principles') }}</span>
  </x-slot>

  <h1 class="mb-6 text-2xl font-bold">Principles</h1>

  <div class="prose">
    <h3>Inspiration</h3>
    <p class="mb-2">I’ve been passionate about web products for many years. Even though I’m in my 40s now, I’m trying to stay updated with all the new technologies and things I enjoy. Over the years, I've seen and read many things that have been a huge inspiration.</p>
    <p class="mb-2">Here is a condensed list:</p>
    <ul class="mb-2">
      <li>
        <a href="https://basecamp.com/gettingreal">Getting real</a>
        , from 37signals. Excellent small book on how to create a web application today. Even though it was written more than 10 years ago, it remains more relevant than ever.
      </li>
      <li>
        <a href="https://posthog.com">Posthog</a>
        . Everything they do is genuine, simple and funny. It has been a huge source of inspiration.
      </li>
      <li>
        <a href="https://about.gitlab.com/handbook">Gitlab's handbook</a>
        . Gitlab is a shitty company that treats its employees very badly and take advantage of the community. That being said, their handbook is still a great way to document what's going on in a company.
      </li>
    </ul>

    <h3>Simplicity</h3>
    <p class="mb-2">Things should be simple. Take decisions for the user, and stick with them. You will not create a great product if there are too many options.</p>

    <h3>Openness</h3>
    <p class="mb-10">My own political and ideological considerations have no place in the products I create. Each person's life is different, and I must only consider what I believe is more important than what others think. That is why PeopleOS does not judge and allows users to configure the tool as they wish.</p>
  </div>

  <div>
    <x-marketing.edit-github />
  </div>

  <x-slot name="rightSidebar">
    <x-marketing.handbook-stats :stats="$stats" />
  </x-slot>
</x-marketing-handbook-layout>
