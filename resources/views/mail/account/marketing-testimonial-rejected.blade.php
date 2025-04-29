<x-mail::message>
# Your testimonial has been rejected

Thank you for having submitted your testimonial. Unfortunately, we've had to reject it for the following reason:

<x-mail::panel>
{{ $reason }}
</x-mail::panel>

Really sorry about this. You can always submit a new testimonial if you would like to support the product.

Thanks again and have a great day,<br>
{{ config('app.name') }}
</x-mail::message>
