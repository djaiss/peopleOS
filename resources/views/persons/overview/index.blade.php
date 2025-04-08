<?php
/*
 * @var Person $person
 * @var array $encounters
 */
?>

<h1 class="font-semi-bold mb-4 text-2xl">
  {{ __('Overview') }}
</h1>

@include(
  'persons.overview.partials.information',
  [
    'person' => $person,
  ]
)

@include(
  'persons.overview.partials.physical-apperance',
  [
    'person' => $person,
    'physicalAppearance' => $physicalAppearance,
  ]
)

@include(
  'persons.overview.partials.how-we-met',
  [
    'person' => $person,
  ]
)

@include(
  'persons.overview.partials.encounters',
  [
    'person' => $person,
    'encounters' => $encounters,
  ]
)
