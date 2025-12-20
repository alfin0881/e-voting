<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasya - E-Voting</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="shortcut icon" href="{{ asset('logo.png') }}" type="image/x-icon">
    @livewireStyles
</head>
<body class="bg-gradient-to-br from-indigo-50 via-white to-violet-50 min-h-screen">
    <!-- Navbar -->
    <nav class="bg-white/80 backdrop-blur-lg border-b border-indigo-100 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-violet-600 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold bg-gradient-to-r from-indigo-600 to-violet-600 bg-clip-text text-transparent">
                            Kasya E-Voting
                        </h1>
                        <p class="text-xs text-gray-500">SMK AL-SYA'IRIYAH LIMPUNG</p>
                    </div>
                </div>
                
                <div class="flex items-center gap-4">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-semibold text-gray-700">{{ auth()->user()->nama }}</p>
                        <p class="text-xs text-gray-500">{{ auth()->user()->nis }}</p>
                    </div>
                    <i class="fa-solid fa-user-circle text-3xl text-gray-700"></i>
                    <form method="POST" action="{{ route('keluar') }}">
                        @csrf
                        <button type="submit" 
                                class="px-4 py-2 bg-gradient-to-r from-red-500 to-rose-700 text-white rounded-xl hover:shadow-lg transition duration-300 hover:scale-105 text-sm font-medium">
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="py-7">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12">
            {{ $slot }}
        </div>
    </main>

    <!-- Footer -->
    <footer class="mt-16 py-8 bg-white/50 backdrop-blur-sm border-t border-gray-200">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-gray-600 text-sm">© 2025 Kasya E-Voting. All rights reserved.</p>
        </div>
    </footer>

    @livewireScripts
    @stack('scripts')
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('notifikasi', (event) => {
                const tipe = event.tipe || 'success';
                const warna = tipe === 'success' ? 'bg-green-500' : 'bg-red-500';
                
                const toast = document.createElement('div');
                toast.className = fixed top-4 right-4 ${warna} text-white px-6 py-4 rounded-xl shadow-2xl z-50 animate-slide-up;
                toast.textContent = event.pesan;
                document.body.appendChild(toast);
                
                setTimeout(() => {
                    toast.style.opacity = '0';
                    setTimeout(() => toast.remove(), 300);
                }, 3000);
            });
        });
    </script>
</body>
</html>