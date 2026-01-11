@props([
'article',
'siteName' => null,
])

@php
$siteName = $siteName ?? \App\Models\SiteSetting::getValue('site_name', config('app.name'));
$url = route('articles.show', $article->slug);
$url = preg_replace('#^http://#i', 'https://', $url);
$imageUrl = $article->featured_image_url ?: (\App\Models\SiteSetting::getValue('og_image_url') ?: asset('images/article-placeholder.svg'));
$imageUrl = (string) $imageUrl;
if (\Illuminate\Support\Str::startsWith($imageUrl, '//')) {
$imageUrl = 'https:' . $imageUrl;
} elseif (!preg_match('#^https?://#i', $imageUrl)) {
$imageUrl = url($imageUrl);
}
$imageUrl = preg_replace('#^http://#i', 'https://', (string) $imageUrl);
$author = $article->author ?? $article->admin;
$publishedDate = $article->published_at?->toIso8601String();
$modifiedDate = $article->updated_at?->toIso8601String();
$keywords = $article->tags->pluck('name')->implode(', ');

$pageTitle = \Illuminate\Support\Str::limit((($article->meta_title ?? $article->title) . ' | ' . $siteName), 60, '');
$twitterSite = (string) (\App\Models\SiteSetting::getValue('twitter_site', '') ?? '');
$twitterCreator = (string) (\App\Models\SiteSetting::getValue('twitter_creator', '') ?? '');
$publisherLogo = \App\Models\SiteSetting::getValue('site_logo_url') ?: asset('favicon.ico');
$publisherLogo = preg_replace('#^http://#i', 'https://', (string) $publisherLogo);

// JSON-LD Structured Data
$structuredData = [
'@context' => 'https://schema.org',
'@type' => 'NewsArticle',
'headline' => $article->title,
'description' => $article->meta_description ?? $article->excerpt,
'image' => [$imageUrl],
'datePublished' => $publishedDate,
'dateModified' => $modifiedDate,
'author' => [
'@type' => 'Person',
'name' => $author?->name ?? 'Unknown',
],
'publisher' => [
'@type' => 'Organization',
'name' => $siteName,
'logo' => [
'@type' => 'ImageObject',
'url' => $publisherLogo,
],
],
'mainEntityOfPage' => [
'@type' => 'WebPage',
'@id' => $url,
],
];

if ($article->category) {
$structuredData['articleSection'] = $article->category->name;
}

if ($keywords) {
$structuredData['keywords'] = $keywords;
}
@endphp

@push('title')
{{ $pageTitle }}
@endpush

{{-- Standard Meta Tags --}}
<meta name="description" content="{{ $article->meta_description ?? Str::limit($article->excerpt, 160) }}">
<meta name="keywords" content="{{ $keywords }}">
<meta name="author" content="{{ $author?->name }}">
<link rel="canonical" href="{{ $url }}">
<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">

{{-- Open Graph (Facebook) --}}
<meta property="og:locale" content="id_ID">
<meta property="og:type" content="article">
<meta property="og:site_name" content="{{ $siteName }}">
<meta property="og:url" content="{{ $url }}">
<meta property="og:title" content="{{ $article->meta_title ?? $article->title }}">
<meta property="og:description" content="{{ $article->meta_description ?? Str::limit($article->excerpt, 200) }}">
<meta property="og:image" content="{{ $imageUrl }}">
<meta property="article:published_time" content="{{ $publishedDate }}">
<meta property="article:modified_time" content="{{ $modifiedDate }}">

@if($article->category)
<meta property="article:section" content="{{ $article->category->name }}">
@endif

@foreach($article->tags as $tag)
<meta property="article:tag" content="{{ $tag->name }}">
@endforeach

{{-- Twitter Card --}}
<meta name="twitter:card" content="summary_large_image">
@if($twitterSite !== '')
<meta name="twitter:site" content="{{ $twitterSite }}">
@endif
@if($twitterCreator !== '')
<meta name="twitter:creator" content="{{ $twitterCreator }}">
@endif
<meta name="twitter:title" content="{{ $article->meta_title ?? $article->title }}">
<meta name="twitter:description" content="{{ $article->meta_description ?? Str::limit($article->excerpt, 200) }}">
<meta name="twitter:image" content="{{ $imageUrl }}">

{{-- JSON-LD Structured Data --}}
<script type="application/ld+json">
    {
        !!json_encode($structuredData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!
    }
</script>