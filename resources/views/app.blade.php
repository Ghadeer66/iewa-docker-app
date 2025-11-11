<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title inertia>{{ config('app.title', 'ایوا') }}</title>
    <meta name="description" content="ایوا | سفارش آنلاین غذای سالم و مغذی برای سازمان‌ها. منوی متنوع سالاد، ساندویچ، صبحانه و میانوعده با تخفیف هفتگی/ماهانه، سوبسید شرکتی و تحویل سریع. غذای سالم، تازه و مقرون‌به‌صرفه در اصفهان!" />
    <meta name="keywords" content="ایوا, Iewa, سفارش غذا, غذای سالم, منوی غذا, اصفهان, غذای سازمانی, کترینگ" />
    <meta name="author" content="ایوا">
    <link rel="canonical" href="{{ url()->current() }}" />

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:title" content="{{ config('app.title', 'ایوا') }}" />
    <meta property="og:description" content="ایوا | سفارش آنلاین غذای سالم و مغذی برای سازمان‌ها. منوی متنوع سالاد، ساندویچ، صبحانه و میانوعده با تخفیف هفتگی/ماهانه، سوبسید شرکتی و تحویل سریع. غذای سالم، تازه و مقرون‌به‌صرفه در اصفهان!" />
    <meta property="og:site_name" content="{{ config('app.name', 'ایوا') }}" />
    <meta property="og:locale" content="fa_IR" />
    <meta property="og:image" content="{{ url('/images/icon.png') }}" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="630" />

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="{{ config('app.title', 'ایوا') }}" />
    <meta name="twitter:description" content="ایوا | سفارش آنلاین غذای سالم و مغذی برای سازمان‌ها. منوی متنوع سالاد، ساندویچ، صبحانه و میانوعده با تخفیف هفتگی/ماهانه، سوبسید شرکتی و تحویل سریع. غذای سالم، تازه و مقرون‌به‌صرفه در اصفهان!" />
    <meta name="twitter:image" content="{{ url('/images/icon.png') }}" />

    <!-- Favicon (Enhanced - use files from /public/favicon/) -->
    <link rel="icon" type="image/x-icon" href="{{ url('/favicon.ico') }}"> <!-- Primary ICO for Google/IE (root) -->
    <!-- fall back to available sizes under /favicon/ -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ url('/favicon/favicon-96x96.png') }}"> <!-- fallback PNG -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ url('/favicon/favicon-96x96.png') }}"> <!-- fallback PNG -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ url('/favicon/apple-touch-icon.png') }}"> <!-- iOS Safari -->
    <link rel="manifest" href="{{ url('/favicon/site.webmanifest') }}"> <!-- PWA Manifest (optional) -->

    @vite('resources/js/app.ts')
    @inertiaHead
</head>
<body class="font-sans antialiased">
    @inertia
</body>
</html>
