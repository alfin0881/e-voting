<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Pemilihan extends Model
{
    protected $table = 'pemilihan';

    protected $fillable = [
        'nama_pemilihan',
        'deskripsi',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
        'logo',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    public function kandidat(): HasMany
    {
        return $this->hasMany(Kandidat::class);
    }

    public function peserta(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'peserta_pemilihan', 'pemilihan_id', 'user_id')
                    ->withTimestamps();
    }

    public function totalSuara(): int
    {
        return Suara::where('pemilihan_id', $this->id)->count();
    }

    public function sedangAktif(): bool
    {
        return $this->status === 'aktif';
    }
}