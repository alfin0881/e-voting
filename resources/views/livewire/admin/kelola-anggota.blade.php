<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Kelola Anggota</h1>
            <p class="text-gray-600 mt-1">Atur dan kelola anggota pemilih</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <button wire:click="bukaImport" 
                    class="px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-xl font-semibold hover:shadow-xl transition duration-300 hover:scale-105 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                </svg>
                Import Excel
            </button>
            
            <button wire:click="bukaTambah" 
                    class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-violet-600 text-white rounded-xl font-semibold hover:shadow-xl transition duration-300 hover:scale-105 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Tambah Anggota
            </button>
        </div>
    </div>

    <div class="flex flex-col md:flex-row gap-4">
        <div class="relative flex-1">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <input wire:model.live="search" type="text" 
                   class="block w-full pl-10 pr-3 py-3 border-2 border-gray-200 rounded-xl leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition duration-150 sm:text-sm" 
                   placeholder="Cari Nama atau NIS anggota...">
        </div>

        <div class="w-full md:w-64">
            <select wire:model.live="filterKelas" 
                    class="block w-full px-4 py-3 border-2 border-gray-200 rounded-xl leading-5 bg-white focus:outline-none focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition duration-150 sm:text-sm">
                <option value="">Semua Kelas</option>
                @foreach($listKelas as $k)
                    <option value="{{ $k }}">{{ $k }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-indigo-500 to-violet-600 text-white">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold">No</th>
                        <th wire:click="sortBy('nis')" class="px-6 py-4 text-left text-sm font-semibold cursor-pointer hover:bg-white/10 transition flex items-center gap-1">
                            NIS
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/></svg>
                        </th>
                        <th wire:click="sortBy('nama')" class="px-6 py-4 text-left text-sm font-semibold cursor-pointer hover:bg-white/10 transition items-center gap-1">
                            <div class="flex items-center gap-1">
                                Nama
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/></svg>
                            </div>
                        </th>
                        <th wire:click="sortBy('kelas')" class="px-6 py-4 text-left text-sm font-semibold cursor-pointer hover:bg-white/10 transition items-center gap-1">
                            <div class="flex items-center gap-1">
                                Kelas
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/></svg>
                            </div>
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
                                            <span class="px-2 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-medium">
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
                                            class="p-2 bg-blue-100 text-blue-600 rounded-lg hover:bg-blue-200 transition duration-200"
                                            title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </button>
                                    
                                    <button wire:click="hapus({{ $anggota->id }})"
                                            wire:confirm="Apakah Anda yakin ingin menghapus anggota ini?"
                                            class="p-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition duration-200"
                                            title="Hapus">
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
                                    <p class="text-gray-500 font-medium">Belum ada data anggota</p>
                                    <p class="text-gray-400 text-sm mt-1">Klik "Tambah Anggota" atau "Import Excel" untuk memulai</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- ========== MODAL TAMBAH ANGGOTA ========== -->
    @if($modalTambah)
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 p-4 animate-fade-in">
            <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full animate-scale-up">
                <!-- Header Modal -->
                <div class="bg-gradient-to-r from-indigo-600 to-violet-600 text-white px-6 py-4 rounded-t-2xl">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-bold">Tambah Anggota Baru</h3>
                        <button wire:click="$set('modalTambah', false)" class="text-white hover:bg-white/20 p-2 rounded-lg transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Form -->
                <form wire:submit="simpan" class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap *</label>
                        <input type="text" wire:model="nama" 
                               class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 outline-none transition"
                               placeholder="Nama lengkap anggota">
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
                               placeholder="Contoh: XII IPA 1">
                        @error('kelas') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Password *</label>
                        <input type="password" wire:model="password" 
                               class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 outline-none transition"
                               placeholder="Password login">
                        @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        <p class="mt-1 text-xs text-gray-500">Samakan dengan NIS*</p>
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

    <!-- ========== MODAL EDIT ANGGOTA ========== -->
    @if($modalEdit)
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 p-4 animate-fade-in">
            <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full animate-scale-up">
                <!-- Header Modal -->
                <div class="bg-gradient-to-r from-indigo-600 to-violet-600 text-white px-6 py-4 rounded-t-2xl">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-bold">Edit Anggota</h3>
                        <button wire:click="$set('modalEdit', false)" class="text-white hover:bg-white/20 p-2 rounded-lg transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Form -->
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

    <!-- ========== MODAL ATUR PESERTA PEMILIHAN ========== -->
    @if($modalPeserta && $userDipilih)
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 p-4 animate-fade-in">
            <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full animate-scale-up">
                <!-- Header Modal -->
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

                <!-- Form -->
                <form wire:submit="simpanPeserta" class="p-6 space-y-4">
                    <p class="text-sm text-gray-600 mb-4">Pilih pemilihan yang akan diikuti oleh anggota ini:</p>
                    
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

    <!-- ========== MODAL IMPORT EXCEL ========== -->
    @if($modalImport)
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 p-4 animate-fade-in">
            <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto animate-scale-up">
                <!-- Header Modal -->
                <div class="sticky top-0 bg-gradient-to-r from-green-500 to-emerald-600 text-white px-6 py-4 rounded-t-2xl z-10">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold">Import Data Anggota</h3>
                                <p class="text-green-100 text-sm">Upload file Excel (.xlsx, .xls, .csv)</p>
                            </div>
                        </div>
                        <button wire:click="$set('modalImport', false)" class="text-white hover:bg-white/20 p-2 rounded-lg transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Form Import -->
                <form wire:submit="prosesImport" class="p-6 space-y-6">
                    <!-- Info Box -->
                    <div class="bg-blue-50 border-2 border-blue-200 rounded-xl p-4">
                        <div class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <p class="font-bold text-blue-900 mb-2">Format File Excel:</p>
                                <ul class="text-blue-800 text-sm space-y-1">
                                    <li>• Kolom header: <span class="font-semibold">nama, nis, kelas, password</span></li>
                                    <li>• Kolom <span class="font-semibold">nama</span> dan <span class="font-semibold">nis</span> wajib diisi</li>
                                    <li>• Kolom <span class="font-semibold">kelas</span> dan <span class="font-semibold">password</span> opsional</li>
                                    <li>• Jika password kosong, akan otomatis sama dengan NIS</li>
                                    <li>• NIS tidak boleh ada yang sama (tidak boleh duplikat)</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Download Template -->
                    <div class="bg-gray-50 rounded-xl p-4 border-2 border-gray-200">
                        <div class="flex items-center justify-between gap-4">
                            <div class="flex items-center gap-3 flex-1">
                                <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">Template Excel</p>
                                    <p class="text-sm text-gray-500">Download template untuk mempermudah import</p>
                                </div>
                            </div>
                            <button type="button" wire:click="downloadTemplate"
                                    class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-semibold transition duration-200 flex items-center gap-2 flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                                Download
                            </button>
                        </div>
                    </div>

                    <!-- Upload File -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Upload File Excel *</label>
                        <input type="file" 
                               wire:model="fileImport" 
                               accept=".xlsx,.xls,.csv"
                               class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-green-500 focus:ring-4 focus:ring-green-100 outline-none transition">
                        @error('fileImport') 
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p> 
                        @enderror
                        
                        <!-- File Preview -->
                        @if($fileImport)
                            <div class="mt-3 p-3 bg-green-50 border border-green-200 rounded-lg flex items-center gap-2">
                                <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="text-sm text-green-800 font-medium">File siap diupload: {{ $fileImport->getClientOriginalName() }}</span>
                            </div>
                        @endif

                        <!-- Loading State -->
                        <div wire:loading wire:target="fileImport" class="mt-2">
                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Memproses file...
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-3 pt-4">
                        <button type="submit"
                                wire:loading.attr="disabled"
                                wire:target="prosesImport"
                                class="flex-1 py-3 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-xl font-semibold hover:shadow-lg transition duration-300 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                            <span wire:loading.remove wire:target="prosesImport" class="flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                                Import File
                            </span>
                            <span wire:loading wire:target="prosesImport" class="flex items-center gap-2">
                                <svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Mengimport...
                            </span>
                        </button>
                        <button type="button" 
                                wire:click="$set('modalImport', false)"
                                wire:loading.attr="disabled"
                                wire:target="prosesImport"
                                class="px-6 py-3 bg-gray-200 text-gray-700 rounded-xl font-semibold hover:bg-gray-300 transition duration-300 disabled:opacity-50 disabled:cursor-not-allowed">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>