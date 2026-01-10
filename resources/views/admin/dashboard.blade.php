<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Dashboard - {{ config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-semibold">Admin Dashboard</h1>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button class="bg-gray-900 text-white px-4 py-2 rounded" type="submit">Logout</button>
            </form>
        </div>

        <div class="bg-white border rounded p-6">
            <p class="text-gray-700">Selamat datang, {{ auth('admin')->user()->name }}.</p>
            <p class="text-gray-600 mt-2">Mulai kelola konten di menu Articles.</p>
            <div class="mt-4">
                <a class="text-blue-600 underline" href="{{ route('admin.articles.index') }}">Kelola Articles</a>
            </div>
        </div>
    </div>
</body>

</html>