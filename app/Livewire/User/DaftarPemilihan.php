<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\Pemilihan;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.user')]

class DaftarPemilihan extends Component
{
    public $pemilihanList;

    public function mount()
    {
        // Hanya tampilkan pemilihan yang aktif dan user ikuti
        $this->pemilihanList = Auth::user()
            ->pemilihanDiikuti()
            ->where('status', 'aktif')
            ->get();
    }

    public function render()
    {
        return view('livewire.user.daftar-pemilihan');
    }
}