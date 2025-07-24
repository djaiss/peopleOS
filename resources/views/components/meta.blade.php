<link rel="icon" type="image/x-icon" href="{{ asset('favicon.png') }}" />

<!-- Android -->
<link rel="manifest" href="{{ asset('site.webmanifest') }}" />

<!-- iOS -->
<meta name="apple-mobile-web-app-title" content="PeopleOS" />
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}" />

<!-- Safari pinned tab -->
<link rel="mask-icon" href="{{ asset('safari-pinned-tab.svg') }}" color="#5bbad5" />

<title>{{ config('app.name', 'PeopleOS') }}</title>
<meta name="description" content="PeopleOS is a software to document your life and relationships." />

<link rel="canonical" href="{{ url()->current() }}" />
