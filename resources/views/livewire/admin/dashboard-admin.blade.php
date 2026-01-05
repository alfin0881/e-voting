<div class="space-y-6 font-dashboard">
    {{-- Header --}}
    <div class="space-y-2">
        <h1 class="text-3xl font-bold text-gray-800">
            Dashboard Admin
        </h1>
        <p class="text-gray-600">
            Selamat datang kembali, <span class="text-indigo-600 font-bold">{{ auth()->user()->nama }}</span>
        </p>
    </div>

    {{-- Statistik Utama --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-3xl p-6 text-white shadow-xl shadow-indigo-100 transition-all hover:scale-[1.02]">
            <p class="text-indigo-100 text-[10px] font-black uppercase tracking-widest">Total Pemilihan</p>
            <h3 class="text-4xl font-black mt-2">{{ number_format($totalPemilihan) }}</h3>
        </div>

        <div class="bg-gradient-to-br from-violet-500 to-violet-600 rounded-3xl p-6 text-white shadow-xl shadow-violet-100 transition-all hover:scale-[1.02]">
            <p class="text-violet-100 text-[10px] font-black uppercase tracking-widest">Total Pemilih</p>
            <h3 class="text-4xl font-black mt-2">{{ number_format($totalUser) }}</h3>
        </div>

        <div class="bg-gradient-to-br from-pink-500 to-pink-600 rounded-3xl p-6 text-white shadow-xl shadow-pink-100 transition-all hover:scale-[1.02]">
            <p class="text-pink-100 text-[10px] font-black uppercase tracking-widest">Total Kandidat</p>
            <h3 class="text-4xl font-black mt-2">{{ number_format($totalKandidat) }}</h3>
        </div>

        <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-3xl p-6 text-white shadow-xl shadow-emerald-100 transition-all hover:scale-[1.02]">
            <p class="text-emerald-100 text-[10px] font-black uppercase tracking-widest">Total Suara Masuk</p>
            <h3 class="text-4xl font-black mt-2">{{ number_format($totalSuara) }}</h3>
        </div>
    </div>

    {{-- Bagian Grafik & Aksi Cepat --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Card Grafik Partisipasi --}}
        <div class="lg:col-span-2 bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-8">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-xl font-bold text-slate-800">Partisipasi Kehadiran</h2>
                    <p class="text-sm text-slate-500 font-medium">Monitoring siswa yang sudah memilih dan belum memilih</p>
                </div>
            </div>
            
            <div class="flex flex-col md:flex-row items-center gap-12">
                {{-- Donut Chart Canvas --}}
                <div class="relative w-52 h-52">
                    <canvas id="participationDonut"></canvas>
                    <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                        <span class="text-3xl font-black text-slate-800">
                            {{ $totalUser > 0 ? number_format(($totalSiswaSudahMemilih / $totalUser) * 100, 1) : 0 }}%
                        </span>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Partisipasi</span>
                    </div>
                </div>

                {{-- Detail Legend --}}
                <div class="flex-1 space-y-4 w-full">
                    <div class="p-5 bg-emerald-50 rounded-2xl border border-emerald-100 flex items-center justify-between group transition-all hover:bg-emerald-100/50">
                        <div class="flex items-center gap-4">
                            <div class="w-2 h-10 bg-emerald-500 rounded-full"></div>
                            <div>
                                <p class="text-1xl font-bold text-emerald-600 mb-2">Sudah Memilih</p>
                                <p class="text-xl font-black text-emerald-900 leading-none">{{ number_format($totalSiswaSudahMemilih) }} <span class="text-xs font-bold text-emerald-600/70">Siswa</span></p>
                            </div>
                        </div>
                    </div>

                    <div class="p-5 bg-slate-50 rounded-2xl border border-slate-100 flex items-center justify-between group transition-all hover:bg-slate-100/50">
                        <div class="flex items-center gap-4">
                            <div class="w-2 h-10 bg-slate-300 rounded-full"></div>
                            <div>
                                <p class="text-1xl font-bold text-slate-400 mb-2">Belum Memilih</p>
                                <p class="text-xl font-black text-slate-800 leading-none">{{ number_format(max(0, $totalUser - $totalSiswaSudahMemilih)) }} <span class="text-xs font-bold text-slate-400">Siswa</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-8">
            <h2 class="text-xl font-bold text-slate-800 mb-6 tracking-tight">Aksi Cepat</h2>
            <div class="flex flex-col gap-3">
                <a href="{{route('admin.anggota')}}" class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl text-slate-600 hover:bg-slate-800 hover:text-white transition-all duration-300 font-bold group">
                    <span class="text-sm">Kelola Pemilih</span>
                    <i data-feather="user-check"></i>
                </a>
                <a href="{{route('admin.kandidat')}}" class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl text-slate-600 hover:bg-slate-800 hover:text-white transition-all duration-300 font-bold group">
                    <span class="text-sm">Kelola Kandidat</span>
                    <i data-feather="users"></i>
                </a>
              <a href="{{route('admin.hasil')}}" class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl text-slate-600 hover:bg-slate-800 hover:text-white transition-all duration-300 font-bold group">
                    <span class="text-sm">Lihat Semua Hasil</span>
                    <i data-feather="bar-chart-2"></i>
                </a>
                  <form method="POST" action="{{ route('logout') }}">
                    @csrf
                <button type="submit" class="w-full flex items-center justify-between p-4 bg-slate-50 rounded-2xl text-slate-600 hover:bg-slate-800 hover:text-white transition-all duration-300 font-bold group">
                    <span class="text-sm">Keluar</span>
                    <i data-feather="log-out"></i>
                </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Pemilihan Aktif (Layout Sebelumnya Dipercantik) --}}
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-8">
        <div class="flex items-center justify-between mb-2">
            <h2 class="text-xl font-bold text-slate-800">Pemilihan Sedang Aktif</h2>
            <div class="flex items-center gap-2 px-4 py-1.5 bg-rose-50 rounded-full mb-2">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-rose-500"></span>
                </span>
                <span class="text-[10px] font-black text-rose-600 uppercase tracking-widest">{{ $pemilihanAktif->count() }} Live</span>
            </div>
        </div>

        @if($pemilihanAktif->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($pemilihanAktif as $pemilihan)
                    <div class="group relative bg-slate-50/50 border border-slate-100 rounded-[2rem] p-6 transition-all duration-300 hover:bg-white hover:shadow-xl hover:shadow-indigo-500/5">
                        <div class="flex justify-between items-center mb-4">
                            <span class="bg-indigo-600 text-white text-[9px] font-black px-3 py-1 rounded-lg uppercase tracking-widest shadow-lg shadow-indigo-100">Aktif</span>
                            <span class="text-slate-300 group-hover:text-indigo-600 transition-colors"><i class="bi bi-box-seam text-xl"></i></span>
                        </div>

                        <h3 class="font-bold text-slate-800 text-lg mb-1 leading-tight">{{ $pemilihan->nama_pemilihan }}</h3>
                        <p class="text-xs text-slate-400 font-medium mb-4 italic">Berakhir pada {{ $pemilihan->tanggal_selesai->locale('id')->translatedFormat('d M Y') }}</p>

                        <div class="mt-6 pt-5 border-t border-slate-100 flex justify-between items-end">
                            <div>
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Suara Terkumpul</p>
                                <p class="text-2xl font-black text-indigo-600 leading-none">{{ number_format($pemilihan->totalSuara()) }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="flex flex-col items-center justify-center py-16 bg-slate-50/50 rounded-[2rem] border border-dashed border-slate-200">
                <p class="text-slate-400 font-bold tracking-tight">Tidak ada pemilihan yang aktif saat ini.</p>
            </div>
        @endif
    </div>
</div>

{{-- Script Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('participationDonut').getContext('2d');
        
        // Data dari Livewire (Pastikan variabel ini ada di DashboardAdmin.php)
        const sudahMemilih = @json($totalSiswaSudahMemilih);
        const totalSiswa = @json($totalUser);
        const belumMemilih = Math.max(0, totalSiswa - sudahMemilih);

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Sudah Memilih', 'Belum Memilih'],
                datasets: [{
                    data: [sudahMemilih, belumMemilih],
                    backgroundColor: ['#10b981', '#f1f5f9'], // Emerald-500 & Slate-100
                    borderWidth: 0,
                    borderRadius: 15,
                    hoverOffset: 12
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '80%',
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        padding: 12,
                        cornerRadius: 12,
                        titleFont: { size: 10, weight: 'bold' },
                        bodyFont: { size: 13, weight: '900' },
                        callbacks: {
                            label: (item) => ` ${item.label}: ${item.raw} Siswa`
                        }
                    }
                }
            }
        });
    });
</script>