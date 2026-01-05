<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

#[Layout('layouts.guest')]
class Login extends Component
{
    public $nis;
    public $password;

    protected $rules = [
        'nis' => 'required',
        'password' => 'required',
    ];

    protected $messages = [
        'nis.required' => 'NIS wajib diisi',
        'password.required' => 'Password wajib diisi',
    ];

    public function login()
    {
        $this->validate();

        $user = User::where('nis', $this->nis)->first();

        if (!$user) {
            $this->addError('nis', 'NIS atau password salah.');
            return;
        }

        // ===== ADMIN (password hash) =====
        if ($user->role === 'admin') {
            if (!Hash::check($this->password, $user->password)) {
                $this->addError('nis', 'NIS atau password salah.');
                return;
            }
        }

        // ===== USER (password plain) =====
        if ($user->role === 'user') {
            if ($this->password !== $user->password) {
                $this->addError('nis', 'NIS atau password salah.');
                return;
            }
        }

        // LOGIN RESMI LARAVEL
        Auth::login($user, true);
        request()->session()->regenerate();

        session()->flash('success', 'Login berhasil. Selamat datang!');

        return redirect()->to(
            $user->role === 'admin'
                ? route('admin.dashboard')
                : route('user.daftar-pemilihan')
        );

    }

    public function logout()
    {
        Auth::logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('masuk');
    }


    public function render()
    {
        return view('livewire.auth.login');
    }
}
