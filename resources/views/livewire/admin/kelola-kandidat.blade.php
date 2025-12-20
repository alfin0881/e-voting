<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Kelola Kandidat</h1>
            <p class="text-gray-600 mt-1">Atur dan kelola kandidat pemilihan</p>
        </div>
        <button wire:click="bukaTambah" 
                class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-violet-600 text-white rounded-xl font-semibold hover:shadow-xl transition duration-300 hover:scale-105 flex items-center gap-2 justify-center">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Tambah Kandidat
        </button>
    </div>

    <!-- Filter -->
    <div class="bg-white rounded-2xl shadow-lg p-6">
        <div class="flex items-center gap-4">
            <label class="text-sm font-semibold text-gray-500">Filter Pemilihan:</label>
            <select wire:model.live="pemilihanDipilih" 
                    class="flex-1 max-w-md px-4 py-2.5 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 outline-none transition">
                <option value="">Semua Pemilihan</option>
                @foreach($pemilihanList as $p)
                    <option value="{{ $p->id }}">{{ $p->nama_pemilihan }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Kandidat Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($kandidatList as $kandidat)
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-300 hover:scale-105 group">
                <!-- Photo -->
                <div class="relative h-64 bg-gradient-to-br from-indigo-100 to-violet-100 overflow-hidden">
                    @if($kandidat->foto)
                        <img src="{{ Storage::url($kandidat->foto) }}" 
                             alt="{{ $kandidat->nama_kandidat }}"
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <svg class="w-24 h-24 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                    @endif
                    
                    <!-- Nomor Urut Badge -->
                    <div class="absolute top-4 left-4 w-14 h-14 bg-gradient-to-br from-indigo-600 to-violet-600 rounded-xl flex items-center justify-center shadow-lg">
                        <span class="text-white font-bold text-xl">{{ $kandidat->nomor_urut }}</span>
                    </div>

                    <!-- Actions Overlay -->
                    <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center gap-3">
                        <button wire:click="bukaEdit({{ $kandidat->id }})"
                                class="p-3 bg-blue-500 text-white rounded-xl hover:bg-blue-600 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </button>
                        <button wire:click="hapus({{ $kandidat->id }})"
                                wire:confirm="Apakah Anda yakin ingin menghapus kandidat ini?"
                                class="p-3 bg-red-500 text-white rounded-xl hover:bg-red-600 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Info -->
                <div class="p-6">
                    <span class="inline-block px-3 py-1 bg-indigo-100 text-indigo-700 text-xs font-semibold rounded-full mb-3">
                        {{ $kandidat->pemilihan->nama_pemilihan }}
                    </span>
                    
                    <h3 class="font-bold text-xl text-gray-800 mb-2">{{ $kandidat->nama_kandidat }}</h3>
                    
                    @if($kandidat->visi)
                        <div class="mb-3">
                            <p class="text-xs font-semibold text-gray-500 mb-1">VISI</p>
                            <p class="text-sm text-gray-700 line-clamp-2">{{ $kandidat->visi }}</p>
                        </div>
                    @endif
                    
                    @if($kandidat->misi)
                        <div>
                            <p class="text-xs font-semibold text-gray-500 mb-1">MISI</p>
                            <p class="text-sm text-gray-700 line-clamp-3">{{ $kandidat->misi }}</p>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <p class="text-gray-500 font-medium">Belum ada data kandidat</p>
                    <p class="text-gray-400 text-sm mt-1">Klik tombol "Tambah Kandidat" untuk memulai</p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Modal Tambah -->
    @if($modalTambah)
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 p-4 animate-fade-in">
            <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto animate-scale-up">
                <div class="sticky top-0 bg-gradient-to-r from-indigo-600 to-violet-600 text-white px-6 py-4 rounded-t-2xl">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-bold">Tambah Kandidat Baru</h3>
                        <button wire:click="$set('modalTambah', false)" class="text-white hover:bg-white/20 p-2 rounded-lg transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <form wire:submit="simpan" class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Pemilihan *</label>
                        <select wire:model="pemilihan_id"
                                class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 outline-none transition">
                            <option value="">Pilih Pemilihan</option>
                            @foreach($pemilihanList as $p)
                                <option value="{{ $p->id }}">{{ $p->nama_pemilihan }}</option>
                            @endforeach
                        </select>
                        @error('pemilihan_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Kandidat *</label>
                            <input type="text" wire:model="nama_kandidat" 
                                   class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 outline-none transition"
                                   placeholder="Nama lengkap kandidat">
                            @error('nama_kandidat') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor Urut *</label>
                            <input type="text" wire:model="nomor_urut" 
                                   class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 outline-none transition"
                                   placeholder="Contoh: 01">
                            @error('nomor_urut') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Foto Kandidat (Opsional)</label>
                        <input type="file" wire:model="foto" accept="image/*"
                               class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 outline-none transition">
                        @error('foto') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        @if($foto)
                            <div class="mt-3">
                                <img src="{{ $foto->temporaryUrl() }}" class="w-32 h-32 object-cover rounded-xl">
                            </div>
                        @endif
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Visi</label>
                        <textarea wire:model="visi" rows="3"
                                  class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 outline-none transition"
                                  placeholder="Visi kandidat..."></textarea>
                        @error('visi') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Misi</label>
                        <textarea wire:model="misi" rows="4"
                                  class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 outline-none transition"
                                  placeholder="Misi kandidat..."></textarea>
                        @error('misi') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
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

    <!-- Modal Edit (similar to Modal Tambah) -->
    @if($modalEdit)
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 p-4 animate-fade-in">
            <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto animate-scale-up">
                <div class="sticky top-0 bg-gradient-to-r from-indigo-600 to-violet-600 text-white px-6 py-4 rounded-t-2xl">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-bold">Edit Kandidat</h3>
                        <button wire:click="$set('modalEdit', false)" class="text-white hover:bg-white/20 p-2 rounded-lg transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <form wire:submit="perbarui" class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Pemilihan *</label>
                        <select wire:model="pemilihan_id"
                                class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 outline-none transition">
                            <option value="">Pilih Pemilihan</option>
                            @foreach($pemilihanList as $p)
                                <option value="{{ $p->id }}">{{ $p->nama_pemilihan }}</option>
                            @endforeach
                        </select>
                        @error('pemilihan_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Kandidat *</label>
                            <input type="text" wire:model="nama_kandidat" 
                                   class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 outline-none transition">
                            @error('nama_kandidat') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor Urut *</label>
                            <input type="text" wire:model="nomor_urut" 
                                   class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 outline-none transition">
                            @error('nomor_urut') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Foto Baru (Opsional)</label>
                        @if($fotoLama)
                            <div class="mb-2">
                                <p class="text-sm text-gray-600 mb-2">Foto saat ini:</p>
                                <img src="{{ Storage::url($fotoLama) }}" class="w-32 h-32 object-cover rounded-xl">
                            </div>
                        @endif
                        <input type="file" wire:model="foto" accept="image/*"
                               class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 outline-none transition">
                        @error('foto') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        @if($foto)
                            <div class="mt-2">
                                <p class="text-sm text-gray-600 mb-2">Preview foto baru:</p>
                                <img src="{{ $foto->temporaryUrl() }}" class="w-32 h-32 object-cover rounded-xl">
                            </div>
                        @endif
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Visi</label>
                        <textarea wire:model="visi" rows="3"
                                  class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 outline-none transition"></textarea>
                        @error('visi') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Misi</label>
                        <textarea wire:model="misi" rows="4"
                                  class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 outline-none transition"></textarea>
                        @error('misi') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
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
</div>