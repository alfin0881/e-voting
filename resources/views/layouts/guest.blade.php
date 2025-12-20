<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasya E-Voting</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="shortcut icon" href="{{ asset('logo.png') }}" type="image/x-icon">
    @livewireStyles
</head>
<body class="bg-gradient-to-br from-indigo-50 via-white to-violet-50 min-h-screen">
    {{ $slot }}
    
    @livewireScripts
    @stack('scripts')
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('notifikasi', (event) => {
                alert(event.pesan);
            });
        });
    </script>
</body>
</html>