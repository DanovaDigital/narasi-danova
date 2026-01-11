<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
    use App\Models\SiteSetting;
    $siteName = (string) SiteSetting::getValue('site_name', config('app.name', 'Laravel'));
    @endphp

    <title>{{ $siteName }}</title>

    @stack('head')

    <!-- Google Fonts - Editorial Typography -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;500;600;700&family=Inter:wght@400;500;600;700&family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Merriweather:ital,wght@0,300;0,400;0,700;1,400&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-paper font-sans text-dark antialiased" x-data="pageLoader">
    <!-- Loading Overlay -->
    <div x-show="loading"
        x-cloak
        class="fixed inset-0 z-[100] flex items-center justify-center bg-white/80 backdrop-blur-sm"
        style="display: none;">
        <div class="flex flex-col items-center gap-4">
            <div class="relative h-16 w-16">
                <div class="absolute h-full w-full rounded-full border-4 border-gray-200"></div>
                <div class="absolute h-full w-full animate-spin rounded-full border-4 border-transparent border-t-brand-600"></div>
            </div>
            <div class="text-center">
                <p class="text-lg font-semibold text-dark">Memuat...</p>
                <p class="mt-1 text-sm text-gray-500">Mohon tunggu sebentar</p>
            </div>
        </div>
    </div>

    @include('layouts.navigation')

    @if (session('success'))
    <div class="mx-auto max-w-7xl px-4 pt-4 sm:px-6 lg:px-8">
        <div class="rounded-md bg-green-50 p-4 text-sm text-green-800">
            {{ session('success') }}
        </div>
    </div>
    @endif

    @if (session('error'))
    <div class="mx-auto max-w-7xl px-4 pt-4 sm:px-6 lg:px-8">
        <div class="rounded-md bg-red-50 p-4 text-sm text-red-800">
            {{ session('error') }}
        </div>
    </div>
    @endif

    @isset($header)
    <header>
        {{ $header }}
    </header>
    @endisset

    <main class="min-h-[70vh]">
        {{ $slot }}
    </main>

    @include('layouts.footer')

    <x-whatsapp-bubble />
</body>

</html>