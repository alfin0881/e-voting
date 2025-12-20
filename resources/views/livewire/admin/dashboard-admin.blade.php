<div class="space-y-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">
            Dashboard Admin
        </h1>
        <p class="text-gray-600 mt-1">
            Selamat datang, {{ auth()->user()->nama }}
        </p>
    </div>
    {{-- Statistik Singkat --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

        <div class="bg-gradient-to-br from-indigo-500 to-indigo-600
                    rounded-2xl p-6 text-white shadow-xl">
            <p class="text-indigo-100 text-lg">Total Pemilihan</p>
            <h3 class="text-4xl font-bold mt-2">{{ $totalPemilihan }}</h3>
        </div>

        <div class="bg-gradient-to-br from-violet-500 to-violet-600
                    rounded-2xl p-6 text-white shadow-xl">
            <p class="text-violet-100 text-lg">Total Siswa</p>
            <h3 class="text-4xl font-bold mt-2">{{ $totalUser }}</h3>
        </div>

        <div class="bg-gradient-to-br from-pink-500 to-pink-600
                    rounded-2xl p-6 text-white shadow-xl">
            <p class="text-pink-100 text-lg">Total Kandidat</p>
            <h3 class="text-4xl font-bold mt-2">{{ $totalKandidat }}</h3>
        </div>

        <div class="bg-gradient-to-br from-emerald-500 to-emerald-600
                    rounded-2xl p-6 text-white shadow-xl">
            <p class="text-emerald-100 text-lg">Total Suara Masuk</p>
            <h3 class="text-4xl font-bold mt-2">{{ $totalSuara }}</h3>
        </div>
    </div>

    <!-- PEMILIHAN AKTIF -->
    <div class="bg-white rounded-2xl shadow-xl p-6">

        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-gray-800">
                Pemilihan Aktif
            </h2>
            <span class="bg-green-100 text-green-700
                         px-4 py-1 rounded-full text-sm font-semibold">
                {{ $pemilihanAktif->count() }} Aktif
            </span>
        </div>

        @if($pemilihanAktif->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                @foreach($pemilihanAktif as $pemilihan)
                    <div class="border-2 border-indigo-100
                                rounded-xl p-5 hover:shadow-lg transition">

                        <span class="bg-green-100 text-green-700
                                     px-3 py-1 rounded-full text-xs font-semibold">
                            Aktif
                        </span>

                        <h3 class="font-bold text-gray-800 mt-3 mb-2">
                            {{ $pemilihan->nama_pemilihan }}
                        </h3>

                        <p class="text-sm text-gray-600">
                            {{ $pemilihan->tanggal_mulai->format('d M Y') }}
                            -
                            {{ $pemilihan->tanggal_selesai->format('d M Y') }}
                        </p>

                        <p class="mt-2 font-semibold text-indigo-600">
                            {{ $pemilihan->totalSuara() }} suara masuk
                        </p>
                    </div>
                @endforeach

            </div>
        @else
            <p class="text-center py-10 text-gray-500">
                Tidak ada pemilihan yang aktif
            </p>
        @endif
    </div>

</div>

