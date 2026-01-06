<div> {{-- ROOT ELEMENT TUNGGAL --}}
<style>
    .detail-item {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity .6s ease-out, transform .6s cubic-bezier(0.16, 1, 0.3, 1);
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
        animation: fadeIn .5s ease-in-out;
    }
    .highcharts-container, .highcharts-container svg {
        width: 100% !important;
        height: 100% !important;
    }
    @keyframes fadeIn { from {opacity:0} to {opacity:1} }
</style>

<div wire:poll.150s="checkUpdate"></div>
<div wire:poll.300s="reloadData"></div> 

<div wire:key="hasil-{{ count($allHasilData) }}" class="bg-slate-50 min-h-screen p-4 md:p-8">

{{-- HEADER --}}
    <div class="flex justify-between items-center mb-4">
        <div>
            <h1 class="text-xl font-bold text-slate-800 tracking-tight">Monitoring Realtime</h1>
        </div>
        <div class="flex items-center gap-3">
            <select id="pemilihanDropdown"
                    class="block px-4 py-1.5 border-2 border-slate-200 rounded-xl bg-white font-semibold text-slate-600 focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition text-xs">
                @foreach($allHasilData as $i => $data)
                    <option value="{{ $i }}">{{ $data['pemilihan']['nama_pemilihan'] }}</option>
                @endforeach
            </select>
        </div>
    </div>

{{-- SLIDE --}}
<div class="w-full">
@foreach($allHasilData as $index => $data)
<div class="pemilihan-slide bg-white rounded-3xl p-6 shadow-2xl border border-slate-100 min-h-[88vh] flex flex-col"
     style="display: {{ $index === 0 ? 'flex':'none' }}">

    <div class="flex justify-between items-center mb-2 border-b border-slate-50 pb-4">
        <h2 class="text-2xl font-black text-slate-700 tracking-tighter uppercase truncate mr-2">{{ $data['pemilihan']['nama_pemilihan'] }}</h2>
        <div class="text-right flex-shrink-0">
            <span class="text-[9px] font-bold text-slate-400 tracking-widest block uppercase">Total Suara</span>
            <div class="text-3xl font-black text-indigo-600 leading-none">{{ number_format($data['total_suara']) }}</div>
        </div>
    </div>

    <div class="flex-1 flex flex-col justify-between">
        
        {{-- CHART SECTION (FULL RUANG) --}}
        <div class="w-full flex-1 flex justify-center items-center"
            data-labels='@json(collect($data["kandidat"])->pluck("nama_kandidat"))'
            data-values='@json(collect($data["kandidat"])->pluck("suara_count"))'
            data-numbers='@json(collect($data["kandidat"])->pluck("nomor_urut"))'
            data-colors='@json(collect($data["kandidat"])->map(fn($k)=>$this->getColor($k["nomor_urut"])))'>
            <div class="w-full h-full min-h-[400px]" wire:ignore></div>
        </div>

        {{-- DETAIL SECTION (FLEKSIBEL DI TENGAH DENGAN ELLIPSIS) --}}
        <div class="flex flex-wrap justify-center items-center gap-4 mt-4 pb-2">
            @foreach($data['kandidat'] as $k)
            <div class="detail-item bg-white border border-slate-200 p-4 rounded-2xl shadow-md flex-1 min-w-[260px] max-w-[320px]">
                <div class="flex justify-between items-center mb-3 overflow-hidden">
                    <div class="flex items-center gap-3 overflow-hidden">
                        {{-- Nomor Urut --}}
                        <div class="flex-shrink-0 w-10 h-10 rounded-xl text-white font-black text-lg flex items-center justify-center shadow-sm"
                             style="background: {{ $this->getColor($k['nomor_urut']) }}">
                            {{ $k['nomor_urut'] }}
                        </div>
                        {{-- Nama dengan Truncate/Ellipsis --}}
                        <div class="overflow-hidden">
                            <div class="text-base font-bold text-slate-800 leading-tight truncate" title="{{ $k['nama_kandidat'] }}">
                                {{ $k['nama_kandidat'] }}
                            </div>
                            <div class="text-indigo-600 font-bold text-xs">
                                {{ number_format($k['suara_count']) }} <span class="text-slate-400 font-medium">Suara</span>
                            </div>
                        </div>
                    </div>
                    {{-- Persentase --}}
                    <div class="flex-shrink-0 text-2xl font-black text-slate-900 tabular-nums tracking-tighter ml-2">
                        {{ $k['persentase'] }}<span class="text-sm text-slate-400 font-bold">%</span>
                    </div>
                </div>

                {{-- Progress Bar --}}
                <div class="h-2 bg-slate-100 rounded-full overflow-hidden border border-slate-100">
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

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script>
    const ROTATE_INTERVAL = 5000;
    const BROWSER_REFRESH_INTERVAL = 300000;
    let currentSlide = 0;
    let rotateTimer = null;

    const safeJSON = (val, fallback = []) => {
        try { return typeof val === 'string' ? JSON.parse(val) : val; } catch { return fallback; }
    };

    function renderChart(slide) {
        const wrapper = slide.querySelector('[data-labels]');
        const container = slide.querySelector('.w-full.h-full');
        if (!wrapper || !container) return;

        const labels = safeJSON(wrapper.dataset.labels);
        const values = safeJSON(wrapper.dataset.values).map(Number);
        const numbers = safeJSON(wrapper.dataset.numbers);
        const colors = safeJSON(wrapper.dataset.colors);

        Highcharts.chart(container, {
            chart: {
                type: 'pie',
                backgroundColor: 'transparent',
                margin: [40, 140, 40, 140],
                options3d: {
                    enabled: true,
                    alpha: 45,
                    beta: 0,
                    depth: 85,
                    viewDistance: 25
                }
            },
            title: { text: null },
            plotOptions: {
                pie: {
                    size: '90%',
                    depth: 65,
                    center: ['50%', '50%'],
                    dataLabels: [
                        {
                            // DALAM: Persentase Saja
                            enabled: true,
                            distance: -60,
                            format: '{point.percentage:.0f}%',
                            style: {
                                fontSize: '26px',
                                color: '#ffffff',
                                textOutline: '3px rgba(0,0,0,0.4)',
                                fontWeight: 'bold'
                            }
                        },
                        {
                            // LUAR: Nama & No Urut dengan Ellipsis
                            enabled: true,
                            distance: 50,
                            format: '<span style="font-size:14px; color:#64748b">#{point.nomor_urut}</span><br><span style="font-size:13px; color:#1e293b; font-weight:bold">{point.name}</span>',
                            connectorColor: '#cbd5e1',
                            connectorWidth: 1.5,
                            connectorPadding: 8,
                            width: 150, // Membatasi lebar agar rapi
                            style: {
                                textOverflow: 'ellipsis'
                            }
                        }
                    ]
                }
            },
            series: [{ 
                name: 'Suara', 
                data: labels.map((l, i) => ({ 
                    name: l, 
                    y: values[i], 
                    color: colors[i],
                    nomor_urut: numbers[i]
                })) 
            }],
            credits: { enabled: false }
        });
    }

    function showSlide(index = 0) {
        const slides = document.querySelectorAll('.pemilihan-slide');
        if (!slides.length) return;
        currentSlide = (index + slides.length) % slides.length;

        slides.forEach((slide, i) => {
            slide.style.display = i === currentSlide ? 'flex' : 'none';
            if (i === currentSlide) {
                const items = slide.querySelectorAll('.detail-item');
                const bars  = slide.querySelectorAll('.progress-bar');
                items.forEach(el => el.classList.remove('show'));
                bars.forEach(el => el.style.width = '0%');

                setTimeout(() => {
                    renderChart(slide);
                    items.forEach((el, n) => setTimeout(() => el.classList.add('show'), n * 100));
                    bars.forEach(el => el.style.width = el.dataset.width || '0%');
                }, 150);
            }
        });
        const dropdown = document.getElementById('pemilihanDropdown');
        if (dropdown) dropdown.value = currentSlide;
    }

    function startAutoRotate() {
        stopAutoRotate();
        rotateTimer = setInterval(() => showSlide(currentSlide + 1), ROTATE_INTERVAL);
    }

    function stopAutoRotate() { if (rotateTimer) clearInterval(rotateTimer); }

    document.addEventListener('DOMContentLoaded', () => {
        showSlide(0);
        startAutoRotate();
        document.getElementById('pemilihanDropdown')?.addEventListener('change', e => {
            stopAutoRotate();
            showSlide(parseInt(e.target.value));
            startAutoRotate();
        });
        setInterval(() => location.reload(), BROWSER_REFRESH_INTERVAL);
    });

    document.addEventListener('livewire:message.processed', () => {
        const activeSlide = document.querySelectorAll('.pemilihan-slide')[currentSlide];
        if (activeSlide) renderChart(activeSlide);
    });
</script>
</div>s