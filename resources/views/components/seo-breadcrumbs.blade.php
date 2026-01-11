@props([
'items' => [],
])

@php
$listItems = [];
$position = 1;

foreach ($items as $item) {
$name = (string) ($item['name'] ?? '');
$url = (string) ($item['url'] ?? '');

if ($name === '' || $url === '') {
continue;
}

$url = preg_replace('#^http://#i', 'https://', $url);

$listItems[] = [
'@type' => 'ListItem',
'position' => $position,
'name' => $name,
'item' => $url,
];

$position++;
}

$structuredData = [
'@context' => 'https://schema.org',
'@type' => 'BreadcrumbList',
'itemListElement' => $listItems,
];
@endphp

@if(count($listItems) > 0)
<script type="application/ld+json">
    {
        !!json_encode($structuredData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!
    }
</script>
@endif