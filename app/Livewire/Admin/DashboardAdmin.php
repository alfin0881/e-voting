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
    public $totalSiswaSudahMemilih; // Tambahkan ini

    public function mount()
    {
        $this->totalPemilihan = Pemilihan::count();
        // Menghitung jumlah akun dengan role 'user'
        $this->totalUser = User::where('role', 'user')->count(); 
        
        // Total seluruh kertas suara masuk (akumulasi)
        $this->totalSuara = Suara::count(); 
        
        // Menghitung SISWA UNIK yang sudah mencoblos minimal sekali
        // Agar persentase partisipasi tidak lebih dari 100%
        $this->totalSiswaSudahMemilih = User::where('role', 'user')
            ->whereHas('suara')
            ->count();

        $this->totalKandidat = Kandidat::count();
        $this->pemilihanAktif = Pemilihan::where('status', 'aktif')->get();
    }

    public function render()
    {
        return view('livewire.admin.dashboard-admin');
    }
}