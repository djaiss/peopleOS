@props(['with_comma' => false])

<div class="pl-8">{</div>
<div class="pl-12">
  "type":
  <span class="text-lime-700">"gender"</span>
  ,
</div>
<div class="pl-12">
  "id":
  <span class="text-rose-800">"1"</span>
  ,
</div>
<div class="pl-12">"attributes": {</div>
<div class="pl-16">
  "name":
  <span class="text-lime-700">"Man"</span>
  ,
</div>
<div class="pl-16">
  "position":
  <span class="text-rose-800">1</span>
  ,
</div>
<div class="pl-16">
  "created_at":
  <span class="text-rose-800">1746615348</span>
  ,
</div>
<div class="pl-16">
  "updated_at":
  <span class="text-gray-500">null</span>
</div>
<div class="pl-12">},</div>
<div class="pl-12">"links": {</div>
<div class="pl-16">
  "self":
  <span class="text-lime-700">"{{ config('app.url') }}/api/administration/genders/1"</span>
</div>
<div class="pl-12">}</div>
<div class="pl-8">
  }
  @if ($with_comma)
    ,
  @endif
</div>
