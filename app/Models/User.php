<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'nama',
        'nis',
        'kelas',
        'password',
        'role',
        'foto',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // protected function casts(): array
    // {
    //     return [
    //         'password' => 'hashed',
    //     ];
    // }

    // Relasi: User bisa memilih banyak kandidat
    public function suara()
    {
        return $this->hasMany(Suara::class);
    }

    // Relasi: User mengikuti banyak pemilihan
    public function pemilihanDiikuti()
    {
        return $this->belongsToMany(Pemilihan::class, 'peserta_pemilihan', 'user_id', 'pemilihan_id')
                    ->withTimestamps();
    }

    // Cek apakah user adalah admin
    public function adalahAdmin(): bool
    {
        return $this->role === 'admin';
    }

    // Cek apakah user sudah memilih di pemilihan tertentu
    public function sudahMemilih($pemilihanId): bool
    {
        return $this->suara()->where('pemilihan_id', $pemilihanId)->exists();
    }
}