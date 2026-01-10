@php
use App\Models\SiteSetting;

$rawNumber = (string) SiteSetting::getValue('whatsapp_number', '');
$whatsappNumber = preg_replace('/\D+/', '', $rawNumber);
$whatsappMessage = (string) SiteSetting::getValue('whatsapp_message', 'Halo, saya ingin mengajukan berita');

$shouldRender = $whatsappNumber !== '' && strlen($whatsappNumber) >= 8;
$url = $shouldRender
? ('https://wa.me/' . $whatsappNumber . '?text=' . rawurlencode($whatsappMessage))
: null;
@endphp

@if ($url)
<a
    href="{{ $url }}"
    target="_blank"
    rel="noopener noreferrer"
    aria-label="Chat via WhatsApp"
    class="fixed bottom-6 right-6 z-50 inline-flex h-14 w-14 items-center justify-center rounded-full bg-green-500 text-white shadow-lg transition-transform hover:scale-105 hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
    <svg viewBox="0 0 32 32" class="h-7 w-7" fill="currentColor" aria-hidden="true">
        <path
            d="M19.11 17.38c-.3-.15-1.76-.87-2.04-.97-.27-.1-.47-.15-.67.15-.2.3-.77.97-.94 1.17-.17.2-.35.22-.65.07-.3-.15-1.26-.46-2.4-1.47-.89-.8-1.49-1.78-1.67-2.08-.17-.3-.02-.46.13-.61.14-.14.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.02-.52-.07-.15-.67-1.61-.92-2.2-.24-.58-.48-.5-.67-.51h-.57c-.2 0-.52.07-.79.37-.27.3-1.04 1.02-1.04 2.48s1.06 2.88 1.2 3.08c.15.2 2.08 3.18 5.05 4.46.7.3 1.25.48 1.68.62.71.23 1.36.2 1.88.12.57-.08 1.76-.72 2.01-1.42.25-.7.25-1.3.17-1.42-.07-.12-.27-.2-.57-.35z" />
        <path
            d="M26.67 5.33A13.25 13.25 0 0 0 16 1.33C8.64 1.33 2.67 7.3 2.67 14.67c0 2.34.61 4.62 1.77 6.64L2.67 30.67l9.56-1.74a13.3 13.3 0 0 0 3.77.54c7.36 0 13.33-5.97 13.33-13.33 0-3.56-1.39-6.91-3.66-9.01zM16 27.33c-1.2 0-2.38-.2-3.5-.58l-.5-.17-5.67 1.03 1.04-5.52-.19-.56a10.68 10.68 0 0 1-1.6-5.66C5.58 8.85 10.18 4.25 16 4.25c2.87 0 5.56 1.12 7.59 3.15a10.6 10.6 0 0 1 3.14 7.54c0 5.83-4.6 10.39-10.73 10.39z" />
    </svg>
</a>
@endif