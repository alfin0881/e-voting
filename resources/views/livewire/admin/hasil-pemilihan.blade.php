<div class="space-y-6">
    <div class="max-w-7xl mx-auto mb-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Hasil Pemilihan</h1>
                <p class="text-gray-600 mt-1">Perolehan suara real-time seluruh pemilihan.</p>
            </div>
            
            <div class="flex flex-col sm:flex-row items-center gap-4">
                <select 
                    id="pemilihanDropdown"
                    class="w-full sm:w-64 px-4 py-3 rounded-2xl border border-slate-200 text-sm font-bold bg-white shadow-sm focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none">
                    @foreach($allHasilData as $i => $data)
                        <option value="{{ $i }}">
                            {{ $data['pemilihan']['nama_pemilihan'] }}
                        </option>
                    @endforeach
                </select>
                
                <div class="bg-white p-1.5 pr-6 rounded-2xl shadow-sm border border-slate-200 flex items-center gap-4 transition-all hover:shadow-md">
                    <div class="w-12 h-12 bg-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-200">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <div>
                        <span class="text-[9px] text-slate-400 uppercase font-black tracking-widest block leading-none mb-1">Total Pemilihan</span>
                        <span class="text-2xl font-black text-slate-800 leading-none">{{ count($allHasilData) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(count($allHasilData) > 0)
        <div class="max-w-7xl mx-auto">
           @foreach($allHasilData as $index => $data)
            <div 
                class="pemilihan-slide bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden flex flex-col transition-all duration-700"
                data-index="{{ $index }}"
                style="display: {{ $index === 0 ? 'flex' : 'none' }}">
                    <div class="px-8 py-8 border-b border-slate-50 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                        <div class="space-y-2">
                            <span class="inline-flex items-center gap-2 px-3 py-1 bg-rose-50 text-rose-600 text-[10px] font-bold uppercase rounded-full tracking-wider">
                                <span class="relative flex h-2 w-2">
                                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                                  <span class="relative inline-flex rounded-full h-2 w-2 bg-rose-500"></span>
                                </span>
                                Live Report
                            </span>
                            <div class="flex items-center gap-2 mt-2 text-[11px] font-bold text-indigo-500 uppercase tracking-widest">
                            <span class="relative flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                            </span>
                            Auto refresh setiap 10 detik
                        </div>
                            <h2 class="text-3xl font-bold text-gray-800">{{ $data['pemilihan']['nama_pemilihan'] }}</h2>
                            <div class="flex items-center gap-2 text-slate-400">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <p class="text-xs font-bold uppercase tracking-wide">
                                   {{ \Carbon\Carbon::parse($data['pemilihan']['tanggal_mulai'])->locale('id')->translatedFormat('d M') }} -
                                    {{ \Carbon\Carbon::parse($data['pemilihan']['tanggal_selesai'])->locale('id')->translatedFormat('d M Y') }}
                                </p>
                            </div>
                        </div>
                        <div class="bg-slate-50 border border-slate-100 px-6 py-4 rounded-3xl text-center md:text-right min-w-[160px]">
                            <span class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Suara Masuk</span>
                            <span class="text-3xl font-black text-indigo-600 leading-none">{{ number_format($data['total_suara']) }}</span>
                        </div>
                    </div>

                    <div class="p-8 grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                        
                        <div class="lg:col-span-5 flex flex-col items-center justify-center">
                            <div class="relative h-72 w-full mb-10">
                                <canvas 
                                    id="line-chart-{{ $index }}"
                                    class="line-chart-canvas"
                                    data-labels="{{ json_encode(collect($data['kandidat'])->pluck('nama_kandidat')) }}"
                                    data-values="{{ json_encode(collect($data['kandidat'])->pluck('suara_count')) }}"
                                    data-colors="{{ json_encode(collect($data['kandidat'])->map(fn($k) => $this->getColor($k['nomor_urut']))) }}">
                                </canvas>

                                @if($data['total_suara'] == 0)
                                    <div class="absolute inset-0 flex items-center justify-center bg-white/90 backdrop-blur-sm rounded-3xl text-slate-400 font-bold text-sm">
                                        Menunggu Data...
                                    </div>
                                @endif
                            </div>

                            <div class="flex flex-wrap justify-center gap-3">
                                @foreach($data['kandidat'] as $kandidat)
                                    <div class="flex items-center gap-2 bg-slate-50 px-4 py-2 rounded-2xl border border-slate-100 transition-all hover:bg-white hover:shadow-sm">
                                        <span class="w-3 h-3 rounded-full shadow-sm" style="background-color: {{ $this->getColor($kandidat['nomor_urut']) }}"></span>
                                        <span class="text-[10px] font-black text-slate-600 uppercase tracking-wider">
                                            {{ $kandidat['nama_kandidat'] }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="lg:col-span-7 space-y-5">
                            <h3 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.3em] mb-6 flex items-center gap-3">
                                <span class="h-px w-8 bg-slate-200"></span>
                                Detail Perolehan
                            </h3>
                            
                            @foreach($data['kandidat'] as $i => $kandidat)
                                <div class="relative group bg-slate-50/50 p-4 rounded-3xl border border-transparent hover:border-slate-100 hover:bg-white transition-all duration-300">
                                    <div class="flex justify-between items-center mb-3">
                                        <div class="flex items-center gap-4">
                                            <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-sm font-black text-white shadow-lg transition-transform group-hover:scale-110"
                                                 style="background-color: {{ $this->getColor($kandidat['nomor_urut']) }}">
                                                {{ $kandidat['nomor_urut'] }}
                                            </div>
                                            <div>
                                                <p class="text-base font-black text-slate-800 leading-none mb-1">{{ $kandidat['nama_kandidat'] }}</p>
                                                <p class="text-[11px] text-slate-400 font-bold uppercase tracking-wider">{{ number_format($kandidat['suara_count']) }} Suara </p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <span class="text-2xl font-black text-slate-800">{{ $kandidat['persentase'] }}<span class="text-sm ml-0.5 text-slate-400">%</span></span>
                                        </div>
                                    </div>
                                    
                                    <div class="h-3 w-full bg-slate-100 rounded-full overflow-hidden p-0.5">
                                        <div class="h-full rounded-full transition-all duration-1000 ease-out shadow-sm"
                                             style="width: {{ $kandidat['persentase'] }}%; background-color: {{ $this->getColor($kandidat['nomor_urut']) }}">
                                        </div>
                                    </div>
                                    
                                    @if($i === 0 && $kandidat['suara_count'] > 0)
                                        <div class="absolute -top-2 -right-2 transform rotate-6">
                                            <span class="bg-emerald-500 text-white text-[10px] font-black px-3 py-1 rounded-xl shadow-lg uppercase tracking-tighter">Unggul</span>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="max-w-2xl mx-auto py-20 flex flex-col items-center justify-center bg-white rounded-[3rem] shadow-sm border border-dashed border-slate-300">
            </div>
    @endif
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>

<script>
/* =====================================================
   GLOBAL
===================================================== */
Chart.register(ChartDataLabels);

let doughnutCharts = new Map();
let lineCharts = new Map();
let slides = [];
let currentSlide = 0;
let slideInterval = null;

/* =====================================================
   HELPER : AUTO STEP (KECIL → BESAR)
===================================================== */
function getYAxisStep(maxValue) {
    if (maxValue <= 10)   return 1;
    if (maxValue <= 50)   return 5;
    if (maxValue <= 100)  return 10;
    if (maxValue <= 300)  return 25;
    if (maxValue <= 500)  return 50;
    if (maxValue <= 1000) return 100;
    return 250;
}

/* =====================================================
   DOUGHNUT CHART
===================================================== */
function renderDoughnutCharts() {
    document.querySelectorAll('.election-chart-canvas').forEach(canvas => {
        if (canvas.offsetParent === null) return;

        const ctx = canvas.getContext('2d');
        const labels = JSON.parse(canvas.dataset.labels || '[]');
        const values = JSON.parse(canvas.dataset.values || '[]');
        const colors = JSON.parse(canvas.dataset.colors || '[]');
        const total = values.reduce((a, b) => a + b, 0);

        if (doughnutCharts.has(canvas)) {
            doughnutCharts.get(canvas).destroy();
            doughnutCharts.delete(canvas);
        }

        const chart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels,
                datasets: [{
                    data: values,
                    backgroundColor: colors,
                    borderWidth: 6,
                    borderColor: '#ffffff',
                    hoverOffset: 18,
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '78%',
                plugins: {
                    legend: { display: false },
                    datalabels: {
                        color: '#fff',
                        font: { weight: '900', size: 11 },
                        formatter: value => {
                            if (!total) return null;
                            const percent = (value / total) * 100;
                            return percent > 8 ? percent.toFixed(1) + '%' : null;
                        }
                    },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        padding: 14,
                        cornerRadius: 12,
                        callbacks: {
                            label: ctx =>
                                `${ctx.label}: ${ctx.raw.toLocaleString()} suara`
                        }
                    }
                }
            }
        });

        doughnutCharts.set(canvas, chart);
    });
}

/* =====================================================
   LINE CHART (AUTO STEP)
===================================================== */
function renderLineCharts() {
    document.querySelectorAll('.line-chart-canvas').forEach(canvas => {
        if (canvas.offsetParent === null) return;

        const ctx = canvas.getContext('2d');
        const labels = JSON.parse(canvas.dataset.labels || '[]');
        const values = JSON.parse(canvas.dataset.values || '[]');
        const colors = JSON.parse(canvas.dataset.colors || '[]');

        if (lineCharts.has(canvas)) {
            lineCharts.get(canvas).destroy();
            lineCharts.delete(canvas);
        }

        const maxValue = Math.max(...values, 0);
        const step = getYAxisStep(maxValue);
        const roundedMax = Math.ceil(maxValue / step) * step;

        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels,
                datasets: [{
                    data: values,
                    borderColor: '#6366f1',
                    backgroundColor: 'rgba(99,102,241,0.15)',
                    pointBackgroundColor: colors,
                    pointBorderColor: '#ffffff',
                    pointRadius: 6,
                    tension: 0.35,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    datalabels: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: roundedMax,
                        ticks: {
                            stepSize: step,
                            precision: 0
                        }
                    }
                }
            }
        });

        lineCharts.set(canvas, chart);
    });
}

/* =====================================================
   SLIDE CONTROL
===================================================== */
function showSlide(index) {
    if (!slides.length) return;

    slides[currentSlide].style.display = 'none';
    currentSlide = index;
    slides[currentSlide].style.display = 'flex';

    const dropdown = document.getElementById('pemilihanDropdown');
    if (dropdown) dropdown.value = currentSlide;

    setTimeout(() => {
        renderDoughnutCharts();
        renderLineCharts();
    }, 120);
}

/* =====================================================
   AUTO ROTATE
===================================================== */
function startAutoRotate() {
    if (slideInterval) clearInterval(slideInterval);

    slideInterval = setInterval(() => {
        const next = (currentSlide + 1) % slides.length;
        showSlide(next);
    }, 10000);
}

/* =====================================================
   DROPDOWN
===================================================== */
function initDropdown() {
    const dropdown = document.getElementById('pemilihanDropdown');
    if (!dropdown) return;

    dropdown.addEventListener('change', e => {
        showSlide(parseInt(e.target.value, 10));
        startAutoRotate();
    });
}

/* =====================================================
   MASTER INIT (LIVEWIRE SAFE)
===================================================== */
function initAll() {
    slides = Array.from(document.querySelectorAll('.pemilihan-slide'));
    if (!slides.length) return;

    slides.forEach((s, i) => {
        s.style.display = i === 0 ? 'flex' : 'none';
    });

    currentSlide = 0;

    renderDoughnutCharts();
    renderLineCharts();
    initDropdown();
    startAutoRotate();
}

/* =====================================================
   EVENTS
===================================================== */
document.addEventListener('DOMContentLoaded', initAll);
document.addEventListener('livewire:load', initAll);
document.addEventListener('livewire:navigated', initAll);
</script>
