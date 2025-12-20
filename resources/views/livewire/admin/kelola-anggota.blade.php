<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Kelola Siswa</h1>
            <p class="text-gray-600 mt-1">Atur dan kelola siswa pemilih</p>
        </div>
        <button wire:click="bukaTambah" 
                class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-violet-600 text-white rounded-xl font-semibold hover:shadow-xl transition duration-300 hover:scale-105 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Tambah Siswa
        </button>
    </div>

    <div class="bg-white rounded-2xl shadow-lg p-6 space-y-4">
        <h3 class="font-bold text-lg text-gray-700">Opsi Filter Data</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Cari Nama</label>
                <input type="text" wire:model.live.debounce.300ms="filterNama" 
                       placeholder="Cari berdasarkan nama..."
                       class="w-full px-3 py-2 border rounded-xl focus:border-indigo-500 focus:ring focus:ring-indigo-100 transition">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Cari NIS</label>
                <input type="text" wire:model.live.debounce.300ms="filterNis" 
                       placeholder="Cari berdasarkan NIS..."
                       class="w-full px-3 py-2 border rounded-xl focus:border-indigo-500 focus:ring focus:ring-indigo-100 transition">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Filter Kelas</label>
                <select wire:model.live="filterKelas"
                        class="w-full px-3 py-2 border rounded-xl focus:border-indigo-500 focus:ring focus:ring-indigo-100 transition">
                    <option value="">-- Semua Kelas --</option>
                    @foreach($kelasList as $kelas)
                        <option value="{{ $kelas }}">{{ $kelas }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        @if(count($activeFilters) > 0)
            <div class="pt-4 border-t border-gray-100">
                <div class="flex items-center flex-wrap gap-2">
                    <p class="text-sm font-semibold text-gray-600 mr-2">Filter Aktif:</p>
                    @foreach($activeFilters as $filter)
                        <span class="inline-flex items-center gap-1.5 py-1 px-3 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                            {{ $filter['name'] }}: {{ $filter['value'] }}
                            <button wire:click="{{ $filter['method'] }}" type="button" class="flex-shrink-0 size-4 rounded-full inline-flex items-center justify-center hover:bg-indigo-200">
                                <svg class="size-3" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4 4L12 12M4 12L12 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </span>
                    @endforeach
                    <button wire:click="hapusSemuaFilter" class="text-sm text-red-600 hover:text-red-800 ml-2 transition">
                        Hapus Semua
                    </button>
                </div>
            </div>
        @endif
    </div>

    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-indigo-500 to-violet-600 text-white">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold">No</th>
                        
                        <th class="px-6 py-4 text-left text-sm font-semibold">
                            <button wire:click="sortBy('nis')" class="flex items-center gap-1.5">
                                NIS
                                @if($sortField === 'nis')
                                    @if($sortDirection === 'asc')
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/></svg>
                                    @else
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                    @endif
                                @endif
                            </button>
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold">
                            <button wire:click="sortBy('nama')" class="flex items-center gap-1.5">
                                Nama
                                @if($sortField === 'nama')
                                    @if($sortDirection === 'asc')
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/></svg>
                                    @else
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                    @endif
                                @endif
                            </button>
                        </th>
                        
                        <th class="px-6 py-4 text-left text-sm font-semibold">
                            <button wire:click="sortBy('kelas')" class="flex items-center gap-1.5">
                                Kelas
                                @if($sortField === 'kelas')
                                    @if($sortDirection === 'asc')
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/></svg>
                                    @else
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                    @endif
                                @endif
                            </button>
                        </th>
                        
                        <th class="px-6 py-4 text-left text-sm font-semibold">Pemilihan Diikuti</th>
                        <th class="px-6 py-4 text-center text-sm font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($anggotaList as $index => $anggota)
                        <tr class="hover:bg-indigo-50 transition duration-200">
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $index + 1 }}</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-lg font-semibold text-sm">
                                    {{ $anggota->nis }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-semibold text-gray-800">{{ $anggota->nama }}</p>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $anggota->kelas ?? '-' }}
                            </td>
                            <td class="px-6 py-4">
                                @if($anggota->pemilihanDiikuti->count() > 0)
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($anggota->pemilihanDiikuti as $p)
                                            <span class="px-2 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-medium" title="{{ $p->nama_pemilihan }}">
                                                {{ Str::limit($p->nama_pemilihan, 20) }}
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-gray-400 text-sm">Belum mengikuti pemilihan</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <button wire:click="bukaPeserta({{ $anggota->id }})"
                                            class="p-2 bg-green-100 text-green-600 rounded-lg hover:bg-green-200 transition duration-200"
                                            title="Atur Pemilihan">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                        </svg>
                                    </button>
                                    <button wire:click="bukaEdit({{ $anggota->id }})"
                                            class="p-2 bg-blue-100 text-blue-600 rounded-lg hover:bg-blue-200 transition duration-200" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </button>
                                    <button wire:click="hapus({{ $anggota->id }})"
                                            wire:confirm="Apakah Anda yakin ingin menghapus siswa ini?"
                                            class="p-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition duration-200" title="Hapus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                        </svg>
                                    </div>
                                    <p class="text-gray-500 font-medium">
                                        @if(count($activeFilters) > 0)
                                            Tidak ada siswa yang cocok dengan filter saat ini.
                                        @else
                                            Belum ada data siswa.
                                        @endif
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($modalTambah)
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 p-4 animate-fade-in">
            <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full animate-scale-up">
                <div class="bg-gradient-to-r from-indigo-600 to-violet-600 text-white px-6 py-4 rounded-t-2xl">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-bold">Tambah Siswa Baru</h3>
                        <button wire:click="$set('modalTambah', false)" class="text-white hover:bg-white/20 p-2 rounded-lg transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <form wire:submit="simpan" class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap *</label>
                        <input type="text" wire:model="nama" 
                               class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 outline-none transition"
                               placeholder="Nama lengkap siswa">
                        @error('nama') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">NIS *</label>
                        <input type="text" wire:model="nis" 
                               class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 outline-none transition"
                               placeholder="Nomor Induk Siswa">
                        @error('nis') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Kelas</label>
                        <input type="text" wire:model="kelas" 
                               class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 outline-none transition"
                               placeholder="Contoh: XII RPL 1">
                        @error('kelas') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Password *</label>
                        <input type="password" wire:model="password" 
                               class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 outline-none transition"
                               placeholder="Password login">
                        @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        <p class="mt-1 text-xs text-gray-500">Samakan dengan NIS</p>
                    </div>

                    <div class="flex gap-3 pt-4">
                        <button type="submit"
                                class="flex-1 py-3 bg-gradient-to-r from-indigo-600 to-violet-600 text-white rounded-xl font-semibold hover:shadow-lg transition duration-300">
                            Simpan
                        </button>
                        <button type="button" wire:click="$set('modalTambah', false)"
                                class="px-6 py-3 bg-gray-200 text-gray-700 rounded-xl font-semibold hover:bg-gray-300 transition duration-300">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    @if($modalEdit)
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 p-4 animate-fade-in">
            <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full animate-scale-up">
                <div class="bg-gradient-to-r from-indigo-600 to-violet-600 text-white px-6 py-4 rounded-t-2xl">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-bold">Edit Siswa</h3>
                        <button wire:click="$set('modalEdit', false)" class="text-white hover:bg-white/20 p-2 rounded-lg transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <form wire:submit="perbarui" class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap *</label>
                        <input type="text" wire:model="nama" 
                               class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 outline-none transition">
                        @error('nama') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">NIS *</label>
                        <input type="text" wire:model="nis" 
                               class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 outline-none transition">
                        @error('nis') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Kelas</label>
                        <input type="text" wire:model="kelas" 
                               class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 outline-none transition">
                        @error('kelas') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Password Baru (Opsional)</label>
                        <input type="password" wire:model="password" 
                               class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 outline-none transition"
                               placeholder="Kosongkan jika tidak ingin mengubah">
                        @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex gap-3 pt-4">
                        <button type="submit"
                                class="flex-1 py-3 bg-gradient-to-r from-indigo-600 to-violet-600 text-white rounded-xl font-semibold hover:shadow-lg transition duration-300">
                            Perbarui
                        </button>
                        <button type="button" wire:click="$set('modalEdit', false)"
                                class="px-6 py-3 bg-gray-200 text-gray-700 rounded-xl font-semibold hover:bg-gray-300 transition duration-300">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    @if($modalPeserta && $userDipilih)
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 p-4 animate-fade-in">
            <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full animate-scale-up">
                <div class="bg-gradient-to-r from-indigo-600 to-violet-600 text-white px-6 py-4 rounded-t-2xl">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-xl font-bold">Atur Pemilihan</h3>
                            <p class="text-indigo-100 text-sm">{{ $userDipilih->nama }}</p>
                        </div>
                        <button wire:click="$set('modalPeserta', false)" class="text-white hover:bg-white/20 p-2 rounded-lg transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <form wire:submit="simpanPeserta" class="p-6 space-y-4">
                    <p class="text-sm text-gray-600 mb-4">Pilih pemilihan yang akan diikuti oleh siswa ini:</p>
                    
                    <div class="space-y-3 max-h-80 overflow-y-auto pr-2">
                        @foreach($pemilihanList as $pemilihan)
                            <label class="flex items-start gap-3 p-4 border-2 rounded-xl cursor-pointer transition {{ in_array($pemilihan->id, $pemilihanTerpilih) ? 'border-indigo-500 bg-indigo-50' : 'border-gray-200 hover:border-indigo-300' }}">
                                <input type="checkbox" 
                                        wire:model="pemilihanTerpilih" 
                                        value="{{ $pemilihan->id }}"
                                        class="mt-1 w-5 h-5 text-indigo-600 rounded focus:ring-indigo-500">
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-800">{{ $pemilihan->nama_pemilihan }}</p>
                                    <p class="text-sm text-gray-500">{{ $pemilihan->tanggal_mulai->format('d M Y') }} - {{ $pemilihan->tanggal_selesai->format('d M Y') }}</p>
                                    <span class="inline-block mt-2 px-2 py-1 rounded-full text-xs font-semibold {{ $pemilihan->status === 'aktif' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                                        {{ ucfirst($pemilihan->status) }}
                                    </span>
                                </div>
                            </label>
                        @endforeach
                    </div>

                    <div class="flex gap-3 pt-4">
                        <button type="submit"
                                class="flex-1 py-3 bg-gradient-to-r from-indigo-600 to-violet-600 text-white rounded-xl font-semibold hover:shadow-lg transition duration-300">
                            Simpan
                        </button>
                        <button type="button" wire:click="$set('modalPeserta', false)"
                                class="px-6 py-3 bg-gray-200 text-gray-700 rounded-xl font-semibold hover:bg-gray-300 transition duration-300">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>