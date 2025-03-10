<x-marketing-handbook-layout>
  <h1 class="mb-6 text-2xl font-bold">Our handbook</h1>

  <p class="mb-6">This handbook explains what I do, how I think and how I want to move this project forward. Brace yourself, it's very good. At least I think so.</p>

  <div class="flex flex-col gap-y-4">
    <div class="flex items-center justify-between">
      <p class="font-semibold">General information</p>
      <div class="border-b border-dashed border-gray-800 flex-grow mx-4"></div>
      <p class="text-gray-600">{{ \App\Helpers\MarketingHelper::countWords('marketing.company.handbook.index') }} words</p>
    </div>
    <div class="flex items-center justify-between">
      <p class="font-semibold">Marketing</p>
      <div class="border-b border-dashed border-gray-800 flex-grow mx-4"></div>
      <p class="text-gray-600">{{ \App\Helpers\MarketingHelper::countWords('marketing.company.handbook.index') }} words</p>
    </div>
    <div class="flex items-center justify-between">
      <p class="font-semibold">Product management</p>
      <div class="border-b border-dashed border-gray-800 flex-grow mx-4"></div>
      <p class="text-gray-600">{{ \App\Helpers\MarketingHelper::countWords('marketing.company.handbook.index') }} words</p>
    </div>
    <div class="flex items-center justify-between">
      <p class="font-semibold">Support</p>
      <div class="border-b border-dashed border-gray-800 flex-grow mx-4"></div>
      <p class="text-gray-600">{{ \App\Helpers\MarketingHelper::countWords('marketing.company.handbook.index') }} words</p>
    </div>
    <div class="flex items-center justify-between">
      <p class="font-semibold">Sales</p>
      <div class="border-b border-dashed border-gray-800 flex-grow mx-4"></div>
      <p class="text-gray-600">{{ \App\Helpers\MarketingHelper::countWords('marketing.company.handbook.index') }} words</p>
    </div>
    <div class="flex items-center justify-between">
      <p class="font-semibold">Development</p>
      <div class="border-b border-dashed border-gray-800 flex-grow mx-4"></div>
      <p class="text-gray-600">{{ \App\Helpers\MarketingHelper::countWords('marketing.company.handbook.index') }} words</p>
    </div>

  <div>
    <x-marketing.edit-github />
  </div>

  </div>
</x-marketing-handbook-layout>
