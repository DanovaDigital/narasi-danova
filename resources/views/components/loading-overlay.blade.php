{{--
    Loading Overlay Component
    
    Standalone usage (not recommended, use pageLoader in app.blade.php instead):
    <x-loading-overlay :show="true" />
    
    With Alpine.js:
    <div x-data="{ loading: false }">
        <button @click="loading = true">Load</button>
        <x-loading-overlay x-bind:show="loading" />
    </div>
    
    Note: Global page loader is already integrated in layouts/app.blade.php
--}}

@props([
'show' => false,
])

<div x-data="{ show: @js($show) }"
    x-show="show"
    x-cloak
    class="fixed inset-0 z-[100] flex items-center justify-center bg-white/80 backdrop-blur-sm"
    style="display: none;">

    <div class="flex flex-col items-center gap-4">
        <!-- Spinner -->
        <div class="relative h-16 w-16">
            <div class="absolute h-full w-full rounded-full border-4 border-gray-200"></div>
            <div class="absolute h-full w-full animate-spin rounded-full border-4 border-transparent border-t-brand-600"></div>
        </div>

        <!-- Loading Text -->
        <div class="text-center">
            <p class="text-lg font-semibold text-dark">Memuat...</p>
            <p class="mt-1 text-sm text-gray-500">Mohon tunggu sebentar</p>
        </div>
    </div>
</div>