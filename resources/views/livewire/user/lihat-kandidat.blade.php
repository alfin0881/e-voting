<div class="space-y-10 py-6">

    <div class="flex items-center gap-2 text-base font-semibold animate-fade-in">
        <a href="{{ route('user.daftar-pemilihan') }}" class="text-gray-500 hover:text-indigo-600 transition duration-150">
            <svg class="w-5 h-5 inline-block -mt-0.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Daftar Pemilihan
        </a>
    </div>
    
    <div class="text-center">
        <h2 class="text-3xl font-extrabold text-gray-800 pb-2 border-b-4 border-neutral-600/50 w-fit mx-auto">
            Daftar Kandidat {{ $pemilihan->nama_pemilihan }}
        </h2>
    </div>

    @if($sudahMemilih)
        <div class="bg-green-50 border-2 border-green-300 rounded-2xl p-6 flex items-start gap-4 animate-fade-in shadow-lg">
            <div class="flex-shrink-0 w-10 h-10 bg-green-500 rounded-full flex items-center justify-center mt-0.5">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <div>
                <h3 class="font-bold text-lg text-green-900 mb-1">Anda Sudah Memberikan Suara</h3>
                <p class="text-green-700 text-base">Pilihan Anda telah tercatat dengan aman. Terima kasih atas partisipasi Anda dalam pemilihan ini.</p>
            </div>
        </div>
    @else
        <div class="bg-yellow-50 border-2 border-yellow-300 rounded-2xl p-6 flex items-start gap-4 animate-fade-in shadow-lg">
            <div class="flex-shrink-0 w-10 h-10 bg-yellow-400 rounded-full flex items-center justify-center mt-0.5">
                <svg class="w-5 h-5 text-yellow-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div>
                <h3 class="font-bold text-lg text-yellow-900 mb-1">Perhatian Penting!</h3>
                <p class="text-yellow-800 text-base">Keputusan Anda bersifat final. Setelah Anda memilih salah satu kandidat, **pilihan tidak dapat diubah lagi**.</p>
            </div>
        </div>
    @endif

    <div class="space-y-6 pt-4">
        @php
            $kandidatCount = $kandidatList->count();
            
            // Logika Kondisional untuk Grid
            $gridClass = 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8';
            $wrapperClass = ''; // Default wrapper full width
            
            if ($kandidatCount === 2) {
                // 2 Kandidat: Tampil 2 kolom, dibatasi max-w-4xl dan di-rata tengah
                $gridClass = 'grid grid-cols-1 md:grid-cols-2 gap-8';
                $wrapperClass = 'max-w-4xl mx-auto'; 
            } elseif ($kandidatCount === 1) {
                // 1 Kandidat: Tampil 1 kolom, dibatasi max-w-xl dan di-rata tengah
                $gridClass = 'grid grid-cols-1 gap-8';
                $wrapperClass = 'max-w-xl mx-auto'; 
            }
            // 3 atau lebih: Default (3 kolom, full width)
        @endphp

        <div class="{{ $wrapperClass }}">
            <div class="{{ $gridClass }}">
                @foreach($kandidatList as $kandidat)
                    <div class="bg-white rounded-3xl shadow-xl overflow-hidden flex flex-col {{ !$sudahMemilih ? 'hover:shadow-indigo-400/50 hover:scale-[1.01] cursor-pointer' : 'shadow-gray-300' }} transition duration-500 group border-4 border-white">
                        
                        <div class="relative h-80 bg-gradient-to-br from-indigo-50 to-violet-100 overflow-hidden">
                            @if($kandidat->foto)
                                <img src="{{ Storage::url($kandidat->foto) }}" 
                                    alt="{{ $kandidat->nama_kandidat }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-32 h-32 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                            @endif
                            
                            <div class="absolute top-4 right-4 w-16 h-16 bg-gradient-to-tr from-indigo-600 to-violet-700 rounded-full flex items-center justify-center shadow-2xl transform group-hover:rotate-9 transition duration-300 border-4 border-white">
                                <span class="text-white font-extrabold text-3xl">{{ $kandidat->nomor_urut }}</span>
                            </div>
                        </div>

                        <div class="p-6 text-center flex flex-col flex-1">
                            <h3 class="font-extrabold text-2xl text-gray-900 mb-4">{{ $kandidat->nama_kandidat }}</h3>
                            
                            <div class="flex-1 space-y-4 mb-6"> 
                                @if($kandidat->visi)
                                    <div class="text-left bg-indigo-50 p-4 rounded-xl border border-indigo-200">
                                        <div class="flex items-center gap-2 mb-2">
                                            <div class="w-6 h-6 bg-indigo-200 rounded-full flex items-center justify-center flex-shrink-0">
                                                <svg class="w-4 h-4 text-indigo-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                            </div>
                                            <p class="text-sm font-bold text-indigo-700 uppercase tracking-wide">Visi</p>
                                        </div>
                                        <p class="text-sm text-gray-700 leading-relaxed">{{ $kandidat->visi }}</p>
                                    </div>
                                @endif
                                
                                @if($kandidat->misi)
                                    <div class="text-left bg-violet-50 p-4 rounded-xl border border-violet-200">
                                        <div class="flex items-center gap-2 mb-2">
                                            <div class="w-6 h-6 bg-violet-200 rounded-full flex items-center justify-center flex-shrink-0">
                                                <svg class="w-4 h-4 text-violet-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                                </svg>
                                            </div>
                                            <p class="text-sm font-bold text-violet-700 uppercase tracking-wide">Misi</p>
                                        </div>
                                        
                                        @php
                                            // Memecah string misi berdasarkan new line (\n)
                                            $misiPoin = array_filter(explode("\n", $kandidat->misi));
                                        @endphp

                                        <ul class="list-disc list-inside text-sm text-gray-700 space-y-2 pl-2">
                                            @foreach($misiPoin as $poin)
                                                <li>{{ trim($poin) }}</li>
                                            @endforeach
                                        </ul>

                                    </div>
                                @endif
                            </div>
                            
                            @if(!$sudahMemilih)
                                <button wire:click="bukaKonfirmasi({{ $kandidat->id }})"
                                        class="w-full py-3 bg-gradient-to-r from-indigo-600 to-violet-600 text-white rounded-xl font-bold text-base hover:shadow-2xl hover:shadow-indigo-500/50 transition duration-300 transform hover:scale-[1.03] flex items-center justify-center gap-2 group-hover:from-indigo-700 group-hover:to-violet-700 focus:outline-none focus:ring-4 focus:ring-indigo-500/50 mt-auto">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Pilih Kandidat Ini
                                </button>
                            @else
                                <div class="w-full py-3 bg-gray-100 text-gray-500 rounded-xl font-semibold text-center border-2 border-gray-200 mt-auto">
                                    Sudah Memberikan Suara
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @if($modalKonfirmasi && $kandidatDipilih)
        <div class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center z-50 p-4 animate-fade-in" x-data="{ open: @entangle('modalKonfirmasi') }" x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90">
            <div class="bg-white rounded-3xl shadow-2xl max-w-lg w-full">
                <div class="bg-gradient-to-r from-indigo-600 to-violet-600 text-white px-8 py-6 rounded-t-3xl border-b-4 border-white/30">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-extrabold">Konfirmasi Pilihan Anda</h3>
                            <p class="text-indigo-100 text-sm">Pilih dengan bijak, tidak ada pengembalian.</p>
                        </div>
                    </div>
                </div>

                <div class="p-8">
                    <div class="bg-indigo-50 rounded-2xl p-6 mb-6 border border-indigo-200">
                        <p class="text-gray-600 mb-4 font-semibold">Anda akan memilih kandidat:</p>
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 bg-gradient-to-br from-indigo-600 to-violet-600 rounded-full flex items-center justify-center shadow-lg">
                                <span class="text-white font-extrabold text-3xl">{{ $kandidatDipilih->nomor_urut }}</span>
                            </div>
                            <div>
                                <p class="font-bold text-xl text-gray-900">{{ $kandidatDipilih->nama_kandidat }}</p>
                                <p class="text-sm text-gray-500">{{ $pemilihan->nama_pemilihan }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-amber-50 border-2 border-amber-300 rounded-2xl p-4 mb-6">
                    <div class="flex items-start gap-3">
                        <svg class="w-6 h-6 text-amber-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <div>
                            <p class="font-bold text-amber-900 text-base">Perhatian Penting!</p> 
                            <p class="text-amber-800 text-sm">Aksi ini tidak dapat dibatalkan. Setelah mengklik tombol <b>"Ya, Saya Pilih Sekarang"</b>, Anda tidak dapat mengubah suara Anda.</p>
                        </div>
                    </div>
                </div>

                    <div class="flex gap-4">
                        <button wire:click="pilih"
                                class="flex-1 py-4 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-xl font-bold hover:shadow-xl hover:shadow-green-500/50 transition duration-300 transform hover:scale-[1.02] flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Ya, Saya Pilih Sekarang
                        </button>
                        <button wire:click="$set('modalKonfirmasi', false)"
                                class="px-6 py-4 bg-gray-200 text-gray-700 rounded-xl font-semibold hover:bg-gray-300 transition duration-300 flex items-center justify-center">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>