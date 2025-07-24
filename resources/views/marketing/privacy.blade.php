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
        <h1 class="mb-10 text-center text-3xl font-normal tracking-tight text-gray-900 sm:text-4xl">Privacy policy</h1>

        <div class="mb-10 flex justify-center">
          <x-image src="{{ asset('marketing/privacy.webp') }}" alt="PeopleOS privacy policy" width="600" height="188" srcset="{{ asset('marketing/privacy.webp') }} 1x, {{ asset('marketing/privacy@2x.webp') }} 2x" />
        </div>

        <div class="flex max-w-none flex-col gap-y-4">
          <p class="">PeopleOS is an open-source project. The hosted version has a premium plan that lets us collect money so we can pay for the servers and additional services, but the main goal is not to make money (otherwise we wouldn't have open-sourced it).</p>

          <p class="">PeopleOS comes in two flavors: you can either use our hosted version, or download it and run it yourself. In the latter case, we do not track anything at all. We don't know that you've even downloaded the product. Do whatever you want with it (but respect your local laws).</p>

          <p class="">When you create your account on our hosted version, you are giving the site information about yourself that we collect. This includes your name, your email address and your password, that is encrypted before being stored. We do not store any other personal information.</p>

          <p class="">When you login to the service, we are using cookies to remember your login credentials. This is the only purpose of the cookies.</p>

          <p class="">
            PeopleOS runs on
            <a href="https://cloud.laravel.com" target="_blank" class="text-blue-500 hover:underline">Laravel Cloud</a>
            and we are the only ones, apart from Laravel's employees, who have access to those servers. Laravel Cloud's servers are, like everything on Internet, powered by AWS.
          </p>

          <p class="">We do hourly backups of the database.</p>

          <p class="">Your password is encrypted with bcrypt, a password hashing algorithm that is highly secure. You can also activate two factor authentication on your account if you need an extra layer of security. Apart from those encryption mechanisms, your data is encrypted in the database. If someone gets access to the database, they will not be able to read your data, unless they have the encryption key, which resides on Laravel Cloud's servers. We do our best to make sure that this never happens, but it can happen.</p>

          <p class="">If a data breach happens, we will contact the users who are affected to warn them about the breach.</p>

          <p class="">Transactional emails are served through Resend.</p>

          <p class="">
            We use an open-source tool called
            <a href="https://nightwatch.laravel.com" target="_blank" class="text-blue-500 hover:underline">Laravel Nightwatch</a>
            to track errors that happen in production. Their service records the errors, but they don't have access to any information apart from the account ID, which lets me debug what's going on.
          </p>

          <p class="">The site does not currently and will never show ads. It also does not, and don't intend to, sell data to a third party, with or without your consent. We are just against this. Fuck ads.</p>

          <p class="">We do not use any tracking third parties, like Google Analytics or Intercom, that track user behaviours or data, neither on the marketing site or the hosted version. We are deeply against their principles as they would use those data to profile you, which we are totally against.</p>

          <p class="">All the data you put on PeopleOS belongs to you. This includes all the information about people you document, your journal entries, reminders, gifts, and any other personal data you store. We do not have any rights on it. Please don't put illegal stuff on it, otherwise we'd be in trouble.</p>

          <p class="">All the information about the people you document on PeopleOS are private to you. We do not cross link information between accounts or use one information in an account to populate another account (unlike Facebook for instance). Your personal CRM data stays completely isolated to your account.</p>

          <p class="">We use Stripe to collect payments made to access the paid version. We do not store credit card information or anything concerning the transactions themselves on our servers. However, as per the open-source library we use to process the payments (Laravel Cashier), we store the last 4 digits of the credit card, the brand name (VISA or MasterCard). As a user, you are identified on Stripe by a random number that they generate and use.</p>

          <p class="">Regarding the payments, there is a one-time fee to access the paid version. Therefore, you can not downgrade to the free plan once it's paid. The less we deal with payment information, the happier we are. Morevoer, we ask you three times before upgrading to the paid version, in order to make sure you are not doing it by mistake.</p>

          <p class="">You can not export your data at the moment.</p>

          <p class="">When you close your account, we immediately destroy all your personal information from the production database, but your information is kept in the backups that we keep for 30 days. After 30 days, your information will be completely destroyed. While you have control over this, we can delete an account for you if you ask us.</p>

          <p class="">In certain situations, we may be required to disclose personal data in response to lawful requests by public authorities, including to meet national security or law enforcement requirements. We just hope that this never happens.</p>

          <p class="">If you violate the terms of use we will terminate your account and notify you about it. However if you follow the "don't be a dick" policy, nothing should ever happen to you and we'll all be happy.</p>

          <p class="">PeopleOS uses only open-source projects that are mainly hosted on Github.</p>
        </div>
      </div>
    </div>
  </div>
</x-marketing-layout>
