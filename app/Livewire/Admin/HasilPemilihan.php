<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Pemilihan;
use App\Models\Kandidat;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin')]

class HasilPemilihan extends Component
{
    public $pemilihanList;
    public $pemilihanDipilih;
    public $hasilData = [];

    public function mount()
    {
        $this->pemilihanList = Pemilihan::all();
    }

    public function updatedPemilihanDipilih($value)
    {
        if ($value) {
            $this->muatHasil($value);
        } else {
            $this->hasilData = [];
        }
    }

    public function muatHasil($pemilihanId)
    {
        $pemilihan = Pemilihan::findOrFail($pemilihanId);
        
        $kandidatList = Kandidat::where('pemilihan_id', $pemilihanId)
            ->withCount('suara')
            ->orderBy('suara_count', 'desc')
            ->get()
            ->map(function ($k) {
                return [
                    'nama_kandidat' => $k->nama_kandidat,
                    'nomor_urut'    => $k->nomor_urut,
                    'suara_count'   => $k->suara_count,
                    'persentase'    => $k->persentaseSuara(),
                ];
            })
            ->toArray();

        $this->hasilData = [
            'pemilihan'    => [
                'nama_pemilihan'  => $pemilihan->nama_pemilihan,
                'tanggal_mulai'   => $pemilihan->tanggal_mulai,
                'tanggal_selesai' => $pemilihan->tanggal_selesai,
            ],
            'kandidat'     => $kandidatList,
            'total_suara'  => $pemilihan->totalSuara(),
        ];
    }


    public function render()
    {
        return view('livewire.admin.hasil-pemilihan');
    }
}