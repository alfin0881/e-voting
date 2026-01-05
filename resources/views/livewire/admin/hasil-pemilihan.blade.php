<style>
    /* Animasi List Detail (Naik dari bawah) */
    .detail-item {
        opacity: 0;
        transform: translateY(25px);
        transition: opacity 0.6s ease-out, transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .detail-item.show {
        opacity: 1;
        transform: translateY(0);
    }
    /* Progress Bar Smooth */
    .progress-bar {
        width: 0% !important;
        transition: width 2s cubic-bezier(0.1, 1, 0.1, 1) !important;
    }
    .pemilihan-slide {
        animation: fadeIn 0.5s ease-in;
    }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
</style>

<style>
    /* (STYLE ANDA — TIDAK DIUBAH) */
    .detail-item {
        opacity: 0;
        transform: translateY(25px);
        transition: opacity 0.6s ease-out, transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .detail-item.show {
        opacity: 1;
        transform: translateY(0);
    }
    .progress-bar {
        width: 0% !important;
        transition: width 2s cubic-bezier(0.1, 1, 0.1, 1) !important;
    }
    .pemilihan-slide {
        animation: fadeIn 0.5s ease-in;
    }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
</style>

<div class="space-y-6"
    wire:poll.60s="reloadData"
    wire:key="hasil-pemilihan-root">

    {{-- HEADER (TIDAK DIUBAH) --}}
    <div class="max-w-7xl mx-auto mb-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Hasil Pemilihan</h1>
                <p class="text-gray-600 mt-1">Update otomatis setiap {{ $refreshInterval }} menit.</p>
            </div>

            <div class="flex flex-col sm:flex-row items-center gap-4">
                <select id="pemilihanDropdown"
                        class="w-full sm:w-64 px-4 py-3 rounded-2xl border border-slate-200 bg-white shadow-sm outline-none">
                    @foreach($allHasilData as $i => $data)
                        <option value="{{ $i }}">{{ $data['pemilihan']['nama_pemilihan'] }}</option>
                    @endforeach
                </select>

                <div class="p-3 pr-8 bg-white rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
                    <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white">
                        <i data-feather="bar-chart-2"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase">Total Pemilihan</p>
                        <p class="text-2xl font-black text-slate-800">{{ count($allHasilData) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- SLIDE CONTAINER --}}
    {{-- 🔑 wire:ignore.self AGAR LIVEWIRE TIDAK MERUSAK CHART --}}
    <div class="max-w-7xl mx-auto" id="slideContainer" wire:ignore.self>

        @foreach($allHasilData as $index => $data)
            <div
                class="pemilihan-slide bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden"
                style="display: {{ $index === 0 ? 'block' : 'none' }}">

                <div class="px-8 py-8 border-b border-slate-50 flex justify-between items-center">
                    <h2 class="text-3xl font-bold">{{ $data['pemilihan']['nama_pemilihan'] }}</h2>
                    <div class="bg-slate-50 px-6 py-3 rounded-2xl text-center">
                        <span class="block text-[10px] font-bold text-slate-400">TOTAL SUARA</span>
                        <span class="text-2xl font-black text-slate-700">
                            {{ number_format($data['total_suara']) }}
                        </span>
                    </div>
                </div>

                <div class="p-8 grid grid-cols-1 lg:grid-cols-12 gap-12">

                    {{-- CHART --}}
                    <div class="lg:col-span-5 chart-wrapper"
                        data-labels='@json(collect($data["kandidat"])->pluck("nama_kandidat"))'
                        data-values='@json(collect($data["kandidat"])->pluck("suara_count"))'
                        data-colors='@json(collect($data["kandidat"])->map(fn($k)=>$this->getColor($k["nomor_urut"])))'>

                        <div class="relative h-72">
                            <canvas class="line-chart-canvas"></canvas>
                        </div>
                    </div>

                    {{-- DETAIL (TIDAK DIUBAH) --}}
                    <div class="lg:col-span-7 space-y-4">
                        @foreach($data['kandidat'] as $k)
                            <div class="detail-item bg-slate-50 p-4 rounded-3xl">
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 rounded-2xl text-white flex items-center justify-center font-black"
                                            style="background: {{ $this->getColor($k['nomor_urut']) }}">
                                            {{ $k['nomor_urut'] }}
                                        </div>
                                        <div>
                                            <p class="font-black text-slate-800">{{ $k['nama_kandidat'] }}</p>
                                            <p class="text-xs text-slate-400">{{ number_format($k['suara_count']) }} suara</p>
                                        </div>
                                    </div>
                                    <div class="text-2xl font-black text-slate-800">{{ $k['persentase'] }}%</div>
                                </div>

                                <div class="mt-3 h-3 bg-slate-200 rounded-full overflow-hidden">
                                    <div class="h-full progress-bar rounded-full"
                                        style="background: {{ $this->getColor($k['nomor_urut']) }}"
                                        data-width="{{ $k['persentase'] }}%">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>
        @endforeach
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let currentSlide = 0;
    let lineCharts = new Map();
    let rotateInterval = null;

    /**
     * Mengatur jarak angka pada sumbu Y (Grid) secara dinamis
     * agar grafik proporsional baik untuk data sedikit maupun banyak.
     */
    function getYAxisStep(max) {
        if (max <= 10) return 1;          // Jarak 1, 2, 3...
        if (max <= 50) return 5;          // Jarak 5, 10, 15...
        if (max <= 100) return 10;        // Jarak 10, 20, 30...
        if (max <= 500) return 50;        // Jarak 50, 100, 150...
        if (max <= 2000) return 200;      // Jarak 200, 400, 600...
        return Math.ceil(max / 10);       // Untuk data sangat besar, bagi menjadi 10 grid
    }

    /**
     * Merender grafik Chart.js dengan efek tumbuh dari angka 0
     */
    function renderCharts(activeSlide) {
        const wrapper = activeSlide.querySelector('.chart-wrapper');
        const canvas = activeSlide.querySelector('.line-chart-canvas');
        if (!wrapper || !canvas) return;

        // Hancurkan instance lama agar animasi reset
        if (lineCharts.has(canvas)) {
            lineCharts.get(canvas).destroy();
        }

        const labels = JSON.parse(wrapper.dataset.labels || '[]');
        const values = JSON.parse(wrapper.dataset.values || '[]');
        const colors = JSON.parse(wrapper.dataset.colors || '[]');
        
        const maxVal = Math.max(...values, 0);
        const step = getYAxisStep(maxVal);
        
        // Memberikan ruang di atas titik tertinggi agar tidak mentok
        const suggestedMax = maxVal === 0 ? 10 : Math.ceil((maxVal + (step / 2)) / step) * step;

        const ctx = canvas.getContext('2d');
        const newChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels,
                datasets: [{
                    data: values,
                    borderColor: '#6366f1',
                    backgroundColor: 'rgba(99, 102, 241, 0.1)',
                    pointBackgroundColor: colors,
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8,
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animations: {
                    y: {
                        duration: 2000,
                        easing: 'easeOutQuart',
                        // Memulai animasi garis dari baseline angka 0
                        from: (ctx) => ctx.chart.scales.y.getPixelForValue(0)
                    }
                },
                scales: {
                    y: { 
                        beginAtZero: true,
                        max: suggestedMax,
                        ticks: {
                            stepSize: step,
                            precision: 0, // Menghindari angka desimal (koma)
                            color: '#94a3b8',
                            font: { size: 11 }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.03)',
                            drawBorder: false
                        }
                    },
                    x: {
                        ticks: {
                            color: '#94a3b8',
                            font: { size: 11 }
                        },
                        grid: { display: false }
                    }
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        padding: 12,
                        cornerRadius: 8,
                        displayColors: false
                    }
                }
            }
        });
        lineCharts.set(canvas, newChart);
    }

    /**
     * Mengatur perpindahan slide dan mentrigger animasi elemen
     */
    function showSlide(index) {
        const slides = document.querySelectorAll('.pemilihan-slide');
        if (slides.length === 0) return;

        currentSlide = (index + slides.length) % slides.length;

        slides.forEach((s, i) => {
            if (i === currentSlide) {
                s.style.display = 'block';
                
                const items = s.querySelectorAll('.detail-item');
                const bars = s.querySelectorAll('.progress-bar');

                // 1. Reset State Animasi
                items.forEach(el => el.classList.remove('show'));
                bars.forEach(el => el.style.setProperty('width', '0%', 'important'));

                // 2. Jalankan Animasi secara bertahap (Staggered)
                setTimeout(() => {
                    // List Kandidat naik satu per satu
                    items.forEach((el, idx) => {
                        setTimeout(() => el.classList.add('show'), idx * 150);
                    });

                    // Progress bar mengisi
                    bars.forEach(el => {
                        el.style.setProperty('width', el.dataset.width, 'important');
                    });

                    // Grafik naik dari nol
                    renderCharts(s);
                }, 100);
            } else {
                s.style.display = 'none';
            }
        });

        // Sinkronkan dropdown jika ada
        const dropdown = document.getElementById('pemilihanDropdown');
        if (dropdown) dropdown.value = currentSlide;
    }

    /**
     * Inisialisasi dan Event Listeners
     */
    document.addEventListener('livewire:init', () => {
        // Otomatis update tampilan saat Livewire berhasil polling data baru
        Livewire.on('data-updated', () => {
            console.log('🔄 Data diperbarui dari server, merestart animasi slide aktif...');
            showSlide(currentSlide); 
        });
    });

    document.addEventListener('DOMContentLoaded', () => {
        // Tampilkan slide pertama
        showSlide(0);

        // Rotasi otomatis setiap 15 detik (Sesuaikan durasi di sini)
        rotateInterval = setInterval(() => {
            showSlide(currentSlide + 1);
        }, 4000); 

        // Listener Dropdown
        const dropdown = document.getElementById('pemilihanDropdown');
        if (dropdown) {
            dropdown.addEventListener('change', (e) => {
                showSlide(parseInt(e.target.value));
            });
        }
        
        // Inisialisasi Feather Icons jika digunakan
        if (typeof feather !== 'undefined') {
            feather.replace();
        }
    });
</script>