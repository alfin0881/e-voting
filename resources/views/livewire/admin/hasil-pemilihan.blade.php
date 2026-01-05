<div>
<style>
    .detail-item {
        opacity: 0;
        transform: translateY(25px);
        transition: opacity .6s ease-out, transform .6s cubic-bezier(.16,1,.3,1);
    }
    .detail-item.show {
        opacity: 1;
        transform: translateY(0);
    }
    .progress-bar {
        width: 0%;
        transition: width 2s cubic-bezier(0.1, 1, 0.1, 1);
    }
    .pemilihan-slide {
        animation: fadeIn .5s ease-in;
    }
    
    @keyframes fadeIn { from {opacity:0} to {opacity:1} }
</style>

{{-- POLLING DATA (TIDAK LANGSUNG UPDATE UI) --}}
<div wire:poll.150s="checkUpdate"></div>

{{-- AUTO REFRESH DATA --}}
<div wire:poll.300s="reloadData"></div> 

<div wire:key="hasil-{{ count($allHasilData) }}">

{{-- HEADER --}}
    <div class="flex justify-between items-end">
        <div>
            <h1 class="text-3xl font-bold">Hasil Pemilihan</h1>
            <p class="text-gray-500 mt-1">
                Realtime Hasil Pemilihan
            </p>
        </div>

        <div class="flex flex-col md:flex-row items-end gap-4">
    {{-- DROPDOWN --}}
    <div class="w-full md:w-64">
        <select id="pemilihanDropdown"
                class="block w-full px-4 py-3 border-2 border-gray-200 rounded-xl
                       bg-white focus:outline-none focus:ring-4 focus:ring-indigo-100
                       focus:border-indigo-500 transition duration-150 sm:text-sm">
            @foreach($allHasilData as $i => $data)
                <option value="{{ $i }}">{{ $data['pemilihan']['nama_pemilihan'] }}</option>
            @endforeach
        </select>
    </div>

    {{-- BUTTON REFRESH --}}
    <div class="w-full md:w-38">
    <button
        wire:click="refreshNow"
        class="flex items-center justify-center gap-2 w-full px-4 py-3
                bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-xl
                border-2 border-gray-200 rounded-xl
                bg-white text-gray-700 font-semibold
                hover:bg-green-600 hover:border-gray-300 hover:text-white
                hover:shadow-xl transition duration-300 hover:scale-105 flex items-center
                focus:outline-none focus:ring-4 focus:ring-gray-100
                transition duration-150 sm:text-sm">
        <i data-feather="refresh-ccw"></i>
        <span>Refresh Data</span>
    </button>
</div>

</div>

    </div>


{{-- SLIDE --}}
<div class="max-w-7xl mx-auto">
@foreach($allHasilData as $index => $data)
<div class="pemilihan-slide bg-white rounded-3xl p-8 shadow"
     style="display: {{ $index === 0 ? 'block':'none' }}">

    <div class="flex justify-between mb-6">
        <h2 class="text-2xl font-bold">
            {{ $data['pemilihan']['nama_pemilihan'] }}
        </h2>
        <div class="text-right">
            <small class="text-gray-400">TOTAL SUARA</small>
            <div class="text-2xl font-black">
                {{ number_format($data['total_suara']) }}
            </div>
        </div>
    </div>

    <div class="grid lg:grid-cols-12 gap-10">

        {{-- CHART --}}
        <div class="lg:col-span-5"
             data-labels='@json(collect($data["kandidat"])->pluck("nama_kandidat"))'
             data-values='@json(collect($data["kandidat"])->pluck("suara_count"))'
             data-colors='@json(collect($data["kandidat"])->map(fn($k)=>$this->getColor($k["nomor_urut"])))'>
            <div class="h-72" wire:ignore>
                <canvas class="line-chart-canvas"></canvas>
            </div>
        </div>

        {{-- DETAIL --}}
        <div class="lg:col-span-7 space-y-4">
            @foreach($data['kandidat'] as $k)
            <div class="detail-item bg-slate-50 p-4 rounded-2xl">
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl text-white font-bold flex items-center justify-center"
                             style="background: {{ $this->getColor($k['nomor_urut']) }}">
                            {{ $k['nomor_urut'] }}
                        </div>
                        <div>
                            <strong>{{ $k['nama_kandidat'] }}</strong><br>
                            <small>{{ number_format($k['suara_count']) }} suara</small>
                        </div>
                    </div>
                    <div class="text-xl font-bold">{{ $k['persentase'] }}%</div>
                </div>

                <div class="mt-3 h-2 bg-slate-200 rounded-full">
                    <div class="progress-bar h-full rounded-full"
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
    const ROTATE_INTERVAL = 10000;
    const BROWSER_REFRESH_INTERVAL = 300000; // 5 menit

    let currentSlide = 0;
    let charts = new Map();
    let rotateTimer = null;

    const safeJSON = (val, fallback = []) => {
        try { return JSON.parse(val); } catch { return fallback; }
    };

    function getYAxisStep(max) {
        if (max <= 10) return 1;
        if (max <= 50) return 5;
        if (max <= 100) return 10;
        if (max <= 500) return 50;
        if (max <= 2000) return 200;
        return Math.ceil(max / 10 / 10);
    }

    function renderChart(slide) {
        const wrapper = slide.querySelector('[data-labels]');
        const canvas  = slide.querySelector('.line-chart-canvas');
        if (!wrapper || !canvas) return;

        const labels = safeJSON(wrapper.dataset.labels);
        const values = safeJSON(wrapper.dataset.values);
        const colors = safeJSON(wrapper.dataset.colors);
        if (!labels.length) return;

        // destroy chart lama
        if (charts.has(canvas)) {
            charts.get(canvas).destroy();
            charts.delete(canvas);
        }

        const maxVal = Math.max(...values, 0);
        const step   = getYAxisStep(maxVal);
        const yMax   = Math.ceil((maxVal + step) / step) * step;

        const ctx = canvas.getContext('2d');

        /* ===== GRADIENT FILL ===== */
        const gradient = ctx.createLinearGradient(0, 0, 0, canvas.height);
        gradient.addColorStop(0, 'rgba(99,102,241,.35)');
        gradient.addColorStop(1, 'rgba(99,102,241,0)');

        /* ===== START FROM ZERO ===== */
        const zeroData = values.map(() => 0);

        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels,
                datasets: [{
                    data: zeroData,
                    borderColor: '#6366f1',
                    backgroundColor: gradient,
                    pointBackgroundColor: colors,
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 0,
                    pointHoverRadius: 8,
                    tension: 0,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    duration: 4000,
                    easing: 'easeOutBack'
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: yMax,
                        ticks: {
                            stepSize: step,
                            precision: 0
                        }
                    },
                    x: {
                        grid: { display: false }
                    }
                },
                plugins: {
                    legend: { display: false }
                }
            }
        });

        charts.set(canvas, chart);

        /* ===== ANIMATE TO REAL DATA ===== */
        setTimeout(() => {
            chart.data.datasets[0].data = values;
            chart.data.datasets[0].pointRadius = 6;
            chart.update();
        }, 120);
    }


    function showSlide(index = 0) {
        const slides = document.querySelectorAll('.pemilihan-slide');
        if (!slides.length) return;

        currentSlide = (index + slides.length) % slides.length;

        slides.forEach((slide, i) => {
            slide.style.display = i === currentSlide ? 'block' : 'none';
            if (i !== currentSlide) return;

            const items = slide.querySelectorAll('.detail-item');
            const bars  = slide.querySelectorAll('.progress-bar');

            items.forEach(el => el.classList.remove('show'));
            bars.forEach(el => el.style.width = '0%');

            setTimeout(() => {
                items.forEach((el, n) =>
                    setTimeout(() => el.classList.add('show'), n * 60)
                );
                bars.forEach(el => el.style.width = el.dataset.width || '0%');
                renderChart(slide);
            }, 100);
        });

        const dropdown = document.getElementById('pemilihanDropdown');
        if (dropdown) dropdown.value = currentSlide;
    }

    function startAutoRotate() {
        stopAutoRotate();
        rotateTimer = setInterval(() => showSlide(currentSlide + 1), ROTATE_INTERVAL);
    }

    function stopAutoRotate() {
        if (rotateTimer) clearInterval(rotateTimer);
    }

    document.addEventListener('DOMContentLoaded', () => {
        showSlide(0);
        startAutoRotate();

        document.getElementById('pemilihanDropdown')
            ?.addEventListener('change', e => {
                stopAutoRotate();
                showSlide(parseInt(e.target.value));
                startAutoRotate();
            });

        // 🔥 AUTO REFRESH BROWSER
        setInterval(() => {
            location.reload();
        }, BROWSER_REFRESH_INTERVAL);
    });

    document.addEventListener('livewire:message.processed', () => {
        charts.forEach(c => c.destroy());
        charts.clear();
        showSlide(currentSlide);
        startAutoRotate();
    });
</script>
