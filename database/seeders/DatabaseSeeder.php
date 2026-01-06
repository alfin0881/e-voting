<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Pemilihan;
use App\Models\Kandidat;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'nama' => 'Admin',
            'nis' => 'admin',
            'kelas' => null,
            'password' => Hash::make('123'),
            'role' => 'admin',
        ]);
    }
}