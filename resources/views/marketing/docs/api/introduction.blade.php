<x-marketing-docs-layout>
  <h1 class="text-2xl font-bold mb-6">API reference</h1>

  <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
    <div>
      <p class="mb-2">The PeopleOS API is organized around REST. Our API has predictable resource-oriented URLs.</p>
      <p class="mb-2">You can not use the PeopleOS API in test mode. This means all requests will be processed towards your production account. Please be cautious.</p>
      <p class="mb-10">The PeopleOS API doesn’t support bulk updates. You can work on only one object per request.</p>
    </div>
    <div>
      <h2 class="text-lg font-bold mb-2">Base URL</h2>
      <x-marketing.code>{{ config('app.url') }}/api</x-marketing.code>
    </div>
  </div>

  <div>
    <x-marketing.edit-github />
  </div>
</x-marketing-docs-layout>
