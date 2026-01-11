<!DOCTYPE html>
@php
$lang = str_replace('_', '-', app()->getLocale());
if ($lang === 'id') {
$lang = 'id-ID';
}
@endphp
<html lang="{{ $lang }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @php
    $titleFromStack = trim($__env->yieldPushContent('title'));
    $siteName = config('app.name', 'Laravel');
    $seoFromStack = trim($__env->yieldPushContent('seo'));
    @endphp

    <title>{{ $titleFromStack !== '' ? $titleFromStack : $siteName }}</title>

    @if ($seoFromStack !== '')
    {!! $seoFromStack !!}
    @else
    <x-seo-default :site-name="$siteName" robots="noindex, nofollow" />
    @endif

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Merriweather:ital,opsz,wght@0,6..12,300..900;1,6..12,300..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-dark antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-paper">
        <div>
            <a href="/" class="flex items-center gap-3">
                <span class="font-display text-3xl font-bold text-dark">Narasi<span class="text-brand-600">.</span></span>
            </a>
        </div>

        <div class="w-full sm:max-w-md mt-8 px-8 py-8 bg-white shadow-soft overflow-hidden rounded-2xl">
            {{ $slot }}
        </div>
    </div>
</body>

</html>