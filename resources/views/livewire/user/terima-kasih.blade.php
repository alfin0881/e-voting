<div class="min-h-[70vh] flex items-center justify-center">
    <div class="max-w-2xl mx-auto text-center animate-scale-up">
        <!-- Success Icon -->
        <div class="mb-8">
            <div class="w-32 h-32 bg-gradient-to-br from-green-400 to-emerald-500 rounded-full flex items-center justify-center mx-auto shadow-2xl animate-bounce">
                <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
        </div>

        <!-- Message -->
        <div class="bg-white rounded-3xl shadow-2xl p-12 mb-8">
            <h1 class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent mb-4">
                Terima Kasih!
            </h1>
            <p class="text-xl text-gray-600 mb-6">
                Suara Anda telah berhasil tercatat.
            </p>
            
            <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl p-6 mb-6 border-2 border-green-200">
                <div class="flex items-center justify-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div class="text-left">
                        <p class="text-sm text-gray-600">Pemilih:</p>
                        <p class="font-bold text-gray-800">{{ auth()->user()->nama }}</p>
                        <p class="text-xs text-gray-500">NIS: {{ auth()->user()->nis }}</p>
                    </div>
                </div>

                <div class="flex items-center justify-center gap-2 text-sm text-green-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Terekam pada: {{ now()->timezone(value: 'Asia/Jakarta')->format(format: 'd M Y H:i') }} WIB</span>                </div>
            </div>

            <div class="space-y-3 text-left">
                <div class="flex items-start gap-3 text-gray-700">
                    <svg class="w-6 h-6 text-green-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-sm">Pilihan Anda telah disimpan dengan aman dan terenkripsi</p>
                </div>
                
                <div class="flex items-start gap-3 text-gray-700">
                    <svg class="w-6 h-6 text-green-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    <p class="text-sm">Identitas Anda dijaga kerahasiaannya</p>
                </div>
                
                <div class="flex items-start gap-3 text-gray-700">
                    <svg class="w-6 h-6 text-green-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    <p class="text-sm">Hasil akan diumumkan setelah pemilihan selesai</p>
                </div>
            </div>
        </div>


        <!-- Actions -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('user.daftar-pemilihan') }}" 
               class="px-8 py-4 bg-gradient-to-r from-indigo-600 to-violet-600 text-white rounded-xl font-bold hover:shadow-xl transition duration-300 hover:scale-105 inline-flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Kembali ke Beranda
            </a>
        </div>

        <!-- Footer Note -->
        <div class="mt-12 text-sm text-gray-500">
            <p>Jika ada pertanyaan atau terjadi masalah, silahkan hubungi mas Admin (MalfinZ).</p>
        </div>
    </div>
</div>