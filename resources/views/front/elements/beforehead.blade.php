@php
  $siteName = $generalSetting->site_name ?: 'Tarama Engineering Concern';
  $pageTitle = !empty($meta_title) ? $meta_title.' :: '.$siteName : $title;
  $description = trim(strip_tags($meta_description ?? $generalSetting->meta_description ?? $generalSetting->description ?? ''));
  $favicon = $generalSetting->site_favicon
    ? env('UPLOADS_URL').$generalSetting->site_favicon
    : env('FRONT_ASSETS_URL').'img/favicon.png';
  $brandColor = preg_match('/^#[0-9a-fA-F]{6}$/', (string) $generalSetting->theme_color)
    ? $generalSetting->theme_color
    : '#043467';
@endphp

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{{ $pageTitle }}</title>
<meta name="description" content="{{ \Illuminate\Support\Str::limit($description, 160, '') }}">
@if(!empty($meta_keywords))
  <meta name="keywords" content="{{ $meta_keywords }}">
@endif
<meta name="theme-color" content="{{ $brandColor }}">

<link href="{{ $favicon }}" rel="icon">
<link href="{{ $favicon }}" rel="apple-touch-icon">

<link href="https://fonts.googleapis.com" rel="preconnect">
<link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&family=Poppins:wght@400;500;600;700&family=Jost:wght@400;500;600;700&display=swap" rel="stylesheet">

<link href="{{ env('FRONT_ASSETS_URL') }}vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="{{ env('FRONT_ASSETS_URL') }}vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
<link href="{{ env('FRONT_ASSETS_URL') }}vendor/aos/aos.css" rel="stylesheet">
<link href="{{ env('FRONT_ASSETS_URL') }}vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
<link href="{{ env('FRONT_ASSETS_URL') }}vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
<link href="{{ env('FRONT_ASSETS_URL') }}css/main.css" rel="stylesheet">
<link href="{{ env('FRONT_ASSETS_URL') }}css/tarama.css?v=20260613" rel="stylesheet">

<style>
  :root {
    --heading-color: {{ $brandColor }};
    --brand-color: {{ $brandColor }};
  }
</style>
