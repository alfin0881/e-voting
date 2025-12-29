<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Pemilihan;
use App\Models\Kandidat;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin')]

class HasilPemilihan extends Component
{
    // Kita ubah dari $hasilData (single) menjadi $allHasilData (array of arrays)
    public $allHasilData = [];

    public function mount()
    {
        // 1. Ambil semua pemilihan, urutkan dari yang terbaru (opsional)
        $semuaPemilihan = Pemilihan::latest()->get();

        // 2. Loop setiap pemilihan untuk hitung statistiknya
        foreach ($semuaPemilihan as $pemilihan) {
            $this->allHasilData[] = $this->hitungStatistik($pemilihan);
        }
    }

    /**
     * Fungsi helper untuk menghitung data per satu pemilihan
     */
    private function hitungStatistik($pemilihan)
    {
        // Ambil kandidat untuk pemilihan ini
        $kandidatList = Kandidat::where('pemilihan_id', $pemilihan->id)
            ->withCount('suara') // Eager load jumlah suara agar lebih cepat
            ->orderBy('suara_count', 'desc') // Urutkan suara terbanyak (Peringkat 1 diatas)
            ->get()
            ->map(function ($k) {
                return [
                    'nama_kandidat' => $k->nama_kandidat,
                    'nomor_urut'    => $k->nomor_urut,
                    'suara_count'   => $k->suara_count,
                    // Pastikan model Kandidat memiliki method persentaseSuara()
                    // atau hitung manual: ($k->suara_count / $total) * 100
                    'persentase'    => $k->persentaseSuara(), 
                    // Tambahkan Visi Misi untuk fitur "Lihat Detail" di tampilan baru
                    'visi'          => $k->visi,
                    'misi'          => $k->misi,
                ];
            })
            ->toArray();

        return [
            'pemilihan'    => [
                'nama_pemilihan'  => $pemilihan->nama_pemilihan,
                'tanggal_mulai'   => $pemilihan->tanggal_mulai,
                'tanggal_selesai' => $pemilihan->tanggal_selesai,
            ],
            'kandidat'     => $kandidatList,
            'total_suara'  => $pemilihan->totalSuara(),
        ];
    }

    // Tambahkan method ini di dalam class HasilPemilihan
    public function getColor($nomorUrut)
    {
        // Pemetaan Warna Statis berdasarkan Nomor Urut
        $mapWarna = [
            '01' => '#3287d6ff', 
            '02' => '#F59E0B',
            '03' => '#f63b3eff', 
            '04' => '#10B981', 
            '05' => '#8B5CF6',
        ];

        // Jika nomor urut tidak ada di daftar, berikan warna abu-abu sebagai fallback
        return $mapWarna[$nomorUrut] ?? '#9CA3AF';
    }
    public function render()
    {
        return view('livewire.admin.hasil-pemilihan');
    }
}