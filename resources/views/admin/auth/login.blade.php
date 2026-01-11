<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Login - {{ config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gray-50">
    <div class="flex min-h-screen items-center justify-center px-4 py-12 sm:px-6 lg:px-8">
        <div class="w-full max-w-md">
            {{-- Header --}}
            <div class="text-center">
                <h1 class="mt-6 text-2xl font-bold tracking-tight text-gray-900">Admin Login</h1>
                <p class="mt-2 text-sm text-gray-600">Masukkan kredensial untuk melanjutkan</p>
            </div>

            {{-- Form Card --}}
            <div class="mt-8 rounded-2xl border border-gray-200 bg-white p-8">
                @if($errors->any())
                <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4">
                    <div class="flex items-start gap-3">
                        <svg class="h-5 w-5 flex-shrink-0 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-sm font-medium text-red-800">{{ $errors->first() }}</p>
                    </div>
                </div>
                @endif

                <form method="POST" action="{{ route('admin.login.post') }}" class="space-y-6">
                    @csrf

                    {{-- Secret Credential Field --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-900" for="credential">
                            Secret Credential
                        </label>
                        <div class="mt-2">
                            <input
                                id="credential"
                                name="credential"
                                type="password"
                                class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm transition-all focus:border-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-900/20"
                                value="{{ old('credential') }}"
                                required
                                autofocus>
                        </div>

                    </div>

                    {{-- Submit Button --}}
                    <button
                        type="submit"
                        class="w-full rounded-lg bg-gray-900 px-4 py-3 text-sm font-semibold text-white transition-all hover:bg-gray-800 active:scale-[0.98]">
                        Lanjut ke PIN
                    </button>
                </form>
            </div>

        </div>
    </div>


</body>

</html>