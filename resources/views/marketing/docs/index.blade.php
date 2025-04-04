<?php
/*
 * @var \App\Models\MarketingPage $marketingPage
 * @var string $viewName
 */
?>

<x-marketing-docs-layout :marketing-page="$marketingPage" :view-name="$viewName">
  <h1 class="mb-6 text-2xl font-bold">Index</h1>

  <div>
    <x-marketing-page-widget :marketing-page="$marketingPage" />
  </div>
</x-marketing-docs-layout>
