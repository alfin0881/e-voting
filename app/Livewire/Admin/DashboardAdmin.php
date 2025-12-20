<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Pemilihan;
use App\Models\User;
use App\Models\Suara;
use App\Models\Kandidat;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin')]

class DashboardAdmin extends Component
{
    public $totalPemilihan;
    public $totalUser;
    public $totalSuara;
    public $totalKandidat;
    public $pemilihanAktif;

    public function mount()
    {
        $this->totalPemilihan = Pemilihan::count();
        $this->totalUser = User::where('role', 'user')->count();
        $this->totalSuara = Suara::count();
        $this->totalKandidat = Kandidat::count();
        $this->pemilihanAktif = Pemilihan::where('status', 'aktif')->get();
    }

    public function render()
    {
        return view('livewire.admin.dashboard-admin');
    }
}