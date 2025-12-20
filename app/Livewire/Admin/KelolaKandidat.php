<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Kandidat;
use App\Models\Pemilihan;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin')]

class KelolaKandidat extends Component
{
    use WithFileUploads;

    public $kandidatList;
    public $pemilihanList;
    public $modalTambah = false;
    public $modalEdit = false;
    
    public $kandidatId;
    public $pemilihan_id;
    public $nama_kandidat;
    public $nomor_urut;
    public $foto;
    public $fotoLama;
    public $visi;
    public $misi;
    public $pemilihanDipilih = '';

    protected $rules = [
        'pemilihan_id' => 'required|exists:pemilihan,id',
        'nama_kandidat' => 'required|min:3',
        'nomor_urut' => 'required',
        'foto' => 'nullable|image|max:2048',
        'visi' => 'nullable',
        'misi' => 'nullable',
    ];

    protected $messages = [
        'pemilihan_id.required' => 'Pemilihan wajib dipilih',
        'pemilihan_id.exists' => 'Pemilihan tidak valid',
        'nama_kandidat.required' => 'Nama kandidat wajib diisi',
        'nama_kandidat.min' => 'Nama kandidat minimal 3 karakter',
        'nomor_urut.required' => 'Nomor urut wajib diisi',
        'foto.image' => 'File harus berupa gambar',
        'foto.max' => 'Ukuran gambar maksimal 2MB',
    ];

    public function mount()
    {
        $this->pemilihanList = Pemilihan::all();
        $this->muatData();
    }

    public function muatData()
    {
        if ($this->pemilihanDipilih) {
            $this->kandidatList = Kandidat::where('pemilihan_id', $this->pemilihanDipilih)
                ->with('pemilihan')
                ->latest()
                ->get();
        } else {
            $this->kandidatList = Kandidat::with('pemilihan')->latest()->get();
        }
    }

    public function updatedPemilihanDipilih()
    {
        $this->muatData();
    }

    public function bukaTambah()
    {
        $this->reset(['nama_kandidat', 'nomor_urut', 'foto', 'visi', 'misi', 'pemilihan_id']);
        $this->modalTambah = true;
    }

    public function simpan()
    {
        $this->validate();

        $data = [
            'pemilihan_id' => $this->pemilihan_id,
            'nama_kandidat' => $this->nama_kandidat,
            'nomor_urut' => $this->nomor_urut,
            'visi' => $this->visi,
            'misi' => $this->misi,
        ];

        if ($this->foto) {
            $data['foto'] = $this->foto->store('foto-kandidat', 'public');
        }

        Kandidat::create($data);

        $this->modalTambah = false;
        $this->muatData();
        $this->dispatch('notifikasi', pesan: 'Kandidat berhasil ditambahkan!', tipe: 'success');
    }

    public function bukaEdit($id)
    {
        $kandidat = Kandidat::findOrFail($id);
        
        $this->kandidatId = $kandidat->id;
        $this->pemilihan_id = $kandidat->pemilihan_id;
        $this->nama_kandidat = $kandidat->nama_kandidat;
        $this->nomor_urut = $kandidat->nomor_urut;
        $this->visi = $kandidat->visi;
        $this->misi = $kandidat->misi;
        $this->fotoLama = $kandidat->foto;
        
        $this->modalEdit = true;
    }

    public function perbarui()
    {
        $this->validate();

        $kandidat = Kandidat::findOrFail($this->kandidatId);

        $data = [
            'pemilihan_id' => $this->pemilihan_id,
            'nama_kandidat' => $this->nama_kandidat,
            'nomor_urut' => $this->nomor_urut,
            'visi' => $this->visi,
            'misi' => $this->misi,
        ];

        if ($this->foto) {
            if ($this->fotoLama) {
                Storage::disk('public')->delete($this->fotoLama);
            }
            $data['foto'] = $this->foto->store('foto-kandidat', 'public');
        }

        $kandidat->update($data);

        $this->modalEdit = false;
        $this->muatData();
        $this->dispatch('notifikasi', pesan: 'Kandidat berhasil diperbarui!', tipe: 'success');
    }

    public function hapus($id)
    {
        $kandidat = Kandidat::findOrFail($id);
        
        if ($kandidat->foto) {
            Storage::disk('public')->delete($kandidat->foto);
        }
        
        $kandidat->delete();
        
        $this->muatData();
        $this->dispatch('notifikasi', pesan: 'Kandidat berhasil dihapus!', tipe: 'success');
    }

    public function render()
    {
        return view('livewire.admin.kelola-kandidat');
    }
}