<?php
/*
 * @var MarketingTestimonial $testimonial
 */
?>

<form id="testimonial-{{ $testimonial['id'] }}-reject-reason" target="testimonials-list" action="{{ route('instance.testimonial.reject', $testimonial->id) }}" method="post" class="mt-4">
  @csrf
  @method('put')

  <textarea name="reason" id="reason" class="mb-4 w-full rounded-md border border-gray-300 p-2"></textarea>

  <button type="submit" class="w-full rounded-md bg-blue-500 p-2 text-white">
    {{ __('Reject') }}
  </button>
</form>
