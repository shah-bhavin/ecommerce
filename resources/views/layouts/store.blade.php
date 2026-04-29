<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- 1. Dynamic Title --}}
    <title>@yield('title', 'Abrari – Luxury Skincare & Clinical Formulas')</title>

    {{-- 2. Essential SEO Tags --}}
    <meta name="description" content="@yield('meta_description', 'Discover premium clinical skincare at Abrari. High-performance formulas for professional results.')">
    <meta name="keywords" content="skincare, clinical formulas, beauty, luxury skincare, serum, Lumiskin">
    <meta name="author" content="Abrari Studio">
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- 3. Social Media (Open Graph / Facebook) --}}
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'Abrari – Luxury Skincare')">
    <meta property="og:description" content="@yield('meta_description', 'High-performance clinical formulas.')">
    <meta property="og:image" content="@yield('meta_image', asset('images/og-default.jpg'))">

    {{-- 4. Twitter Cards --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'Abrari – Luxury Skincare')">
    <meta name="twitter:description" content="@yield('meta_description', 'Clinical formulas for professional results.')">
    <meta name="twitter:image" content="@yield('meta_image', asset('images/og-default.jpg'))">

    {{-- 5. Performance & Resource Hints --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    {{-- Preload critical CSS/JS --}}
    @vite(['resources/css/store.css', 'resources/js/store.js'])

    {{-- 6. Favicons (Amazon/Flipkart Style) --}}
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    {{--<link rel="manifest" href="/site.webmanifest">--}}

    {{-- Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300..700;1,300..700&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

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