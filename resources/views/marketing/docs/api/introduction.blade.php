<x-marketing-docs-layout>
  <h1 class="mb-6 text-2xl font-bold">API reference</h1>

  <div class="mb-10 grid grid-cols-1 gap-6 border-b border-gray-200 pb-10 sm:grid-cols-2">
    <div>
      <p class="mb-2">The PeopleOS API is organized around REST. Our API has predictable resource-oriented URLs.</p>
      <p class="mb-2">You can not use the PeopleOS API in test mode. This means all requests will be processed towards your production account. Please be cautious.</p>
      <p>The PeopleOS API doesn’t support bulk updates. You can work on only one object per request.</p>
    </div>

    <div>
      <h2 class="mb-2 text-lg font-bold">Base URL</h2>
      <x-marketing.code>{{ config('app.url') }}/api</x-marketing.code>
    </div>
  </div>

  <div class="mb-10 border-b border-gray-200 pb-10 sm:grid-cols-2">
    <h3 id="test-the-api-yourself" class="mb-2 text-lg font-bold">Test the API yourself</h3>
    <p class="mb-2">
      If you want to test the API yourself, we provide a
      <a href="https://yaak.app/" target="_blank" class="text-blue-500 hover:underline">Yaak collection</a>
      for you to use, as a workspace.
    </p>
    <p class="mb-2">
      The documentation is included in the Github repository, under the
      <a href="https://github.com/djaiss/peopleOS/tree/main/docs/yaak" target="_blank" class="text-blue-500 hover:underline">docs/yaak</a>
      folder.
    </p>
    <p>Why Yaak? Because it's a fresh, new approach to API clients, it's free and open source under the MIT license, and I really like the ethos of the main developer. You should give it a try.</p>
  </div>

  <div>
    <x-marketing.edit-github />
  </div>
</x-marketing-docs-layout>
