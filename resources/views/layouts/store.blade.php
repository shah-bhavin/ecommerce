<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'LUMISKIN | Molecular Skincare' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/store.css'])
    <script src="https://cdn.jsdelivr.net/npm/flowbite@4.0.1/dist/flowbite.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <!-- @fluxAppearance -->
</head>
<body class="bg-white text-zinc-900 antialiased font-sans">
    <x-store.top-navigation />
    <main>{{ $slot }}</main>
    <x-toast />  
    <x-store.modal />
    @fluxScripts    
</body>
</html>




