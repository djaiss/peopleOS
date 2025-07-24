<?php
/*
 * @var \App\Models\MarketingPage $marketingPage
 * @var string $viewName
 */
?>

<x-marketing-layout :marketing-page="$marketingPage" :view-name="$viewName">
  <div class="bg-gray-50 py-12">
    <div class="mx-auto max-w-7xl px-6 lg:px-8 xl:px-0">
      <div class="mx-auto max-w-2xl">
        <h1 class="mb-10 text-center text-3xl font-normal tracking-tight text-gray-900 sm:text-4xl">Terms of use</h1>

        <div class="mb-10 flex justify-center">
          <x-image src="{{ asset('marketing/terms.webp') }}" alt="PeopleOS terms of use" width="600" height="188" srcset="{{ asset('marketing/terms.webp') }} 1x, {{ asset('marketing/terms@2x.webp') }} 2x" />
        </div>

        <div class="flex max-w-none flex-col gap-y-4">
          <h2 class="text-xl font-semibold text-gray-900">Scope of service</h2>

          <p class="">PeopleOS supports the following browsers:</p>

          <ul class="list-disc space-y-1 pl-6">
            <li>Firefox (140+)</li>
            <li>Chrome (latest)</li>
            <li>Safari (latest)</li>
          </ul>

          <p class="">I do not guarantee that the site will work with other browsers, but it's very likely that it will just work.</p>

          <h2 class="text-xl font-semibold text-gray-900">Rights</h2>

          <p class="">You don't have to provide your real name when you register to an account. You do however need a valid email address if you want to upgrade your account to the paid version, or receive reminders by email.</p>

          <p class="">You have the right to close your account at any time.</p>

          <p class="">Your data will not be intentionally shown to other users or shared with third parties.</p>

          <p class="">Your personal data will not be shared with anyone without your consent.</p>

          <p class="">Your data is backed up every hour.</p>

          <p class="">If the site ceases operation, you will receive an opportunity to export all your data before the site dies.</p>

          <p class="">Any new features that affect privacy will be strictly opt-in.</p>

          <h2 class="text-xl font-semibold text-gray-900">Responsibilities</h2>

          <p class="">You will not use the site to store illegal information or data under the Canadian law (or any law).</p>

          <p class="">You have to be at least 18+ to create an account and use the site.</p>

          <p class="">You must not abuse the site by knowingly posting malicious code that could harm you or the other users.</p>

          <p class="">You must only use the site to do things that are widely accepted as morally good.</p>

          <p class="">You may not make automated requests to the site.</p>

          <p class="">You may not abuse the invitation system.</p>

          <p class="">You are responsible for keeping your account secure.</p>

          <p class="">I reserve the right to close accounts that abuse the system (thousands of people with hundred of thousands of reminders for instance) or use it in an unreasonable manner.</p>

          <h2 class="text-xl font-semibold text-gray-900">Other important legal stuff</h2>

          <p class="">Though I want to provide a great service, there are certain things about the service I cannot promise. For example, the services and software are provided "as-is", at your own risk, without express or implied warranty or condition of any kind. I also disclaim any warranties of merchantability, fitness for a particular purpose or non-infringement. PeopleOS will have no responsibility for any harm to your computer system, loss or corruption of data, or other harm that results from your access to or use of the Services or Software.</p>

          <p class="">These Terms can change at any time, but I'll never be a dick about it. Running this site is a dream come true to me, and I hope I'll be able to run it as long as I can.</p>
        </div>
      </div>
    </div>
  </div>
</x-marketing-layout>
