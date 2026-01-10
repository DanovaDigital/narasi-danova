<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Login - {{ config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen flex items-center justify-center bg-gray-50">
    <div class="w-full max-w-md bg-white border rounded p-6">
        <h1 class="text-xl font-semibold mb-4">Admin Login</h1>

        @if($errors->any())
        <div class="mb-4 text-red-600 text-sm">
            {{ $errors->first() }}
        </div>
        @endif

        <form method="POST" action="{{ route('admin.login.post') }}">
            @csrf

            <div class="mb-3">
                <label class="block text-sm font-medium mb-1" for="email">Email</label>
                <input id="email" name="email" type="email" class="w-full border rounded px-3 py-2" value="{{ old('email') }}" required autofocus>
            </div>

            <div class="mb-3">
                <label class="block text-sm font-medium mb-1" for="password">Password</label>
                <input id="password" name="password" type="password" class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label class="inline-flex items-center gap-2 text-sm">
                    <input type="checkbox" name="remember" class="border rounded">
                    Remember me
                </label>
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white rounded px-4 py-2">Login</button>
        </form>
    </div>
</body>

</html>