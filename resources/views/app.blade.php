<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    @if (app()->environment('production'))
        <!-- Production assets - Remove APP_URL from asset path -->
        <link rel="stylesheet" href="{{ asset('build/assets/app.css') }}">
        <script type="module" src="{{ asset('build/assets/app.js') }}"></script>
    @else
        <!-- Development assets -->
        @vite('resources/js/app.js')
    @endif

    @inertiaHead
</head>
<body class="font-sans antialiased">
    @inertia
</body>
</html>
