<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin PIN - {{ config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gray-50">
    <div class="flex min-h-screen items-center justify-center px-4 py-12 sm:px-6 lg:px-8">
        <div class="w-full max-w-md">
            <div class="text-center">
                <h1 class="mt-6 text-2xl font-bold tracking-tight text-gray-900">Masukkan PIN</h1>
                <p class="mt-2 text-sm text-gray-600">PIN wajib 6 digit untuk masuk dashboard</p>
            </div>

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

                <form method="POST" action="{{ route('admin.pin.post') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label class="block text-sm font-semibold text-gray-900">PIN</label>
                        <p class="mt-1 text-xs text-gray-600">Masukkan 6 digit.</p>

                        <input type="hidden" name="pin" id="pin" value="">

                        <div class="mt-3 flex items-center justify-between gap-2" data-pin-root>
                            @for ($i = 0; $i < 6; $i++)
                                <input
                                type="text"
                                inputmode="numeric"
                                pattern="[0-9]*"
                                maxlength="1"
                                autocomplete="one-time-code"
                                class="pin-box block w-12 rounded-lg border border-gray-300 bg-white px-0 py-3 text-center text-lg font-semibold tracking-widest text-gray-900 transition-all focus:border-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-900/20"
                                aria-label="PIN digit {{ $i + 1 }}">
                                @endfor
                        </div>
                    </div>

                    <button
                        type="submit"
                        class="w-full rounded-lg bg-gray-900 px-4 py-3 text-sm font-semibold text-white transition-all hover:bg-gray-800 active:scale-[0.98]">
                        Masuk Dashboard
                    </button>

                    <a href="{{ route('admin.login') }}" class="block text-center text-sm font-medium text-gray-600 hover:text-gray-900">
                        Kembali ke credential
                    </a>
                </form>
            </div>
        </div>
    </div>

    <script>
        (function() {
            const root = document.querySelector('[data-pin-root]');
            const hidden = document.getElementById('pin');
            if (!root || !hidden) return;

            const inputs = Array.from(root.querySelectorAll('input.pin-box'));
            const form = root.closest('form');

            function syncHidden() {
                hidden.value = inputs.map(i => i.value).join('');
            }

            function focusIndex(idx) {
                if (idx < 0 || idx >= inputs.length) return;
                inputs[idx].focus();
                inputs[idx].select();
            }

            inputs.forEach((input, idx) => {
                input.addEventListener('input', (e) => {
                    const v = (e.target.value || '').replace(/\D/g, '');
                    e.target.value = v.slice(-1);
                    syncHidden();
                    if (e.target.value && idx < inputs.length - 1) focusIndex(idx + 1);
                });

                input.addEventListener('keydown', (e) => {
                    if (e.key === 'Backspace' && !input.value && idx > 0) {
                        focusIndex(idx - 1);
                    }
                    if (e.key === 'ArrowLeft') {
                        e.preventDefault();
                        focusIndex(idx - 1);
                    }
                    if (e.key === 'ArrowRight') {
                        e.preventDefault();
                        focusIndex(idx + 1);
                    }
                });

                input.addEventListener('paste', (e) => {
                    const text = (e.clipboardData || window.clipboardData).getData('text') || '';
                    const digits = text.replace(/\D/g, '').slice(0, inputs.length);
                    if (!digits) return;
                    e.preventDefault();
                    digits.split('').forEach((d, i) => {
                        if (inputs[i]) inputs[i].value = d;
                    });
                    syncHidden();
                    focusIndex(Math.min(digits.length, inputs.length - 1));
                });
            });

            form?.addEventListener('submit', (e) => {
                syncHidden();
                if (hidden.value.length !== inputs.length) {
                    e.preventDefault();
                    const firstEmpty = inputs.findIndex(i => !i.value);
                    focusIndex(firstEmpty === -1 ? 0 : firstEmpty);
                }
            });

            setTimeout(() => focusIndex(0), 0);
        })();
    </script>
</body>

</html>