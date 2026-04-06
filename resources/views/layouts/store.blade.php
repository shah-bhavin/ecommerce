<!DOCTYPE html>

<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Abrari</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif:ital,wght@0,400;0,700;1,400&amp;family=Manrope:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    
    @vite(['resources/css/store.css', 'resources/js/store.js'])

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
    <x-store.top-navigation />

    {{ $slot }}

    <x-store.footer />
    <x-toast />  
    <x-store.sidenav />
    
</body>

</html>