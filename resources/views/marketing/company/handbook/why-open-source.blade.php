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
    <span class="text-gray-600">{{ __('Why open source') }}</span>
  </x-slot>

  <h1 class="mb-6 text-2xl font-bold">Why open source</h1>

  <div class="prose">
    <p class="mb-2">I have many other open source projects and the same question keeps coming again and again. Why am I crazy enough to release my code as open source, and with a very permissive license at that?</p>

    <p class="mb-2">First of all, most of the commercial projects out there can be replicated in seconds. Most of them don't have a clear competitive advantage. That's not the case for companies like Stripe, of course, but for the vast majority, which are purely CRUD products, yes. My secret sauce is not about the code itself; it's about everything that comes with it: the community, the public image, and the ecosystem.</p>

    <p class="mb-2">Secondly, I strongly believe that I will produce much better code if everyone can take a look at it. When you push code that everyone can read, it puts a kind of pressure on you. Every word out there is a testimony to who you are. So you better make sure that what you put out there is the best it can be and follow what you believe in.</p>

    <p class="mb-2">Thirdly, a product is better when people can contribute to it. Of course, these contributions must be aligned with the values of the project, and its direction. When it does, it's amazing. People from all over the world will fix a bug, improve a feature or add new stuff completely. And since the project is MIT, everyone will benefit from all those changes, forever.</p>

    <p class="mb-2">An open-source project allows for trust and transparency. In the instance I control (i.e., https://peopleos.software), the code that is in the GitHub repository is directly pushed to production without any alteration. When your software is about storing personal information, it's even more essential that you understand how the underlying system works so you can trust the system that stores your precious data.</p>

    <p class="mb-10">Last but not least, open source can be sustained over time by the community, in the event where the founder of the project gets either demotivated or is hit by a bus. In that case, the software will outlive the original founder, and this is a good thing.</p>
  </div>

  <div>
    <x-marketing.edit-github />
  </div>

  <x-slot name="rightSidebar">
    <x-marketing.handbook-stats :stats="$stats" />
  </x-slot>
</x-marketing-handbook-layout>
