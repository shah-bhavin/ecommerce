@use('App\Models\Setting')

<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- 1. Dynamic Title --}}
    <title>@yield('title', 'Welcome') {{ Setting::get('seo_suffix', '| ' . Setting::get('site_name', 'Abrari')) }}</title>
    
    {{-- 2. Essential SEO Tags --}}
    <meta name="description" content="@yield('meta_description', Setting::get('brand_tagline', 'Luxury clinical skincare.'))">
    <meta name="keywords" content="skincare, clinical formulas, luxury beauty, {{ Setting::get('site_name') }}">
    <meta name="author" content="{{ Setting::get('site_name') }}">
    <link rel="canonical" href="@yield('canonical', url()->current())">

    {{-- 3. Social Media (Open Graph / Facebook) --}}
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="{{ Setting::get('site_name') }}">
    <meta property="og:title" content="@yield('title') {{ Setting::get('seo_suffix') }}">
    <meta property="og:description" content="@yield('meta_description', Setting::get('brand_tagline'))">
    <meta property="og:image" content="@yield('og_image', asset('storage/' . Setting::get('logo_header')))">

    {{-- 4. Twitter Cards --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title')">
    <meta name="twitter:description" content="@yield('meta_description', Setting::get('brand_tagline'))">
    <meta name="twitter:image" content="@yield('og_image', asset('storage/' . Setting::get('logo_header')))">

    {{-- 5. Dynamic Favicon from Settings --}}
    @if($favicon = Setting::get('favicon'))
        <link rel="icon" type="image/png" href="{{ asset('storage/' . $favicon) }}">
        <link rel="apple-touch-icon" href="{{ asset('storage/' . $favicon) }}">
    @endif

    {{-- 6. Analytics (Google) --}}
    @if($gaId = Setting::get('analytics_ga'))
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $gaId }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ $gaId }}');
        </script>
    @endif

    {{-- 7. Analytics (Facebook Pixel) --}}
    @if($pixelId = Setting::get('analytics_pixel'))
        <script>
            !function(f,b,e,v,n,t,s){/* Pixel Code Initializer */}(window, document,'script');
            fbq('init', '{{ $pixelId }}');
            fbq('track', 'PageView');
        </script>
    @endif

    {{-- Preload critical CSS/JS --}}
    @vite(['resources/css/store.css', 'resources/js/store.js'])
    
    {{-- Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300..700;1,300..700&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    {{-- Analytics (Google & Facebook) --}}
    @if($gaId = Setting::get('analytics_ga'))
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $gaId }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ $gaId }}');
        </script>
    @endif
    
    @livewireStyles

    {{-- Allows specific pages to push unique tags (scripts or meta) --}}
    @stack('head')
</head>

<body class="bg-surface font-body text-on-surface">
    <x-store.top-navigation />

    {{ $slot }}

    <x-store.footer />
    <x-toast />  
    <x-store.sidenav />
    @livewireScripts
    @stack('scripts')
</body>
</html>