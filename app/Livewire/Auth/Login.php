<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

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

    public function masuk()
    {
        $this->validate();

        if (Auth::attempt(['nis' => $this->nis, 'password' => $this->password])) {
            session()->regenerate();

            if (auth()->user()->adalahAdmin()) {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('user.daftar-pemilihan');
        }

        $this->addError('nis', 'NIS atau password salah.');
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}