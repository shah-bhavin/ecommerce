<!DOCTYPE html>

<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Abrari</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300..700;1,300..700&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    
    @vite(['resources/css/store.css', 'resources/js/store.js'])
    @livewireStyles

    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 300, 'GRAD' 0, 'opsz' 24;
        }

        .editorial-text-shadow {
            text-shadow: 0 4px 12px rgba(120, 0, 55, 0.2);
        }

        .no-line-rule {
            border: none !important;
        }

        .tonal-shift {
            transition: background-color 0.4s ease;
        }
    </style>
</head>

<body class="bg-surface font-body text-on-surface">
    {{--<pre>
        @php print_r(session()->all()); echo session()->getId(); @endphp
    </pre>--}}
    <x-store.top-navigation />

    {{ $slot }}
    

    <x-store.footer />
    <x-toast />  
    <x-store.sidenav />
    @livewireScripts
</body>

</html>