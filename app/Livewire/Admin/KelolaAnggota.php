<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\User;
use App\Models\Pemilihan;
use Illuminate\Support\Facades\Hash;
use App\Imports\AnggotaImport;
use App\Exports\TemplateAnggotaExport;
use Livewire\Attributes\Layout;
use Maatwebsite\Excel\Facades\Excel;

#[Layout('layouts.admin')]
class KelolaAnggota extends Component
{
    use WithFileUploads;

    // Data
    public $anggotaList;
    public $pemilihanList;
    
    // Modal states
    public $modalTambah = false;
    public $modalEdit = false;
    public $modalPeserta = false;
    public $modalImport = false;
    
    // Form fields
    public $userId;
    public $nama;
    public $nis;
    public $kelas;
    public $password;
    public $userDipilih;
    public $pemilihanTerpilih = [];
    
    // Import
    public $fileImport;

    protected $rules = [
        'nama' => 'required|min:3',
        'nis' => 'required|unique:users,nis',
        'kelas' => 'nullable',
        'password' => 'required|min:6',
    ];

    protected $messages = [
        'nama.required' => 'Nama wajib diisi',
        'nama.min' => 'Nama minimal 3 karakter',
        'nis.required' => 'NIS wajib diisi',
        'nis.unique' => 'NIS sudah terdaftar',
        'password.required' => 'Password wajib diisi',
        'password.min' => 'Password minimal 6 karakter',
    ];

    public function mount()
    {
        $this->pemilihanList = Pemilihan::all();
        $this->muatData();
    }

    public function muatData()
    {
        $this->anggotaList = User::where('role', 'user')->latest()->get();
    }

    // ==================== CRUD METHODS ====================

    public function bukaTambah()
    {
        $this->reset(['nama', 'nis', 'kelas', 'password']);
        $this->modalTambah = true;
    }

    public function simpan()
    {
        $this->validate();

        User::create([
            'nama' => $this->nama,
            'nis' => $this->nis,
            'kelas' => $this->kelas,
            'password' => ($this->password),
            'role' => 'user',
        ]);

        $this->modalTambah = false;
        $this->muatData();
        $this->dispatch('notifikasi', pesan: 'Anggota berhasil ditambahkan!', tipe: 'success');
    }

    public function bukaEdit($id)
    {
        $user = User::findOrFail($id);
        
        $this->userId = $user->id;
        $this->nama = $user->nama;
        $this->nis = $user->nis;
        $this->kelas = $user->kelas;
        $this->password = ''; // Reset password field
        
        $this->modalEdit = true;
    }

    public function perbarui()
    {
        $this->validate([
            'nama' => 'required|min:3',
            'nis' => 'required|unique:users,nis,' . $this->userId,
            'kelas' => 'nullable',
        ]);

        $user = User::findOrFail($this->userId);

        $data = [
            'nama' => $this->nama,
            'nis' => $this->nis,
            'kelas' => $this->kelas,
        ];

        // Update password hanya jika diisi
        if ($this->password) {
            $data['password'] = ($this->password);
        }

        $user->update($data);

        $this->modalEdit = false;
        $this->muatData();
        $this->dispatch('notifikasi', pesan: 'Anggota berhasil diperbarui!', tipe: 'success');
    }

    public function hapus($id)
    {
        User::findOrFail($id)->delete();
        
        $this->muatData();
        $this->dispatch('notifikasi', pesan: 'Anggota berhasil dihapus!', tipe: 'success');
    }

    // ==================== PESERTA PEMILIHAN ====================

    public function bukaPeserta($id)
    {
        $this->userDipilih = User::findOrFail($id);
        $this->pemilihanTerpilih = $this->userDipilih->pemilihanDiikuti()->pluck('pemilihan.id')->toArray();
        $this->modalPeserta = true;
    }

    public function simpanPeserta()
    {
        $user = User::findOrFail($this->userDipilih->id);
        $user->pemilihanDiikuti()->sync($this->pemilihanTerpilih);
        
        $this->modalPeserta = false;
        $this->dispatch('notifikasi', pesan: 'Peserta pemilihan berhasil diperbarui!', tipe: 'success');
    }

    // ==================== IMPORT EXCEL ====================

    public function bukaImport()
    {
        $this->reset(['fileImport']);
        $this->modalImport = true;
    }

    public function downloadTemplate()
    {
        return Excel::download(new TemplateAnggotaExport(), 'template-import-anggota.xlsx');
    }

    public function prosesImport()
    {
        // Validasi file upload
        $this->validate([
            'fileImport' => 'required|mimes:xlsx,xls,csv|max:2048',
        ], [
            'fileImport.required' => 'File Excel wajib dipilih',
            'fileImport.mimes' => 'File harus berformat Excel (xlsx, xls, csv)',
            'fileImport.max' => 'Ukuran file maksimal 2MB',
        ]);

        try {
            // Proses import
            $import = new AnggotaImport();
            Excel::import($import, $this->fileImport->getRealPath());

            // Dapatkan hasil import
            $sukses = $import->getSukses();
            $gagal = $import->getGagal();

            // Reset state
            $this->modalImport = false;
            $this->reset(['fileImport']);
            $this->muatData();
            
            // Notifikasi berdasarkan hasil
            if ($gagal > 0) {
                $this->dispatch('notifikasi', 
                    pesan: "Import selesai! Berhasil: {$sukses}, Gagal: {$gagal} (NIS duplikat atau data tidak valid)", 
                    tipe: 'warning'
                );
            } else {
                $this->dispatch('notifikasi', 
                    pesan: "Import berhasil! {$sukses} anggota berhasil ditambahkan.", 
                    tipe: 'success'
                );
            }
            
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            // Error validasi Excel
            $failures = $e->failures();
            $errorRows = [];
            
            foreach ($failures as $failure) {
                $errorRows[] = $failure->row();
            }
            
            $this->dispatch('notifikasi', 
                pesan: 'Gagal import pada baris: ' . implode(', ', array_unique($errorRows)), 
                tipe: 'error'
            );
            
        } catch (\Exception $e) {
            // Error umum
            $this->dispatch('notifikasi', 
                pesan: 'Gagal import: ' . $e->getMessage(), 
                tipe: 'error'
            );
        }
    }

    // ==================== RENDER ====================

    public function render()
    {
        return view('livewire.admin.kelola-anggota');
    }
}