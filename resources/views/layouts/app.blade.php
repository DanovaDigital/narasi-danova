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

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-900">
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