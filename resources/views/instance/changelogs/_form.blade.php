<?php
/*
 * Shared form partial for create/edit changelog
 * @var App\Models\Changelog|null $changelog
 */
?>
@php
  $isEdit = isset($changelog);
@endphp

<div class="space-y-6">
  <div>
    <label class="block text-sm font-medium text-gray-700" for="pull_request_url">{{ __('Pull request URL') }}</label>
    <input type="url" name="pull_request_url" id="pull_request_url" value="{{ old('pull_request_url', $changelog->pull_request_url ?? '') }}" class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required />
    @error('pull_request_url')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
  </div>

  <div>
    <label class="block text-sm font-medium text-gray-700" for="title">{{ __('Title') }}</label>
    <input type="text" name="title" id="title" value="{{ old('title', $changelog->title ?? '') }}" class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required />
    @error('title')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
  </div>

  <div>
    <label class="block text-sm font-medium text-gray-700" for="slug">{{ __('Slug (optional)') }}</label>
    <input type="text" name="slug" id="slug" value="{{ old('slug', $changelog->slug ?? '') }}" class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
    @error('slug')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
  </div>

  <div>
    <label class="block text-sm font-medium text-gray-700" for="description">{{ __('Description (Markdown)') }}</label>
    <textarea name="description" id="description" rows="8" class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>{{ old('description', $changelog->description ?? '') }}</textarea>
    @error('description')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
  </div>

  <div>
    <label class="block text-sm font-medium text-gray-700" for="published_at">{{ __('Publish date (leave empty for draft)') }}</label>
    <input type="datetime-local" name="published_at" id="published_at" value="{{ old('published_at', isset($changelog->published_at) ? $changelog->published_at?->format('Y-m-d\\TH:i') : '') }}" class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
    @error('published_at')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
  </div>

  <div class="flex items-center justify-end gap-3">
    <a href="{{ route('instance.changelog.index') }}" class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">{{ __('Cancel') }}</a>
    <button type="submit" class="inline-flex items-center rounded-md border border-blue-600 bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700">
      {{ $isEdit ? __('Update changelog') : __('Create changelog') }}
    </button>
  </div>
</div>
