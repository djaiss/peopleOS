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
    <span class="text-gray-600">{{ __('Shipping is better than not shipping') }}</span>
  </x-slot>

  <h1 class="mb-6 text-2xl font-bold">Shipping is better than not shipping</h1>

  <div class="prose">
    <p class="mb-2">What matters most is that the project keeps moving. We should constantly be releasing new features or bug fixes. This is what matters most. Releasing features into production boosts morale at every level.</p>

    <p class="mb-2">It's easy to stop releasing new stuff frequently. It's tempting. You might want to delay a feature because it's not polished enough. Because it's not complete enough. Because if you wait just a little longer to add this animation, or this design, or this behaviour, it'll be better.</p>

    <p class="mb-2">It's a trap. Most users prefer a functional, unpolished feature over one that hasn't been released. It's all about the value you bring. SAAS with lots of VCs funding and lots of designers advocate for the perfect user experience. And are very vocal about spending months on features so it's perfect. Yeah. Sure. They have a gazillion dollars to burn on their craft. I think that generally, design and user experience is greatly overrated. What users truly want is value. If the tool offers good value, users will endure poor interfaces all day long.</p>

    <p class="mb-10">That doesn't mean we don't aim for a good user interface and overall great user experience. But this shouldn't get in the way of launching features in production.</p>
  </div>

  <div>
    <x-marketing.edit-github />
  </div>

  <x-slot name="rightSidebar">
    <x-marketing.handbook-stats :stats="$stats" />
  </x-slot>
</x-marketing-handbook-layout>
