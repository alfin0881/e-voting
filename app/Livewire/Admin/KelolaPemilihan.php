<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Pemilihan;

use Livewire\Attributes\Layout;

#[Layout('layouts.admin')]
class KelolaPemilihan extends Component
{

    public $pemilihanList;
    public $modalTambah = false;
    public $modalEdit = false;
    
    public $pemilihanId;
    public $nama_pemilihan;
    public $deskripsi;
    public $tanggal_mulai;
    public $tanggal_selesai;
    public $status = 'nonaktif';

    protected $rules = [
        'nama_pemilihan' => 'required|min:3',
        'deskripsi' => 'nullable',
        'tanggal_mulai' => 'required|date',
        'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        'status' => 'required|in:aktif,nonaktif',
    ];

    public function mount()
    {
        $this->muatData();
    }

    public function muatData()
    {
        $this->pemilihanList = Pemilihan::latest()->get();
    }

    public function bukaTambah()
    {
        $this->reset(['nama_pemilihan', 'deskripsi', 'tanggal_mulai', 'tanggal_selesai', 'status']);
        $this->status = 'nonaktif';
        $this->modalTambah = true;
    }

    public function simpan()
    {
        $this->validate();

        Pemilihan::create([
            'nama_pemilihan' => $this->nama_pemilihan,
            'deskripsi' => $this->deskripsi,
            'tanggal_mulai' => $this->tanggal_mulai,
            'tanggal_selesai' => $this->tanggal_selesai,
            'status' => $this->status,
        ]);

        $this->modalTambah = false;
        $this->muatData();
    }


    public function bukaEdit($id)
    {
        $pemilihan = Pemilihan::findOrFail($id);
        
        $this->pemilihanId = $pemilihan->id;
        $this->nama_pemilihan = $pemilihan->nama_pemilihan;
        $this->deskripsi = $pemilihan->deskripsi;
        $this->tanggal_mulai = $pemilihan->tanggal_mulai ? \Carbon\Carbon::parse($pemilihan->tanggal_mulai)->format('Y-m-d') : null;
        $this->tanggal_selesai = $pemilihan->tanggal_selesai ? \Carbon\Carbon::parse($pemilihan->tanggal_selesai)->format('Y-m-d') : null;
        $this->status = $pemilihan->status;
        $this->modalEdit = true;
    }

    public function perbarui()
    {
        $this->validate();

        $pemilihan = Pemilihan::findOrFail($this->pemilihanId);

        $data = [
            'nama_pemilihan' => $this->nama_pemilihan,
            'deskripsi' => $this->deskripsi,
            'tanggal_mulai' => $this->tanggal_mulai,
            'tanggal_selesai' => $this->tanggal_selesai,
            'status' => $this->status,
        ];

        $pemilihan->update($data);

        $this->modalEdit = false;
        $this->muatData();
    }

    public function hapus($id)
    {
        $pemilihan = Pemilihan::findOrFail($id);

        $pemilihan->delete();
        $this->muatData();
    }

    public function ubahStatus($id)
    {
        $pemilihan = Pemilihan::findOrFail($id);

        $pemilihan->status = $pemilihan->status === 'aktif'
            ? 'nonaktif'
            : 'aktif';

        $pemilihan->save();
        $this->muatData();
    }

    public function render()
    {
        return view('livewire.admin.kelola-pemilihan');
    }
}
