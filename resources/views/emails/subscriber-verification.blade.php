@php
use App\Models\SiteSetting;
$siteName = (string) SiteSetting::getValue('site_name', config('app.name'));
@endphp

<p>Halo{{ $subscriber->name ? ', ' . e($subscriber->name) : '' }},</p>

<p>Terima kasih sudah subscribe newsletter <strong>{{ $siteName }}</strong>.</p>

<p>Silakan verifikasi email Anda melalui link berikut:</p>

<p><a href="{{ $verifyUrl }}">Verifikasi Subscription</a></p>

<hr>

<p>Jika Anda tidak merasa melakukan subscription, Anda bisa unsubscribe di sini:</p>

<p><a href="{{ $unsubscribeUrl }}">Unsubscribe</a></p>