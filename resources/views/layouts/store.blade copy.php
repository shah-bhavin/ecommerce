<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Lumiskin — Molecular Clinical' }}</title>
    
    @vite(['resources/css/store.css', 'resources/js/store.js'])
    @livewireStyles
    <script>
        document.addEventListener('livewire:navigated', () => { 
            initFlowbite();
        });
    </script>

</head>
<body class="bg-white text-zinc-900 selection:bg-black selection:text-white antialiased">
    
    <x-store.top-navigation />

    <main class="min-h-screen">
        {{ $slot }}
    </main>

    <x-store.footer />
    <x-toast />  
    <x-store.sidenav />

    @livewireScripts
</body>
</html>



