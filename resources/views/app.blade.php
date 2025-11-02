<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title inertia>{{ config('app.title', 'iewa') }}</title>
    <meta name="description" content="ایوا | Iewa — سفارش غذا، منو، ارتباط با ما." />
    <meta name="keywords" content="ایوا, Iewa, سفارش غذا, غذای سالم, منوی غذا, اصفهان, غذای سازمانی, کترینگ" />
    <meta name="author" content="ایوا">
    <link rel="canonical" href="{{ url()->current() }}" />

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:title" content="{{ config('app.title', 'Iewa') }}" />
    <meta property="og:description" content="ایوا | Iewa — سفارش غذا، منو، ارتباط با ما." />
    <meta property="og:site_name" content="{{ config('app.name', 'Iewa') }}" />
    <meta property="og:locale" content="fa_IR" />
    <meta property="og:image" content="{{ url('/images/icon.png') }}" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="630" />

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="{{ config('app.title', 'Iewa') }}" />
    <meta name="twitter:description" content="ایوا | Iewa — سفارش غذا، منو، ارتباط با ما." />
    <meta name="twitter:image" content="{{ url('/images/icon.png') }}" />

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ url('/favicon.png') }}" />
    <link rel="apple-touch-icon" href="{{ url('/apple-touch-icon.png') }}" />

    @vite('resources/js/app.ts')
    @inertiaHead
</head>
<body class="font-sans antialiased">
    @inertia
</body>
</html>
