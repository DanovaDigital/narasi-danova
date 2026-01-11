@props([
'title' => null,
'description' => null,
'canonical' => null,
'image' => null,
'type' => 'website',
'robots' => 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1',
'siteName' => null,
'locale' => 'id_ID',
'includeProduct' => false,
])

@php
use App\Models\SiteSetting;
use Illuminate\Support\Str;

$siteName = $siteName ?? (string) SiteSetting::getValue('site_name', config('app.name'));
$defaultDescription = (string) SiteSetting::getValue('site_description', 'Berita, artikel, dan narasi terbaru.');

$rawTitle = (string) ($title ?? $siteName);
$title = Str::contains($rawTitle, '|') ? $rawTitle : ($rawTitle . ' | ' . $siteName);
$title = Str::limit(trim($title), 60, '');
$description = (string) ($description ?? $defaultDescription);

$canonical = (string) ($canonical ?? url()->current());
$canonical = preg_replace('#^http://#i', 'https://', $canonical);

$image = $image ?: SiteSetting::getValue('og_image_url');
$image = $image ?: asset('images/article-placeholder.svg');

$description = Str::limit(trim($description), 160, '');

$orgLogo = SiteSetting::getValue('site_logo_url') ?: asset('favicon.ico');

$twitterSite = (string) (SiteSetting::getValue('twitter_site', '') ?? '');
$twitterCreator = (string) (SiteSetting::getValue('twitter_creator', '') ?? '');
$twitterCreator = $twitterCreator !== '' ? $twitterCreator : $twitterSite;

$siteUrl = preg_replace('#^http://#i', 'https://', url('/'));
$searchUrl = preg_replace('#^http://#i', 'https://', url('/search'));
$orgLogo = preg_replace('#^http://#i', 'https://', (string) $orgLogo);
$image = preg_replace('#^http://#i', 'https://', (string) $image);

$graph = [
[
'@type' => 'Organization',
'name' => $siteName,
'url' => $siteUrl,
'logo' => $orgLogo,
],
[
'@type' => 'WebSite',
'name' => $siteName,
'url' => $siteUrl,
'potentialAction' => [
'@type' => 'SearchAction',
'target' => $searchUrl . '?q={search_term_string}',
'query-input' => 'required name=search_term_string',
],
],
];

if ((bool) $includeProduct) {
$graph[] = [
'@type' => 'Product',
'name' => $siteName . ' Newsletter',
'description' => 'Berlangganan newsletter untuk update artikel terbaru.',
'brand' => [
'@type' => 'Brand',
'name' => $siteName,
],
'offers' => [
'@type' => 'Offer',
'priceCurrency' => 'IDR',
'price' => 0,
'availability' => 'https://schema.org/InStock',
'url' => $siteUrl,
],
];
}

$structuredData = [
'@context' => 'https://schema.org',
'@graph' => $graph,
];
@endphp

<meta name="description" content="{{ $description }}">
<link rel="canonical" href="{{ $canonical }}">
<meta name="robots" content="{{ $robots }}">

<meta property="og:locale" content="{{ $locale }}">
<meta property="og:type" content="{{ $type }}">
<meta property="og:title" content="{{ $title }}">
<meta property="og:description" content="{{ Str::limit($description, 200) }}">
<meta property="og:url" content="{{ $canonical }}">
<meta property="og:site_name" content="{{ $siteName }}">
<meta property="og:image" content="{{ $image }}">

<meta name="twitter:card" content="summary_large_image">
@if($twitterSite !== '')
<meta name="twitter:site" content="{{ $twitterSite }}">
@endif
@if($twitterCreator !== '')
<meta name="twitter:creator" content="{{ $twitterCreator }}">
@endif
<meta name="twitter:title" content="{{ $title }}">
<meta name="twitter:description" content="{{ Str::limit($description, 200) }}">
<meta name="twitter:image" content="{{ $image }}">

<script type="application/ld+json">
    {
        !!json_encode($structuredData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!
    }
</script>