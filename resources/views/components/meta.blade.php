<link rel="icon" type="image/x-icon" href="{{ asset('favicon.png') }}" />

<!-- Android -->
<link rel="manifest" href="{{ asset('site.webmanifest') }}" />

<!-- iOS -->
<meta name="apple-mobile-web-app-title" content="PeopleOS" />
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}" />

<!-- Safari pinned tab -->
<link rel="mask-icon" href="{{ asset('safari-pinned-tab.svg') }}" color="#5bbad5" />

<link rel="preconnect" href="https://rsms.me/" crossorigin />
<link rel="preload" href="https://rsms.me/inter/inter.css" as="style" onload="this.onload=null;this.rel='stylesheet'" />
<noscript><link rel="stylesheet" href="https://rsms.me/inter/inter.css" /></noscript>

<style>
  /* Fallback font while Inter loads */
  @font-face {
    font-family: 'Inter';
    font-style: normal;
    font-weight: 400;
    font-display: swap;
  }
</style>

<title>{{ config('app.name', 'Laravel') }}</title>
<meta name="description" content="PeopleOS is a software to document your life and relationships." />
