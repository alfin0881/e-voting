<div class="space-y-8">
    <!-- Welcome Banner -->
    <div class="bg-gradient-to-br from-violet-500 via-indigo-500 to-blue-800 rounded-3xl shadow-2xl p-8 md:p-12 text-white animate-fade-in">
        <div class="flex items-center justify-between flex-wrap gap-6">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold mb-2">Selamat Datang!👋</h1>
                <p class="text-indigo-100 text-lg">{{ auth()->user()->nama }}</p>
                <p class="text-indigo-200 text-sm mt-1">NIS: {{ auth()->user()->nis }} • {{ auth()->user()->kelas }}</p>
            </div>
            <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-6 text-center">
                <p class="text-indigo-100 text-sm">Pemilihan Tersedia</p>
                <p class="text-4xl font-bold mt-1">{{ $pemilihanList->count() }}</p>
            </div>
        </div>
    </div>

    <!-- Info -->
    @if($pemilihanList->count() > 0)
        <div class="bg-blue-50 border-2 border-blue-200 rounded-2xl p-6 flex items-start gap-4 animate-slide-up">
            <div class="flex-shrink-0 w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <h3 class="font-bold text-blue-900 mb-1">Informasi Penting</h3>
                <ul class="text-blue-800 text-sm space-y-1">
                    <li>• Pilih salah satu kandidat dengan bijak</li>
                    <li>• Anda hanya bisa memilih <b>satu kali (1x) </b>untuk setiap organisasi/ekstrakulikuler</li>
                    <li>• Keputusan Anda bersifat final dan tidak dapat diubah</li>
                </ul>
            </div>
        </div>
    @endif

    <!-- Daftar Pemilihan -->
    @if($pemilihanList->count() > 0)
        <div class="space-y-4">
            <h2 class="text-2xl font-bold text-gray-800">Pemilihan Tersedia</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($pemilihanList as $pemilihan)
                    @php
                        $sudahMemilih = auth()->user()->sudahMemilih($pemilihan->id);
                    @endphp
                    
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-300 hover:scale-105 group">
                        <!-- Header Card -->
                        <div class="relative h-48 bg-gradient-to-br from-violet-500 via-blue-500 to-sky-800 p-6 flex flex-col justify-between">
                            
                            <!-- Status Badge -->
                            <div class="flex items-center gap-2">
                                @if($sudahMemilih)
                                    <span class="px-3 py-1.5 bg-green-500 text-white rounded-full text-xs font-bold flex items-center gap-1 shadow-lg">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        Sudah Memilih
                                    </span>
                                @else
                                    <span class="px-3 py-1.5 bg-yellow-400 text-yellow-900 rounded-full text-xs font-bold shadow-lg">
                                        Belum Memilih
                                    </span>
                                @endif
                            </div>
                            
                            <!-- Title -->
                            <div class="text-white">
                                <h3 class="text-3xl font-bold mb-2 line-clamp-2">{{ $pemilihan->nama_pemilihan }}</h3>
                            </div>
                        </div>

                        <!-- Body Card -->
                        <div class="p-6">
                            @if($pemilihan->deskripsi)
                                <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $pemilihan->deskripsi }}</p>
                            @endif
                            
                            <!-- Info -->
                            <div class="space-y-2 mb-4">
                                <div class="flex items-center gap-2 text-sm text-gray-600">
                                    <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span>{{ $pemilihan->tanggal_mulai->format('d M Y') }} - {{ $pemilihan->tanggal_selesai->format('d M Y') }}</span>
                                </div>
                                
                                <div class="flex items-center gap-2 text-sm text-gray-600">
                                    <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                    <span>{{ $pemilihan->kandidat->count() }} Kandidat</span>
                                </div>
                            </div>

                            <!-- Button -->
                            @if($sudahMemilih)
                                <div class="flex items-center justify-center gap-2 py-3 px-6 bg-green-100 text-green-700 rounded-xl font-semibold">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Terima Kasih Sudah Memilih
                                </div>
                            @else
                                <a href="{{ route('user.lihat-kandidat', $pemilihan->id) }}" 
                                   class="block text-center py-3 px-6 bg-gradient-to-r from-indigo-600 to-violet-600 text-white rounded-xl font-semibold hover:shadow-xl transition duration-300 hover:scale-105">
                                    Mulai Memilih →
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-white rounded-2xl shadow-lg p-12 text-center animate-scale-up">
            <div class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Belum Ada Pemilihan</h3>
            <p class="text-gray-500">Saat ini tidak ada pemilihan yang aktif untuk Anda.</p>
            <p class="text-gray-400 text-sm mt-2">Silahkan hubungi mas Admin (MalfinZ).</p>
        </div>
    @endif
</div>