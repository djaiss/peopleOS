<?php
/*
 * Data come from the MarketingFooterData component
 */
?>

<div>
  @if ($lastModified)
    <p class="text-xs text-gray-500">
      {{ __('This page was last updated on :date, and has been viewed :views times since its creation.', ['date' => $lastModified, 'views' => $pageviews]) }}
    </p>
  @endif
</div>
