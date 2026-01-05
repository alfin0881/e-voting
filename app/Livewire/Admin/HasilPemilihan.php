<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Pemilihan;
use App\Models\Kandidat;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin')]
class HasilPemilihan extends Component
{
    public $allHasilData = [];
    public int $refreshInterval = 1; // menit

    public function mount()
    {
        $this->reloadData();
    }

    // ⚠️ JANGAN pakai #[On] di sini
    public function reloadData()
    {
        $data = [];
        $pemilihanList = Pemilihan::latest()->get();

        foreach ($pemilihanList as $pemilihan) {
            $data[] = $this->hitungStatistik($pemilihan);
        }

        // update data
        $this->allHasilData = $data;

        // 🔥 trigger JS (animasi + chart refresh)
        $this->dispatch('data-updated');
    }

    private function hitungStatistik($pemilihan)
    {
        $kandidatList = Kandidat::where('pemilihan_id', $pemilihan->id)
            ->withCount('suara')
            ->orderBy('nomor_urut', 'asc')
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

        return [
            'pemilihan' => [
                'nama_pemilihan' => $pemilihan->nama_pemilihan,
            ],
            'kandidat'    => $kandidatList,
            'total_suara' => $pemilihan->totalSuara(),
        ];
    }

    public function getColor($nomorUrut)
    {
        return [
            '01' => '#0c4780ff',
            '02' => '#fdca13ff',
            '03' => '#f63b3eff',
            '04' => '#10B981',
            '05' => '#8B5CF6',
        ][$nomorUrut] ?? '#9CA3AF';
    }

    public function render()
    {
        return view('livewire.admin.hasil-pemilihan');
    }
}
