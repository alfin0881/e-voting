<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Pemilihan;
use App\Models\Kandidat;
use App\Models\Suara;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin')]
class HasilPemilihan extends Component
{
    public $allHasilData = [];
    public int $lastSuaraCount = 0;

    public function mount()
    {
        $this->reloadData();
        $this->lastSuaraCount = Suara::count();
    }

    // polling ringan
    public function checkUpdate()
    {
        if (Suara::count() > $this->lastSuaraCount) {
            // sengaja kosong → UI tetap diam
        }
    }

    // refresh data
    public function reloadData()
    {
        $data = [];

        foreach (Pemilihan::latest()->get() as $pemilihan) {
            $total = Suara::where('pemilihan_id', $pemilihan->id)->count();

            $data[] = [
                'pemilihan' => ['nama_pemilihan' => $pemilihan->nama_pemilihan],
                'kandidat' => Kandidat::where('pemilihan_id', $pemilihan->id)
                    ->withCount('suara')
                    ->orderBy('nomor_urut')
                    ->get()
                    ->map(fn ($k) => [
                        'nama_kandidat' => $k->nama_kandidat,
                        'nomor_urut' => $k->nomor_urut,
                        'suara_count' => $k->suara_count,
                        'persentase' => $total === 0 ? 0 : round(($k->suara_count / $total) * 100, 2),
                    ])->toArray(),
                'total_suara' => $total,
            ];
        }

        $this->allHasilData = $data;
        $this->lastSuaraCount = Suara::count();
    }

    public function refreshNow()
    {
        $this->reloadData();
        $this->dispatch('manual-refresh');
    }

    public function getColor($nomorUrut)
    {
        return [
            '01' => '#0c4780ff',
            '02' => '#e3b612ff',
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
