<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="shortcut icon" href="{{ asset('admin.png') }}" type="image/x-icon">
    @livewireStyles

    <!-- ICON CDN -->
    <script src="https://unpkg.com/feather-icons"></script>
</head>

<body class="bg-gray-50">

<div class="flex min-h-screen">

    <!-- SIDEBAR -->
    <aside id="sidebar"
        class="fixed h-full bg-gradient-to-b from-indigo-600 to-violet-700
               text-white shadow-xl transition-all duration-300 ease-in-out w-64">

        <!-- LOGO (ONLY WHEN OPEN) -->
        <div id="logoArea"
             class="p-6 flex items-center gap-3 transition-all duration-300">
            <img src="{{ asset('admin.png') }}" class="w-10 h-10" alt="Logo">
            <div class="sidebar-text">
                <h1 class="text-xl font-bold">E-Voting</h1>
                <p class="text-indigo-200 text-sm">Admin Panel</p>
            </div>
        </div>

        <!-- MENU -->
        <nav id="sidebarMenu" class="mt-6 px-4 space-y-2">

            <a href="{{ route('admin.dashboard') }}"
               class="menu-item flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-white/10">
                <i data-feather="home"></i>
                <span class="sidebar-text">Dashboard</span>
            </a>

            <a href="{{ route('admin.pemilihan') }}"
               class="menu-item flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-white/10">
                <i data-feather="file-text"></i>
                <span class="sidebar-text">Kelola Pemilihan</span>
            </a>

            <a href="{{ route('admin.kandidat') }}"
               class="menu-item flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-white/10">
                <i data-feather="users"></i>
                <span class="sidebar-text">Kelola Kandidat</span>
            </a>

            <a href="{{ route('admin.anggota') }}"
               class="menu-item flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-white/10">
                <i data-feather="user-check"></i>
                <span class="sidebar-text">Kelola Siswa</span>
            </a>

            <a href="{{ route('admin.hasil') }}"
               class="menu-item flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-white/10">
                <i data-feather="bar-chart-2"></i>
                <span class="sidebar-text">Hasil Pemilihan</span>
            </a>

            <form method="POST" action="{{ route('keluar') }}" class="mt-8">
                @csrf
                <button type="submit"
                    class="menu-item flex items-center gap-4 px-4 py-3 rounded-xl
                           hover:bg-red-500/20 w-full">
                    <i data-feather="log-out"></i>
                    <span class="sidebar-text">Keluar</span>
                </button>
            </form>

        </nav>
    </aside>

    <!-- TOGGLE (DESKTOP ONLY) -->
   <button id="sidebarToggle"
    class="hidden lg:flex fixed top-6 z-50 w-10 h-10
           items-center justify-center rounded-xl bg-white shadow-lg
           text-gray-700 hover:bg-gray-100 transition-all duration-300">
    ☰
</button>


    <!-- MAIN -->
    <main id="mainContent"
          class="flex-1 ml-64 p-8 transition-all duration-300 ease-in-out">
        <div class="max-w-7xl mx-auto">
            {{ $slot }}
        </div>
    </main>

</div>

@livewireScripts

<script>
    feather.replace();

    const sidebar   = document.getElementById('sidebar');
    const main      = document.getElementById('mainContent');
    const toggle    = document.getElementById('sidebarToggle');
    const texts     = document.querySelectorAll('.sidebar-text');
    const menuItems = document.querySelectorAll('.menu-item');
    const logoArea  = document.getElementById('logoArea');
    const menu      = document.getElementById('sidebarMenu');

    let open = localStorage.getItem('sidebarOpen');

    if (open === null) {
        open = true;
        localStorage.setItem('sidebarOpen', 'true');
    } else {
        open = open === 'true';
    }

    function applySidebarState() {
        if (!open) {
            // SIDEBAR CLOSED
            sidebar.classList.replace('w-64', 'w-20');
            main.classList.replace('ml-64', 'ml-20');

            texts.forEach(el => el.classList.add('hidden'));
            menuItems.forEach(el => el.classList.add('justify-center'));
            logoArea.classList.add('hidden');

            // 🔑 TURUNKAN MENU (BIAR TIDAK KETUTUP TOGGLE)
            menu.classList.remove('mt-6');
            menu.classList.add('mt-20');

            // POSISI TOGGLE
            toggle.style.left = '1.25rem';

        } else {
            // SIDEBAR OPEN
            sidebar.classList.replace('w-20', 'w-64');
            main.classList.replace('ml-20', 'ml-64');

            texts.forEach(el => el.classList.remove('hidden'));
            menuItems.forEach(el => el.classList.remove('justify-center'));
            logoArea.classList.remove('hidden');

            menu.classList.remove('mt-20');
            menu.classList.add('mt-6');

            toggle.style.left = '13rem';
        }
    }

    applySidebarState();

    toggle.addEventListener('click', () => {
        open = !open;
        localStorage.setItem('sidebarOpen', open);
        applySidebarState();
    });
</script>




</body>
</html>
