<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kandidat extends Model
{
    protected $table = 'kandidat';

    protected $fillable = [
        'pemilihan_id',
        'nama_kandidat',
        'nomor_urut',
        'foto',
        'visi',
        'misi',
    ];

    // Relasi: Kandidat milik satu pemilihan
    public function pemilihan(): BelongsTo
    {
        return $this->belongsTo(Pemilihan::class);
    }

    // Relasi: Kandidat memiliki banyak suara
    public function suara(): HasMany
    {
        return $this->hasMany(Suara::class);
    }

    // Hitung total suara kandidat
    public function totalSuara(): int
    {
        return $this->suara()->count();
    }

    // Hitung persentase suara
    public function persentaseSuara(): float
    {
        $totalSuaraPemilihan = $this->pemilihan->totalSuara();
        
        if ($totalSuaraPemilihan === 0) {
            return 0;
        }

        return round(($this->totalSuara() / $totalSuaraPemilihan) * 100, 2);
    }
}