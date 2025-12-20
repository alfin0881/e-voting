<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\Pemilihan;
use App\Models\Kandidat;

class LihatKandidat extends Component
{
    public $pemilihan;
    public $kandidatList;
    public $sudahMemilih = false;
    public $modalKonfirmasi = false;
    public $kandidatDipilih;

    public function mount($pemilihanId)
    {
        $this->pemilihan = Pemilihan::findOrFail($pemilihanId);
        
        // Cek apakah user mengikuti pemilihan ini
        if (!auth()->user()->pemilihanDiikuti->contains($this->pemilihan->id)) {
            return redirect()->route('user.daftar-pemilihan')
                ->with('error', 'Anda tidak terdaftar dalam pemilihan ini.');
        }

        $this->kandidatList = Kandidat::where('pemilihan_id', $pemilihanId)->get();
        $this->sudahMemilih = auth()->user()->sudahMemilih($pemilihanId);
    }

    public function bukaKonfirmasi($kandidatId)
    {
        if ($this->sudahMemilih) {
            $this->dispatch('notifikasi', pesan: 'Anda sudah memilih di pemilihan ini!', tipe: 'error');
            return;
        }

        $this->kandidatDipilih = Kandidat::findOrFail($kandidatId);
        $this->modalKonfirmasi = true;
    }

    public function pilih()
    {
        if ($this->sudahMemilih) {
            $this->dispatch('notifikasi', pesan: 'Anda sudah memilih di pemilihan ini!', tipe: 'error');
            return;
        }

        auth()->user()->suara()->create([
            'pemilihan_id' => $this->pemilihan->id,
            'kandidat_id' => $this->kandidatDipilih->id,
            'waktu_memilih' => now(),
        ]);

        return redirect()->route('user.terima-kasih');
    }

    public function render()
    {
        return view('livewire.user.lihat-kandidat')
            ->layout('layouts.user');
    }
}