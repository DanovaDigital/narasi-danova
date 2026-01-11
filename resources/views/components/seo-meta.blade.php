@props([
'article',
'siteName' => null,
])

@php
$siteName = $siteName ?? config('app.name');
$url = route('articles.show', $article->slug);
$imageUrl = $article->featured_image_url ?? asset('images/default-og.jpg');
$author = $article->author ?? $article->admin;
$publishedDate = $article->published_at?->toIso8601String();
$modifiedDate = $article->updated_at?->toIso8601String();
$keywords = $article->tags->pluck('name')->implode(', ');

// JSON-LD Structured Data
$structuredData = [
'@context' => 'https://schema.org',
'@type' => 'NewsArticle',
'headline' => $article->title,
'description' => $article->meta_description ?? $article->excerpt,
'image' => [
'@type' => 'ImageObject',
'url' => $imageUrl,
],
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
'url' => asset('images/logo.png'),
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

{{-- Standard Meta Tags --}}
<meta name="description" content="{{ $article->meta_description ?? Str::limit($article->excerpt, 160) }}">
<meta name="keywords" content="{{ $keywords }}">
<meta name="author" content="{{ $author?->name }}">
<link rel="canonical" href="{{ $url }}">

{{-- Open Graph (Facebook) --}}
<meta property="og:type" content="article">
<meta property="og:site_name" content="{{ $siteName }}">
<meta property="og:url" content="{{ $url }}">
<meta property="og:title" content="{{ $article->meta_title ?? $article->title }}">
<meta property="og:description" content="{{ $article->meta_description ?? Str::limit($article->excerpt, 200) }}">
<meta property="og:image" content="{{ $imageUrl }}">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
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
<meta name="twitter:title" content="{{ $article->meta_title ?? $article->title }}">
<meta name="twitter:description" content="{{ $article->meta_description ?? Str::limit($article->excerpt, 200) }}">
<meta name="twitter:image" content="{{ $imageUrl }}">

{{-- JSON-LD Structured Data --}}
<script type="application/ld+json">
    {
        !!json_encode($structuredData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!
    }
</script>