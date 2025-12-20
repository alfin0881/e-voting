<div class="space-y-6">

    <!-- Header -->
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Hasil Pemilihan</h1>
        <p class="text-gray-600 mt-1">Lihat hasil dan statistik pemilihan</p>
    </div>

    <!-- Filter Pemilihan -->
    <div class="bg-white rounded-2xl shadow-lg p-6">
        <label class="block text-sm font-semibold text-gray-700 mb-3">Pilih Pemilihan:</label>

        <select wire:model.live="pemilihanDipilih"
                class="w-full max-w-lg px-4 py-3 rounded-xl border-2 border-gray-200 
                       focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 
                       outline-none transition">
            <option value="">-- Pilih Pemilihan --</option>
            @foreach ($pemilihanList as $p)
                <option value="{{ $p->id }}">{{ $p->nama_pemilihan }}</option>
            @endforeach
        </select>
    </div>

    @if (!empty($hasilData))

        <div class="space-y-6">

            <!-- Info Card -->
            <div class="bg-gradient-to-br from-indigo-500 to-violet-600 rounded-2xl shadow-xl p-8 text-white">
                <div class="flex items-center justify-between mb-6">

                    <div>
                        <h2 class="text-2xl font-bold">
                            {{ $hasilData['pemilihan']['nama_pemilihan'] }}
                        </h2>

                        <p class="text-indigo-100 mt-1">
                            {{ \Carbon\Carbon::parse($hasilData['pemilihan']['tanggal_mulai'])->format('d M Y') }}
                            -
                            {{ \Carbon\Carbon::parse($hasilData['pemilihan']['tanggal_selesai'])->format('d M Y') }}
                        </p>
                    </div>

                    <div class="text-right">
                        <p class="text-indigo-100 text-sm">Total Suara Masuk</p>
                        <p class="text-5xl font-bold">{{ $hasilData['total_suara'] }}</p>
                    </div>

                </div>
            </div>

           <!-- Peringkat & Stats -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- Peringkat  --}}
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="font-bold text-lg text-gray-800 mb-6">Peringkat Kandidat</h3>
                    <div class="space-y-4">
                        @foreach($hasilData['kandidat'] as $index => $kandidat)
                            <div class="flex items-center gap-4 p-4 rounded-xl border-2 
                                {{ $index === 0 ? 'border-yellow-400 bg-yellow-50' : 'border-gray-200' }}">

                                {{-- Peringkat  --}}
                                <div class="flex-shrink-0">
                                    @if($index === 0)
                                        <div class="w-12 h-12 bg-gradient-to-br from-yellow-400 to-yellow-500 rounded-xl flex items-center justify-center shadow-lg">
                                            <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        </div>
                                    @else
                                        <div class="w-12 h-12 bg-gray-200 rounded-xl flex items-center justify-center">
                                            <span class="text-xl font-bold text-gray-600">{{ $index + 1 }}</span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Info -->
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="px-2 py-0.5 bg-indigo-100 text-indigo-700 rounded text-xs font-bold">
                                            No. {{ $kandidat['nomor_urut'] }}
                                        </span>
                                        <p class="font-bold text-gray-800">{{ $kandidat['nama_kandidat'] }}</p>
                                    </div>
                                    
                                    <!-- Progress -->
                                    <div class="mt-2">
                                        <div class="flex items-center justify-between text-sm mb-1">
                                            <span class="text-gray-600">{{ $kandidat['suara_count'] }} suara</span>
                                            <span class="font-semibold text-indigo-600">{{ $kandidat['persentase'] }}%</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                                            <div class="h-full bg-gradient-to-r from-indigo-500 to-violet-600 rounded-full"
                                                style="width: {{ $kandidat['persentase'] }}%"></div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Detail Kandidat -->
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="font-bold text-lg text-gray-800 mb-6">Detail Kandidat</h3>
                    <div class="grid grid-cols-1 md:grid-cols-1 gap-6">
                        @foreach($hasilData['kandidat'] as $kandidat)
                            <div class="border-2 border-gray-200 rounded-xl p-5 hover:border-indigo-300 transition">
                                <div class="flex items-start gap-3 mb-4">
                                    <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-violet-600 rounded-xl flex items-center justify-center">
                                        <span class="text-white font-bold text-lg">{{ $kandidat['nomor_urut'] }}</span>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-gray-800">{{ $kandidat['nama_kandidat'] }}</h4>
                                        <p class="text-sm text-indigo-600 font-semibold">
                                            {{ $kandidat['suara_count'] }} suara ({{ $kandidat['persentase'] }}%)
                                        </p>
                                    </div>
                                </div>

                                @if(!empty($kandidat['visi']))
                                    <div class="mb-3">
                                        <p class="text-xs font-semibold text-gray-500 mb-1">VISI</p>
                                        <p class="text-sm text-gray-700">{{ $kandidat['visi'] }}</p>
                                    </div>
                                @endif

                                @if(!empty($kandidat['misi']))
                                    <div>
                                        <p class="text-xs font-semibold text-gray-500 mb-1">MISI</p>
                                        <p class="text-sm text-gray-700">{{ $kandidat['misi'] }}</p>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>

        </div>

    @else

        <!-- Empty State -->
        <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
            </div>
            <p class="text-gray-500 font-medium">Pilih pemilihan untuk melihat hasil</p>
        </div>

    @endif

</div>
