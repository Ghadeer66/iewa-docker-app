<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title inertia>{{ config('app.title', 'iewa') }}</title>
    <meta name="description" content="ایوا | Iewa — سفارش غذا، منو، ارتباط با ما." />
    <link rel="canonical" href="{{ url()->current() }}" />
    <meta property="og:site_name" content="{{ config('app.name', 'Iewa') }}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:title" content="{{ config('app.title', 'Iewa') }}" />
    <meta property="og:description" content="ایوا | Iewa — سفارش غذا، منو، ارتباط با ما." />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="{{ config('app.title', 'Iewa') }}" />
    <meta name="twitter:description" content="ایوا | Iewa — سفارش غذا، منو، ارتباط با ما." />
    @vite('resources/js/app.ts')
    @inertiaHead
</head>
<body class="font-sans antialiased">
    @inertia
</body>
</html>
