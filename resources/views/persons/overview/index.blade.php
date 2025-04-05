<?php
/*
 * @var Person $person
 * @var array $encounters
 */
?>

<h1 class="font-semi-bold mb-4 text-2xl">
  {{ __('Overview') }}
</h1>

@include('persons.overview.partials.information')

@include('persons.overview.partials.physical-apperance')

@include('persons.overview.partials.how-we-met')

@include('persons.overview.partials.encounters')
