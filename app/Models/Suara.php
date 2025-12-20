<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Suara extends Model
{
    protected $table = 'suara';

    protected $fillable = [
        'user_id',
        'pemilihan_id',
        'kandidat_id',
        'waktu_memilih',
    ];

    protected $casts = [
        'waktu_memilih' => 'datetime',
    ];

    // Relasi: Suara milik satu user
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Suara untuk satu pemilihan
    public function pemilihan(): BelongsTo
    {
        return $this->belongsTo(Pemilihan::class);
    }

    // Relasi: Suara untuk satu kandidat
    public function kandidat(): BelongsTo
    {
        return $this->belongsTo(Kandidat::class);
    }
}