<!-- menu -->
<nav class="mb-10">
  <ul class="flex flex-wrap gap-4 rounded-lg border border-gray-200 bg-white p-2">
    <li>
      <a href="{{ route('instance.index') }}" class="{{ request()->routeIs('instance.index') ? 'bg-gray-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50 hover:text-blue-600' }} flex items-center gap-2 rounded-md px-4 py-2 text-sm font-medium">
        <x-lucide-users class="h-4 w-4" />
        {{ __('User management') }}
      </a>
    </li>
    <li>
      <a href="{{ route('instance.testimonial.index') }}" class="{{ request()->routeIs('instance.testimonial.index') ? 'bg-gray-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50 hover:text-blue-600' }} flex items-center gap-2 rounded-md px-4 py-2 text-sm font-medium">
        <x-lucide-message-square class="h-4 w-4" />
        {{ __('Testimonials management') }}
      </a>
    </li>
    <li>
      <a href="{{ route('instance.cancellation-reasons.index') }}" class="{{ request()->routeIs('instance.cancellation-reasons.index') ? 'bg-gray-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50 hover:text-blue-600' }} flex items-center gap-2 rounded-md px-4 py-2 text-sm font-medium">
        <x-lucide-x-circle class="h-4 w-4" />
        {{ __('Cancellation reasons') }}
      </a>
    </li>
  </ul>
</nav>
