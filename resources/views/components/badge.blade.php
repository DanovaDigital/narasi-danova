@props([
'variant' => 'default', // default, primary, success, warning, danger, info
'size' => 'md', // sm, md, lg
])

@php
$variantClasses = match($variant) {
'primary' => 'bg-primary-100 text-primary-700',
// Keep variants for API-compatibility, but style them more neutral to avoid overly colorful UI.
'success' => 'bg-gray-100 text-gray-700',
'warning' => 'bg-gray-100 text-gray-700',
'danger' => 'bg-primary-100 text-primary-700',
'info' => 'bg-gray-100 text-gray-700',
default => 'bg-gray-100 text-gray-700',
};

$sizeClasses = match($size) {
'sm' => 'px-2 py-0.5 text-xs',
'lg' => 'px-4 py-1.5 text-sm',
default => 'px-3 py-1 text-xs',
};
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center rounded-full font-semibold $variantClasses $sizeClasses"]) }}>
    {{ $slot }}
</span>