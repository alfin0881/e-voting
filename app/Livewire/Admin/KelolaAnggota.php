<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use App\Models\Pemilihan;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Illuminate\Support\Str;
use Livewire\Attributes\Url;

#[Layout('layouts.admin')]

class KelolaAnggota extends Component
{
    // ... properti yang sudah ada ...
    public $anggotaList;
    public $pemilihanList;
    public $modalTambah = false;
    public $modalEdit = false;
    public $modalPeserta = false;
    
    // Properti filter
    #[Url] 
    public $filterKelas = '';
    #[Url]
    public $filterNis = '';
    #[Url]
    public $filterNama = '';

    // Properti Sortir BARU
    #[Url]
    public $sortField = 'nama'; // Default sorting field
    #[Url]
    public $sortDirection = 'asc'; // Default sorting direction
    
    public $userId;
    public $nama;
    public $nis;
    public $kelas;
    public $password;
    public $userDipilih;
    public $pemilihanTerpilih = [];

    // ... (protected $rules dan $messages tidak berubah) ...

    protected $rules = [
        'nama' => 'required|min:3',
        'nis' => 'required|unique:users,nis',
        'kelas' => 'nullable',
        'password' => 'required|min:6',
    ];

    protected $messages = [
        'nama.required' => 'Nama wajib diisi',
        'nama.min' => 'Nama minimal 3 karakter',
        'nis.required' => 'NIS wajib diisi',
        'nis.unique' => 'NIS sudah terdaftar',
        'password.required' => 'Password wajib diisi',
        'password.min' => 'Password minimal 6 karakter',
    ];

    public function mount()
    {
        $this->pemilihanList = Pemilihan::all();
        $this->muatData();
    }

    // MEMPERBARUI LOGIKA muatData() UNTUK MENAMBAHKAN SORTING
    public function muatData()
    {
        $query = User::where('role', 'user')
            ->with('pemilihanDiikuti');

        // Filter
        if ($this->filterKelas) {
            $query->where('kelas', $this->filterKelas);
        }
        if ($this->filterNis) {
            $query->where('nis', 'like', '%' . $this->filterNis . '%');
        }
        if ($this->filterNama) {
            $query->where('nama', 'like', '%' . $this->filterNama . '%');
        }

        // Sorting
        $query->orderBy($this->sortField, $this->sortDirection);

        $this->anggotaList = $query->get();
    }

    // METHOD BARU UNTUK SORTING
    public function sortBy($field)
    {
        // Jika field yang sama diklik, balikkan arahnya (asc/desc)
        if ($field === $this->sortField) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            // Jika field berbeda diklik, ganti field dan set arah ke 'asc'
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
        $this->muatData();
    }

    // ... (getKelasListProperty, hapusSemuaFilter, hapusFilterKelas, dll. tidak berubah) ...

    public function getKelasListProperty()
    {
        return User::where('role', 'user')
            ->whereNotNull('kelas')
            ->distinct()
            ->pluck('kelas')
            ->sort()
            ->values()
            ->toArray();
    }

    public function hapusSemuaFilter()
    {
        $this->reset(['filterKelas', 'filterNis', 'filterNama']);
        $this->muatData();
    }

    public function hapusFilterKelas()
    {
        $this->filterKelas = '';
        $this->muatData();
    }

    public function hapusFilterNis()
    {
        $this->filterNis = '';
        $this->muatData();
    }

    public function hapusFilterNama()
    {
        $this->filterNama = '';
        $this->muatData();
    }

    public function bukaTambah()
    {
        $this->reset(['nama', 'nis', 'kelas', 'password']);
        $this->modalTambah = true;
    }

    public function simpan()
    {
        $this->validate();

        User::create([
            'nama' => $this->nama,
            'nis' => $this->nis,
            'kelas' => $this->kelas,
            'password' => Hash::make($this->password),
            'role' => 'user',
        ]);

        $this->modalTambah = false;
        $this->muatData();
        $this->dispatch('notifikasi', pesan: 'Anggota berhasil ditambahkan!', tipe: 'success');
    }

    public function bukaEdit($id)
    {
        $user = User::findOrFail($id);
        
        $this->userId = $user->id;
        $this->nama = $user->nama;
        $this->nis = $user->nis;
        $this->kelas = $user->kelas;
        $this->password = '';
        
        $this->modalEdit = true;
    }

    public function perbarui()
    {
        $rulesEdit = [
            'nama' => 'required|min:3',
            'nis' => 'required|unique:users,nis,' . $this->userId,
            'kelas' => 'nullable',
        ];

        if ($this->password) {
             $rulesEdit['password'] = 'min:6';
        }
        
        $this->validate($rulesEdit);

        $user = User::findOrFail($this->userId);

        $data = [
            'nama' => $this->nama,
            'nis' => $this->nis,
            'kelas' => $this->kelas,
        ];

        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        $user->update($data);

        $this->modalEdit = false;
        $this->muatData();
        $this->dispatch('notifikasi', pesan: 'Anggota berhasil diperbarui!', tipe: 'success');
    }

    public function hapus($id)
    {
        User::findOrFail($id)->delete();
        
        $this->muatData();
        $this->dispatch('notifikasi', pesan: 'Anggota berhasil dihapus!', tipe: 'success');
    }

    public function bukaPeserta($id)
    {
        $this->userDipilih = User::findOrFail($id);
        $this->pemilihanTerpilih = $this->userDipilih->pemilihanDiikuti()->pluck('pemilihan.id')->toArray();
        $this->modalPeserta = true;
    }

    public function simpanPeserta()
    {
        $user = User::findOrFail($this->userDipilih->id);
        $user->pemilihanDiikuti()->sync($this->pemilihanTerpilih);
        
        $this->modalPeserta = false;
        $this->dispatch('notifikasi', pesan: 'Peserta pemilihan berhasil diperbarui!', tipe: 'success');
    }

    // Watcher untuk semua filter/sort (agar muatData dipanggil)
    public function updated($property)
    {
        // Panggil muatData jika properti yang diubah adalah filter
        if (Str::startsWith($property, 'filter')) {
            $this->muatData();
        }
    }

    public function getStatusFilterProperty()
    {
        $filters = [];
        
        if ($this->filterKelas) {
            $filters[] = [
                'name' => 'Kelas', 
                'value' => $this->filterKelas,
                'method' => 'hapusFilterKelas'
            ];
        }
        
        if ($this->filterNis) {
            $filters[] = [
                'name' => 'NIS', 
                'value' => $this->filterNis,
                'method' => 'hapusFilterNis'
            ];
        }
        
        if ($this->filterNama) {
            $filters[] = [
                'name' => 'Nama', 
                'value' => $this->filterNama,
                'method' => 'hapusFilterNama'
            ];
        }
        
        return $filters;
    }

    public function render()
    {
        return view('livewire.admin.kelola-anggota', [
            'kelasList' => $this->kelasList,
            'activeFilters' => $this->getStatusFilterProperty(),
        ]);
    }
}